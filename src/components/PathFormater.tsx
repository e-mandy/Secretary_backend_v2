import { useLocation, Link } from 'react-router-dom';

const PathFormater = () => {
    const locate = useLocation();

  return (
    <div className='flex gap-2 w-full bg-red-300 py-4 px-6'>
        <Link to="/" className='hover:underline'>Tableau de bord</Link>
        { locate?.pathname && locate.pathname !== "/" && (
            <span>
                / <Link to={locate?.pathname} className='hover:underline'>{locate?.pathname.split('/')[2].charAt(0).toUpperCase() + locate?.pathname.split('/')[2].slice(1)}</Link>
            </span>
        ) }
    </div>
  );
}

export default PathFormater
