import { BrowserRouter as Router } from 'react-router-dom'
import './App.css'
import AppRoutes from './Router'

const App: React.FC = () => {

  return (
    <>
      <nav className='ps-4'>
        <a className='btn btn-primary mx-2' href="/login">login</a>&emsp;
        <a className='btn btn-warning mx-2' href="/signup">signup</a>&emsp;
        <a className='btn btn-danger mx-2' href="/users">users</a><hr/>
      </nav>
        Mie nai no?
      <Router>
        <AppRoutes />
      </Router>
    </>
  )
}

export default App
