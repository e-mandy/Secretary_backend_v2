import { Lock, Mail, User } from "lucide-react";
import { useRegister } from "../api/useRegister";
import { useForm, type SubmitHandler } from "react-hook-form";
import { registerSchema, type RegisterUser } from "../schemas/register.schema";
import { zodResolver } from "@hookform/resolvers/zod";
import Spinner from "../../../components/Spinner";
import secretaryImg from "../../../assets/auth/secretary.jpeg";

const Register = () => {
    const { mutate, isPending } = useRegister();

    const { handleSubmit, register, formState: { errors }, reset } = useForm<RegisterUser>({
        resolver: zodResolver(registerSchema)
    });

    const onSubmit: SubmitHandler<RegisterUser> = async (registerFormData) => {
        reset();
        mutate(registerFormData);
    }

  return (
    <div className="h-screen relative flex">
        <div className="w-1/2 h-screen flex">
            <div className="m-auto w-[55%]">
                <div className="mb-10">
                    <h2 className="text-4xl font-extrabold text-[#111624]">Inscription</h2>
                    <p>Bienvenue sur la plateforme de gestion du sécrétariat de Esgis</p>
                </div>
                <form onSubmit={handleSubmit(onSubmit)}>
                    <div className="my-3">
                        <label htmlFor="lastname" className="font-semibold">Nom de famille</label>
                        <div className="input-style">
                            <User />
                            <input {...register('lastname')} className="outline-none flex-1 py-3 pl-2" type="text" name="lastname" id="lastname" />
                        </div>
                            {errors.lastname?.message && (<span className="error-message">{errors.lastname?.message}</span>)}
                    </div>

                    <div className="my-3">
                        <label htmlFor="firstname" className="font-semibold">Prénom</label>
                        <div className="input-style">
                            <User />
                            <input {...register('firstname')} className="outline-none flex-1 py-3 pl-2" type="text" name="firstname" id="firstname" />
                        </div>
                            {errors.firstname?.message && (<span className="error-message">{errors.firstname?.message}</span>)}
                    </div>

                    <div className="my-3">
                        <label htmlFor="email" className="font-semibold">Adresse Email</label>
                        <div className="input-style">
                            <Mail />
                            <input {...register('email')} className="outline-none flex-1 py-3 pl-2" type="email" name="email" id="email" />
                        </div>
                            {errors.email?.message && (<span className="error-message">{errors.email?.message}</span>)}
                    </div>

                    <div className="my-3">
                        <label htmlFor="password" className="font-semibold">Mot de passe</label>
                        <div className="input-style">
                            <Lock />
                            <input {...register('password')} className="outline-none flex-1 py-3 pl-2" type="password" name="password" id="password" />
                        </div>
                            {errors.password?.message && (<span className="error-message">{errors.password?.message}</span>)}
                    </div>

                    <div className="my-3">
                        <label htmlFor="password_confirmation" className="font-semibold">Confirmer votre mot de passe</label>
                        <div className="input-style">
                            <Lock />
                            <input {...register('password_confirmation')} className="outline-none flex-1 py-3 pl-2" type="password" name="password_confirmation" id="password_confirmation" />
                        </div>
                            {errors.password_confirmation?.message && (<span className="error-message">{errors.password_confirmation?.message}</span>)}
                    </div>
                    <button type="submit" className="bg-[#c41c2d] w-full text-white py-3 rounded-lg my-6 cursor-pointer active:bg-[#d15c68] flex gap-3 justify-center shadow-lg shadow-[#d15c68]">
                        {isPending && (<Spinner color="white" height="24" width="24" visible={true} />)}
                        <p>{ isPending ? "Chargement" : "S'inscrire en tant que sécrétaire" }</p>
                    </button>
                    <p>Vous avez déjà un compte sécrétaire ? <span className="text-[#c41c2d] font-semibold">Connectez-vous !!</span></p>
                </form>
            </div>
        </div>
        <div className="w-1/2 h-full flex bg-linear-to-tl from-white to-[#F3E1E3]">
        {/* <div className="absolute top-0 z-[-2] h-screen w-screen bg-white "></div> */}
        
        <div className="m-auto flex flex-col items-center">
            <img className="w-70 h-70 rounded-lg mb-6" src={secretaryImg} alt="" />
            <h2 className="text-2xl font-bold"></h2>
        </div>
            
        </div>
    </div>
  )
}

export default Register
