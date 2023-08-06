<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Customer;
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
            'cancel_url' => route('checkout.cancel', [], true),
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

        $session = Session::retrieve($sessionId);   
        if(!$session) {
            throw new NotFoundHttpException();
        }

        // $customer = Customer::retrieve($session->customer);
        $customer = $session->customer_details;
        return view('product.checkout.success', compact('customer'));
    }

    public function cancel(Request $request)
    {
        return view('product.checkout.cancel');
    }

    public function orders()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

}
