import EmailSent from "./features/auth/components/EmailSent"
import EmailVerify from "./features/auth/components/EmailVerify"
import Register from "./features/auth/components/Register"
import { Routes, Route, BrowserRouter } from "react-router-dom"

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/secretary/register" element={<Register />} />
        <Route path="/secretary/email-sent" element={<EmailSent />} />
        <Route path="/secretary/email-verify/:id/:hash" element={<EmailVerify />} />
      </Routes>
    </BrowserRouter>
  )
}

export default App
