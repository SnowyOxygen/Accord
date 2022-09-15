import React, { useEffect, useRef } from 'react';
import { useState, createContext, useContext } from "react";
import './App.css';

//Components
import Home from "./components/Home";
import ChatBox from './components/ChatBox';

export const PopupContext = createContext();


export function getCookie(name) {
     
  let r = document.cookie.split(";").map(e=>{let key = e.split("=")[0].trim();
                        let value = decodeURIComponent(e.split("=")[1]); return {name:key, value:value}});
  let index = r.findIndex(e=>e.name == name);
  if(index >-1){
      return r[index];
  }else{
      return false;
  }
}


function App() {
  const [email, setEmail] = useState('');
  //TODO: Rendre password illisible dans console
  const [webSocket, setWebSocket] = useState({});
  const [password, setPassword] = useState('');
  const [isAuth, setIsAuth] = useState(false);
  const[state_, setState_] = useState({});

 

  //CALLBACK OF newUserData
  let event = (e)=>{
    console.log("new User data ", e.detail)
  }
  useEffect(()=>{
    ///window.addEventListener("newUserData", event);

    let i = getCookie("infos");
   
    if(i !== false){
      console.log(" cookies ", i);
      setState_({...state_, ...i})
    }
    console.log(i);
  

    //return ()=>window.removeEventListener("newUserData", event);
  }, [])
  //TODO: screen width / on mobile

  const [ppContent, setppContent] = useState(<div></div>);
  const [ppDisplay, setppDisplay] = useState('none');

  return (
    <PopupContext.Provider value={ {webSoket: webSocket, setppContent : setppContent, setppDisplay : setppDisplay, auth: {isAuth: isAuth, setIsAuth: setIsAuth}, state_:{state_:state_, setState_:setState_}
    }}>
      <div style={{display: ppDisplay}} >
        {ppContent}
      </div>
      <div id="appWrapper" className="App">
        { isAuth ? 
            <ChatBox email={email}
            password={setPassword}/>:
          <Home setEmail={setEmail}
                setPassword={setPassword}/>
        }
      </div>
    </PopupContext.Provider>
  );
}

export default App;
