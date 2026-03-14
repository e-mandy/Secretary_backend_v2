import { Info, MailSearch, MoveLeft } from "lucide-react"
import Spinner from "../../../components/Spinner"
import { useParams, useSearchParams } from "react-router-dom"

const EmailVerify = () => {
    // We pick the id and the hash from the link sent in the user email
    const { id, hash } = useParams<{id: string, hash: string}>();

    // We pick the expiration value and the verification link signature from the link
    const [searchParams] = useSearchParams();
    const expirationValue = searchParams.get('expires');
    const signature = searchParams.get('signature');

  return (
    <div className="h-screen w-screen flex">
      <div className="flex flex-col items-center mx-auto w-187.5 mt-32">
        <div className="p-6 rounded-full bg-[#111624] mb-8"><MailSearch size={50} color="#5f79be"/></div>
        <h2 className="font-bold text-3xl mb-4">Vérifiez votre adresse email</h2>
        <div className="flex flex-col items-center my-6 gap-3">
            <Spinner width="28" height="28" color="white" visible={true} />
            <p className="text-xl font-semibold">En attente de vérification</p>
        </div>
        <p className="text-sm my-4">Cette page se refraichira automatiquement une fois la vérification terminée.</p>
        <p className="text-center w-3/4 bg-[#1f2841] text-white p-3 rounded-lg font-semibold flex gap-2 mb-8">
            <Info size={40} color="red"/>Nous vous avons envoyer un lien à votre adresse email. Cliquez s'il vous plait sur le lien pour confirmer votre adresse email et débuter votre journée avec Secretary Esgis.
        </p>
        <p className="flex gap-2"><MoveLeft /> Retour à la page de connexion</p>
      </div>
    </div>
  )
}

export default EmailVerify;