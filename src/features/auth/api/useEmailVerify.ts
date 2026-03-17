import { useMutation } from "@tanstack/react-query"
import type { EmailVerifyData } from "../schemas/email_verify.schema";
import axiosInstance from "../../../api/axiosInstance";
import { useAuthStore } from "../store/auth.store";
import type { UserApiResponse } from "../schemas/auth_store.schema";

const verifyEmail = async(data: EmailVerifyData) => {
    const response = await axiosInstance.get(`/secretary/email-verify/${data.id}/${data.hash}`, {
        params: {
            expires: data.expires,
            signature: data.signature
        }
    });
    return response.data;
}

export const useEmailVerify = () => {
    const { setAuthStore } = useAuthStore();

    return useMutation({
        mutationFn: verifyEmail,
        onSuccess: (data) => {
            console.log("Everything is good");
            const userData: UserApiResponse = {
                user: data.user,
                token: data.token
            };

            setAuthStore(userData);
        }
    });
}