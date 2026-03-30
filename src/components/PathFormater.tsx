import { useLocation, Link } from 'react-router-dom';

const PathFormater = () => {
    const locate = useLocation();

  return (
    <div className='flex gap-2 w-full bg-red-300'>
        <Link to="/">Tableau de bord</Link>
        { locate?.pathname && locate.pathname !== "/" && (
            <span>
                / <Link to={locate?.pathname}></Link>
            </span>
        ) }
    </div>
  );
}

export default PathFormater
