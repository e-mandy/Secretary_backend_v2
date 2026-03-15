import { useMutation } from "@tanstack/react-query"
import type { EmailVerifyData } from "../schemas/email_verify.schema";
import axiosInstance from "../../../api/axiosInstance";
import { useAuthStore } from "../store/auth.store";
import type { UserApiResponse } from "../schemas/auth_store.schema";
import { useNavigate } from "react-router-dom";

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
    const navigate = useNavigate();

    return useMutation({
        mutationFn: verifyEmail,
        onSuccess: (data) => {
            const userData: UserApiResponse = {
                user: data.user,
                token: data.token
            };

            setAuthStore(userData);

            const timeoutId = setTimeout(() => {
                navigate('/');
            }, 1000);
        }
    });
}