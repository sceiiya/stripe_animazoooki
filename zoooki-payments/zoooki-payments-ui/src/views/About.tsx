import { Helmet } from "react-helmet-async"

const About = () =>
{   
    return <>
        <Helmet>
            <title>About | Zoooki Collabs</title>
            <meta name="description" content="Zooki collabs is a merchant with product that are anime merchandises and clothes partnered to our brand." />
            <link rel="canonical" href="/about" data-rh="true" />
        </Helmet>
        <div>
            <h1>This is About page that you see</h1>
        </div>
    </>
}

export default About