import { Helmet } from "react-helmet-async"

const Success = () =>
{   
    return <>
        <Helmet>
            <title>Congrats! Ordered Successfully | Zoooki Collabs</title>
            <meta name="description" content="Successful payment and order now processing." />
            <link rel="canonical" href="/success" data-rh="true" />
        </Helmet>
        <div>
            <h1>Ordered Successfully</h1>
        </div>
    </>
}

export default Success