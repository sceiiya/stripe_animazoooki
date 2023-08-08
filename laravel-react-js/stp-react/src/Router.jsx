import { Routes, Route, Navigate} from 'react-router-dom'
import DefaultLayout from './views/layouts/DefaultLayout';
import LandingPage from './views/LandingPage';
import Login from './views/Login';
import Signup from './views/Signup';

const AppRoutes = () => {
  return (
    <Routes>
      <Route path='/' element={<Navigate to="/home" />} />
      <Route path='/home' element={<LandingPage />} />
      <Route 
        path='/' 
        element={<DefaultLayout />} 
        children=
        {[
            <Route path='/login' element={<Login />} />,
            <Route path='/signup' element={<Signup />} />
        ]}
      />
    </Routes>
  );
};

export default AppRoutes;
