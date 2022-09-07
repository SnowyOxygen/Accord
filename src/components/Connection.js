import React from "react";
import { useState } from "react";

function Connection({setHasAccount, setEmail, setPassword}){
    const [tempEmail, setTempEmail] = useState('');
    const [tempPass, setTempPass] = useState('');

    const checkDetails = () => {
        //TODO: check for invalid characters, character requirements etc
        setEmail(tempEmail);
        setPassword(tempPass);
    }

    return(
        <div>
            <div className="connection">
                <input
                    className="cInput cField"
                    onChange={(event) => {setTempEmail(event.target.value)}}
                    type="email"
                    placeholder="email"
                    required 
                    maxLength="32"/>
                <input
                    className="cInput cField"
                    onChange={(event) => {setTempPass(event.target.value)}}
                    type="password"
                    placeholder="password"
                    required 
                    maxLength="20"/>
                <button onClick={() => checkDetails()}></button>
            </div>
            <button
              onClick={setHasAccount(false)}
              className="hasAccount">
                J'ai déjà un compte.
            </button>
        </div>
    )
}

export default Connection;