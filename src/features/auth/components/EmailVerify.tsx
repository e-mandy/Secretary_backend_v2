import { useEffect } from "react"
import { useEmailVerify } from "../api/useEmailVerify"
import { useNavigate, useParams, useSearchParams } from "react-router-dom"
import Spinner from "../../../components/Spinner";
import Success from "../../../components/Success";

const EmailVerify = () => {
    const { isPending, mutate, isSuccess } = useEmailVerify();
    const navigate = useNavigate();

    // We pick the id and the hash from the link sent in the user email
    const { id, hash } = useParams<{id: string, hash: string}>();

    // We pick the expiration value and the verification link signature from the link
    const [searchParams] = useSearchParams();
    const expirationValue = searchParams.get('expires');
    const signature = searchParams.get('signature');

    if(!id || !hash || !expirationValue || !signature) return ;
    
    useEffect(() => {
        mutate({
            id: id,
            hash: hash,
            expires: expirationValue,
            signature: signature
        });
    }, []);

    useEffect(() => {
        const timeoutId = setTimeout(() => {
            navigate("/");
        }, 5000);

        return () => clearTimeout(timeoutId);
    }, [isSuccess, navigate])

    if(isPending) return (
        <div className="flex w-screen h-screen m-auto">
            <Spinner width="30" height="30" color="white" visible={true} />
            <p>Patientez un petit moment encore !!</p>
        </div>
    )

    if(isSuccess) return (
        <div className="w-screen h-screen flex m-auto">
            <Success />
            <p>Bravo !! Votre email est vérifiée. Vous allez étre redirigé sur votre espace dans quelques instants.</p>
        </div>
    )
}

export default EmailVerify
