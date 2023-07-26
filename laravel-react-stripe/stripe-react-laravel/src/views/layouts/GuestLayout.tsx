import { Outlet } from "react-router-dom"

const GuestLayout = () => {
    return <>
        <h1>Guest here</h1>
        <Outlet />
    </>
}

export default GuestLayout