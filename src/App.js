import React from 'react';
import { useState, createContext, useContext } from "react";
import './App.css';

//Components
import Home from "./components/Home";
import ChatBox from './components/ChatBox';

export const PopupContext = createContext();

function App() {
  const [email, setEmail] = useState('');
  //TODO: Rendre password illisible dans console
  const [password, setPassword] = useState('');

  //TODO: screen width / on mobile

  const [ppContent, setppContent] = useState(<div></div>);
  const [ppDisplay, setppDisplay] = useState('none');

  return (
    <PopupContext.Provider value={ {setppContent : setppContent, setppDisplay : setppDisplay}}>
      <div style={{display: ppDisplay}}>
        {ppContent}
      </div>
      <div id="appWrapper" className="App">
        {(email === "" || password === "") ? (
          <Home setEmail={setEmail}
                setPassword={setPassword}/>
        ) : (
          <ChatBox email={email}
                  password={setPassword}/>
        )}
      </div>
    </PopupContext.Provider>
  );
}

export default App;
