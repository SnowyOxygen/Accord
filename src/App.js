import React from 'react';
import { useState } from 'react';
import './App.css';

//Components
import Home from "./components/Home";
import ChatBox from './components/ChatBox';

function App() {
  const [email, setEmail] = useState('');
  //TODO: Rendre password illisible dans console
  const [password, setPassword] = useState('');

  return (
    <div id="appWrapper" className="App">
      {(email === "" || password === "") ? (
        <Home setEmail={setEmail}
              setPassword={setPassword}/>
      ) : (
        <ChatBox/>
      )}
    </div>
  );
}

export default App;
