import { Routes, Route, Navigate } from 'react-router-dom';
import Login from './views/Login';
import Signup from './views/Signup';
import Users from './views/Users';
import Home from './views/Home';
import UserLayout from './views/layouts/UserLayout';
import GuestLayout from './views/layouts/GuestLayout';

const AppRoutes: React.FC = () => {
  return (
    <Routes>
      <Route path='/' element={<Navigate to="/home" />} />
      <Route path='/home' element={<Home />} />
      <Route 
        path='/' 
        element={<GuestLayout />} 
        children=
        {[
            <Route path='/login' element={<Login />} />,
            <Route path='/signup' element={<Signup />} />
        ]}
      />
      <Route 
        path='/' 
        element={<UserLayout />}
        children=
        {[
            <Route path='users' element={<Users />} />
        ]} 
      />
    </Routes>
  );
};

export default AppRoutes;
