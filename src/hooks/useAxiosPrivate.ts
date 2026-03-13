import { useLayoutEffect } from "react"
import { useAuthStore } from "../features/auth/store/auth.store";

export const useAxiosPrivate = () => {
    const { token } = useAuthStore();

    useLayoutEffect(() => {

    }, [token]);
}