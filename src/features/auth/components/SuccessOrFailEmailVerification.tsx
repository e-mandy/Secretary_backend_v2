import { useEffect, useState } from "react"
import { useEmailVerify } from "../api/useEmailVerify"
import { useParams, useSearchParams } from "react-router-dom"
import Spinner from "../../../components/Spinner";

const SuccessOrFailEmailVerification = () => {
    const { isPending, mutate } = useEmailVerify();
    const [isVerified, setIsVerified] = useState(false);

    // We pick the id and the hash from the link sent in the user email
    const { id, hash } = useParams<{id: string, hash: string}>();

    // We pick the expiration value and the verification link signature from the link
    const [searchParams] = useSearchParams();
    const expirationValue = searchParams.get('expires');
    const signature = searchParams.get('signature');

    useEffect(() => {
        if(!id || !hash || !expirationValue || !signature) return ;

        mutate({
            id: id,
            hash: hash,
            expires: expirationValue,
            signature: signature
        });
    })

    if(isPending) return (
        <div className="flex w-screen h-screen m-auto">
            <Spinner width="30" height="30" color="white" visible={true} />
            <p>Patientez un petit moment encore !!</p>
        </div>
    )
}

export default SuccessOrFailEmailVerification
