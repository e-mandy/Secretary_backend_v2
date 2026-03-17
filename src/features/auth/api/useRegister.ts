import { useMutation } from "@tanstack/react-query";
import axiosInstance from "../../../api/axiosInstance"
import type { RegisterUser } from "../schemas/register.schema"
import { useNavigate } from "react-router-dom";

const register = async (user: RegisterUser) => {
    const response = await axiosInstance.post('/secretary/register', user);
    return response.data;
}

export const useRegister = () => {
    const navigate = useNavigate();

    return useMutation({
        mutationFn: register,
        onSuccess: (data) => {
            console.log(data);
            navigate('/secretary/email-sent');
        },
        onError: (error) => {
            console.log(error);
        }
    })
}