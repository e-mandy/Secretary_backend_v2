import { LayoutDashboard, School, Settings, User2, Users } from "lucide-react"
import { Sidebar, SidebarContent, SidebarFooter, SidebarGroup, SidebarGroupLabel, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from "./ui/sidebar"

const AppSideBar = () => {

  const navItems = [
  {
    label: "Menu Principal",
    items: [
      { title: "Tableau de Bord", icon: LayoutDashboard, href: "/" },
      { title: "Professeurs", icon: Users, href: "/users" },
      { title: "Documents", icon: Settings, href: "/settings" },
    ],
  },
]

  return (
    <Sidebar className="w-full">
      <SidebarHeader>
        <div className="flex items-center gap-3 px-2 py-3">
          <div className="flex h-8 w-8 items-center justify-center rounded-md bg-primary text-primary-foreground">
            <School className="h-4 w-4" />
          </div>
          <div className="flex flex-col">
            <h2>Gestion du Sécrétariat</h2>
          </div>
        </div>
      </SidebarHeader>
      <SidebarContent>
        {navItems.map((group) => (
          <SidebarGroup key={group.label}>
            <SidebarGroupLabel className="text-xl my-2">{group.label}</SidebarGroupLabel>
            <SidebarMenu className="my-2">
              {group.items.map((item) => (
                <SidebarMenuItem key={item.title}>
                  <SidebarMenuButton asChild className="h-12">
                    <a href={item.href}>
                      <item.icon className="h-6 w-6" />
                      <span className="text-base">{item.title}</span>
                    </a>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              ))}
            </SidebarMenu>
          </SidebarGroup>
        ))}
      </SidebarContent>
       <SidebarFooter>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton>
              <User2 /> Username
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarFooter>
    </Sidebar>
  )
}

export default AppSideBar
