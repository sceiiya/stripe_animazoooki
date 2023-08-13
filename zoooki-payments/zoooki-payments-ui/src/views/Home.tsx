import { Helmet } from "react-helmet-async"

const Home = () =>
{   
    return <>
        <Helmet>
            <title>Zoooki Collabs</title>
            <meta name="description" content="Zooki collabs we sell anime merchandises and clothes partnered to our brand." />
            <link rel="canonical" href="/home" data-rh="true" />
        </Helmet>
        <div className="marg">blop</div>
        <div className="container meg">
            <h1>This is Homepage that you see</h1>
            <h2>Zoooki Stripe Collabs</h2>
            <div className="sectionated full-bleed">
                morg
            </div>
        </div>
        <div className="marg">blop</div>
    </>
}

export default Home