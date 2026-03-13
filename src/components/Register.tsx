
const Register = () => {
  return (
    <div className="h-screen relative flex">
        <div className="absolute flex top-4 left-4">
            <h2 className="font-bold text-2xl">Esgis Secretary</h2>
        </div>
        <div className="w-1/2 h-full bg-[url(assets/auth/auth.jpeg)] bg-cover flex">
            <div className="my-auto w-3/4 ml-6">
                <h3 className="font-extrabold text-3xl">École Supérieure de Gestion d'Informatique et des Sciences.</h3>
                <p>Au service  de l'excellence académique et de l'inclusion professionnelle au Bénin.</p>
            </div>
        </div>
        <div className="w-1/2 h-screen flex">
            <div className="m-auto w-3/4">
                <h2 className="text-2xl font-bold">Inscription</h2>
                <p>Bienvenue sur la plateforme de gestion du sécrétariat de Esgis</p>
            </div>
            <div>

            </div>
        </div>
    </div>
  )
}

export default Register
