import React, { useState } from 'react';
import './App.css';
import Navbar from './components/Navbar';
import {BrowserRouter as Router, Route, Routes} from 'react-router-dom'
import Livros from './peges/Livros';
import Autores from './peges/Autores';
import Assuntos from './peges/Assuntos';
import {ToastContainer} from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import LivrosCreate from './views/livros/LivrosCreate';
import LivrosEdit from './views/livros/LivrosEdit';
import AutoresCreate from './views/autores/AutoresCreate';
import AutoresEdit from './views/autores/AutoresEdit';
import AssuntosCreate from './views/assuntos/AssuntosCreate';
import AssuntosEdit from './views/assuntos/AssuntosEdit';

function App() {
    const [sidebarOpen, setSidebarOpen] = useState(false);
    return (
        <>
            <ToastContainer/>
            <Router>
                <Navbar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen}/>
                <div
                  className="main-content"
                  style={{ marginLeft: sidebarOpen ? 250 : 0, transition: 'margin-left 0.35s' }}
                >
                  <Routes>
                      <Route path='/livros' element={<Livros/>}/>
                      <Route path='/livros/novo' element={<LivrosCreate/>}/>
                      <Route path='/livros/editar/:id' element={<LivrosEdit/>}/>
                      <Route path='/autores' element={<Autores/>}/>
                      <Route path='/autores/novo' element={<AutoresCreate/>}/>
                      <Route path='/autores/editar/:id' element={<AutoresEdit/>}/>
                      <Route path='/assuntos' element={<Assuntos/>}/>
                      <Route path='/assuntos/novo' element={<AssuntosCreate/>}/>
                      <Route path='/assuntos/editar/:id' element={<AssuntosEdit/>}/>
                  </Routes>
                </div>
            </Router>
        </>
    );
}

export default App;
