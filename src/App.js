import logo from './logo.svg';
import './App.css';
import { Link, Route, Router, Routes } from 'react-router-dom';
import { Login } from './pages/Login.js';
import { Home } from './pages/Home.js';
import { CreationCompte } from './pages/CreationCompte.js';

function App() {
  return (
    <div id="appWrapper" className="App">
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/login" element={<Login />} />
        <Route path="/create_account" element={<CreationCompte />} />
      </Routes>
    </div>
  );
}

export default App;
