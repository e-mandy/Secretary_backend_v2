import { Link, MailCheck, MoveLeft } from "lucide-react"

const EmailVerify = () => {

  return (
    <div className="h-screen w-screen flex bg-[#F8F6F6]">
      <div className="w-120 bg-white rounded-xl h-fit flex flex-col items-center m-auto p-6">
        <div className="p-4 rounded-full bg-[#F9E8EA] mb-6"><MailCheck color="#c41c2d" size={28} /></div>
        <h2 className="font-bold text-2xl mb-5">Vérifiez votre email</h2>
        <p className="text-center text-gray-500">Nous vous avons envoyé un lien de vérification à votre adresse email. Vérifiez votre boite de réception s'il vous plaît.</p>
      <a className="my-6 bg-[#c41c2d] text-white w-full py-4 rounded-2xl font-semibold text-center cursor-pointer" href="https://www.google.com/gmail" target="_blank">Ouvrir sa boite Email</a>  
      <Link to="/secretary/login" className="flex gap-2 mt-4">
        <MoveLeft/>
        Retour à la page de connexion
      </Link>
      </div>
    </div>
  )
}

export default EmailVerify;