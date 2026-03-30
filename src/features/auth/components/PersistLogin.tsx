import { useEffect, useState, useRef } from 'react';
import Spinner from '../../../components/Spinner';
import { Outlet, useNavigate } from 'react-router-dom';
import { useRefreshToken } from '../../../hooks/useRefreshToken';
import { useAuth } from '../hooks/useAuth';

const PersistLogin = () => {
    const refresh = useRefreshToken();
    const [isLoading, setIsLoading] = useState(true);
    const isAuth = useAuth();
    const navigate = useNavigate();
    const isCalled = useRef(false);

    useEffect(() => {
        const verifyRefreshToken = async () => {
            try{
                await refresh();
            }catch(e: any){
                if(e?.response?.status === 401 || e?.response?.status === 403) {
                    console.log("Ça marche pas");
                    navigate('/secretary/login', { replace: true });
                }
            }finally{
                setIsLoading(false);
            }
        }

        if(!isCalled.current){
            isCalled.current = true;
            isAuth ? setIsLoading(false) : verifyRefreshToken();
        }
    }, []);

  return isLoading ? (
    <div className='h-screen w-screen flex m-auto justify-center items-center flex-col gap-4'>
        <Spinner width='40' height='40' color='red' visible={true} />
        <p className='text-xl'>Veuillez patienter un instant</p>
    </div>
  ) : <Outlet />
}

export default PersistLogin
