import { Helmet } from "react-helmet-async"
import HeroSection from "../components/HeroSection"

const Home = () =>
{   
    return <>
        <Helmet>
            <title>Zoooki Collabs</title>
            <meta name="description" content="Zooki collabs we sell anime merchandises and clothes partnered to our brand." />
            <link rel="canonical" href="/home" data-rh="true" />
        </Helmet>
        <div className="container">
        <HeroSection/>
        </div>
    </>
}

export default Home