import esgis_logo from "../assets/auth/logo-esgis.png"
import {
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarHeader,
} from "@/components/ui/sidebar"

const SideBar = () => {
  return (
    <div className="h-full">
      <div className="flex flex-col justify-start pl-10 py-3 border-b border-gray-300">
        <img src={esgis_logo} className="md:w-30" />
        <h1 className="text-2xl font-extrabold">Secretary Esgis</h1>
      </div>

      <div>
        
      </div>
    </div>
  )
}

export default SideBar
