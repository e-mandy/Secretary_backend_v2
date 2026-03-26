import { Outlet } from "react-router-dom"
import SideBar from "./SideBar"
import NavBar from "./NavBar"

const AppLayout = () => {
  
    {/** We have to set up the default layout for the app. */}
    return (
        <div className="w-screen flex relative">
            <div className="w-72 fixed left-0 h-screen bg-white">
                <SideBar />
            </div>
            <div className="md:ml-72 relative w-full min-h-screen bg-yellow-300">
                <div className="fixed w-full bg-blue-300 h-20">
                    <NavBar />
                </div>
                <div className="mt-24">
                    <Outlet />
                </div>
            </div>
        </div>
    )
}

export default AppLayout
