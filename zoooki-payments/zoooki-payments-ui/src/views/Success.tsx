import { Helmet } from "react-helmet-async"

const Success = () =>
{   
    return <>
        <Helmet>
            <title>Congrats! Ordered Successfully | Zoooki Collabs</title>
            <meta name="description" content="Successful payment and order now processing." />
        </Helmet>
        <div>
            <h1>Ordered Successfullt</h1>
        </div>
    </>
}

export default Success