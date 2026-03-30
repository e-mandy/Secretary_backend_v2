import { Outlet } from "react-router-dom"
import NavBar from "./NavBar"
import { SidebarProvider } from "./ui/sidebar"
import AppSideBar from "./AppSideBar"
import PathFormater from "./PathFormater"

const AppLayout = () => {
  
    {/** We have to set up the default layout for the app. */}
    return (
        <div className="w-screen flex relative">
            <SidebarProvider defaultOpen>
                <div className="w-72 fixed left-0 h-screen bg-white">
                    <AppSideBar />
                </div>
                <div className="md:ml-72 relative w-full min-h-screen bg-yellow-300">
                    <div className="absolute top-0 w-full bg-white h-20">
                        <NavBar />
                    </div>
                    <div className="mt-20">
                        <PathFormater />
                        <Outlet />
                    </div>
                </div>
            </SidebarProvider>
        </div>
    )
}

export default AppLayout
