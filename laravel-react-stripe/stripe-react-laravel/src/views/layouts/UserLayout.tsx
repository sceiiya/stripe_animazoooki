import { Navigate, Outlet } from "react-router-dom"
import { useStateContext } from "../../contexts/ContextProvider"

const UserLayout = () => {
    const {user, token} = useStateContext()

    if (!token) {
        return <Navigate to="/login" />
    }

    return <>
        <h1>User here</h1>
        <Outlet />
    </>
}

export default UserLayout