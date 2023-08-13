import { Helmet } from "react-helmet-async"

const Contacts = () =>
{   
    return <>
        <Helmet>
            <title>Contacts | Zoooki Collabs</title>
            <meta name="description" content="For customer concerns and partnership proposal, please contact Zooki collabs with the information on this page." />
            <link rel="canonical" href="/contacts" data-rh="true" />
        </Helmet>
        <div>
            <h1>This is Contacts page</h1>
        </div>
    </>
}

export default Contacts