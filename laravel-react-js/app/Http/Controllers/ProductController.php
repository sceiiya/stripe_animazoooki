<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $products = Product::all();
        $lineItems = [];
        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                      'name' => $product->name,
                      'images' => [$product->image]
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => 1,
            ];
        }
        // the amount is multiplied to a 100 bcoz usd is specified in cents

        $checkout_session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true)."?session_id={CHECKOUT_SESSION_ID}",
          ]);

          $order = new Order();
          $order->status = 'unpaid';
          $order->total_price = $totalPrice;
          $order->session_id = $checkout_session->id;
          $order->save();

        return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->get('session_id');
        
        try {
            $session = Session::retrieve($sessionId);   
            if(!$session) {
                throw new NotFoundHttpException();
            }
    
            // $customer = Customer::retrieve($session->customer);
            $customer = $session->customer_details;

            // $order = Order::where('session_id', $session->id)->get();
            $order = Order::where('session_id', $session->id)->where('status', 'unpaid')->first();
            if (!$order) {
                throw new NotFoundHttpException();
            }

            if ($order && $order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }            
            // $customer = Customer::retrieve($session->customer);
            $customer = $session->customer_details;
            $data = ['name' => $customer->name];

            // Mail::send('payment.success', $data, function($message) use ($customer)
            // {
            //     $message->to($customer->email, $customer->name)->subject(env('APP_NAME').' | Payment Succeeded');
            //     $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            // });

            return view('product.checkout.success', compact('customer'));
    
        } catch (\Throwable $th) {
            throw new NotFoundHttpException();
        }
    }

    public function cancel(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->get('session_id');
        
        $session = Session::retrieve($sessionId);   
            if(!$session) {
                throw new NotFoundHttpException();
            }
    
            // $customer = Customer::retrieve($session->customer);
            $customer = $session->customer_details;
            $data = ['name' => $customer->name];

        Mail::send('payment.cancel', $data, function($message) use ($customer)
        {
            $message->to($customer->email, $customer->name)->subject(env('APP_NAME').' | Payment Cancelled');
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
        });
        return view('product.checkout.cancel');
    }

    public function orders()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    public function webhook()
    {
        // whsec_2f04ff869f00a7259eca6c504c1af130b364bf98ecf8f4c53b2f2d38d5605e69v

        // The library needs to be configured with your account's secret key.
        // Ensure the key is kept out of any version control system you might be using.
        
        // $stripe = new \Stripe\StripeClient('sk_test_...');
        // Stripe::setApiKey(env('STRIPE_SECRET'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
          $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
            return response('', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
          // Invalid signature
          return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
        //   case 'payment_intent.succeeded':
            case 'checkout.session.completed':
            $session = $event->data->object;
            $sessionId = $session->id;

             // $order = Order::where('session_id', $session->id)->get();
             $order = Order::where('session_id', $session->id)->first();
             if ($order && $order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();   

                //send email to customer\
                $sessionRet = Session::retrieve($sessionId);   
            
                // $customer = Customer::retrieve($session->customer);
                $customer = $sessionRet->customer_details;
                $data = ['name' => $customer->name];
    
                // Mail::send('payment.success', $data, function($message) use ($customer)
                // {
                //     $message->to($customer->email, $customer->name)->subject(env('APP_NAME').' | Payment Succeeded');
                //     $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                // });
             }
          // ... handle other event types
          default:
            echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    
    }

}

