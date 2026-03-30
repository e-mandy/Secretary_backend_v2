import AppLayout from "./components/AppLayout"
import EmailSent from "./features/auth/components/EmailSent"
import EmailVerify from "./features/auth/components/EmailVerify"
import Login from "./features/auth/components/Login"
import PersistLogin from "./features/auth/components/PersistLogin"
import Register from "./features/auth/components/Register"
import { Routes, Route, BrowserRouter } from "react-router-dom"
import Dashboard from "./features/dashboard/pages/Dashboard"
import Professors from "./features/professor/components/Professors"
import Documents from "./features/documents/components/Documents"

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/secretary/register" element={<Register />} />
        <Route path="/secretary/login" element={<Login />} />
        <Route path="/secretary/email-sent" element={<EmailSent />} />
        <Route path="/secretary/email-verify/:id/:hash" element={<EmailVerify />} />
        <Route element={<PersistLogin />}>

        {/** We have to set up the default layout for the app. */}
          <Route element={<AppLayout />}>
            {/** Now we can set each module route. */}
            <Route path="/" element={<Dashboard />} />
            <Route  path="/secretary/professors" element={<Professors />} />
            <Route path="/secretary/documents" element={<Documents />} />
          </Route>
        </Route>
      </Routes>
    </BrowserRouter>
  )
}

export default App
