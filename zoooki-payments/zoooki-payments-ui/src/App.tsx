import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom'
import { HelmetProvider } from 'react-helmet-async'
// import './App.css'
import Navbar from './components/Navbar';
import Home from './views/Home';
import About from './views/About';
import Contacts from './views/Contacts';
import Success from './views/Success';



function App() {

  return (
    <>
    <Navbar />
    <HelmetProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Navigate to="/home" />} />
          <Route path="/home" element={<Home />} />
          <Route path="/about" element={<About />} />
          <Route path="/contacts" element={<Contacts />} />
          {/* <Route path="/cart" element={<Cart />} /> */}

          <Route path="/success" element={<Success />} />
          {/* <Route path="*" element={<PageNotFound />} /> */}
        </Routes>
      </Router>
    </HelmetProvider>
    </>
  )
}

export default App
