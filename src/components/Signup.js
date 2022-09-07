import React from "react";
import { useState } from "react";

function Signup({setHasAccount}){
    //Form data
    const [tempEmail, setTempEmail] = useState('');
    const [tempPass, setTempPass] = useState('');
    const [tempConfPass, setTempConfPass] = useState('');

    //Warning messages for user if details are incorrect.
    const [warnings, setWarning] = useState([]);

    //reg expression for email structure
    const regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/gi;

    const checkDetails = () => {
        /*TODO: check email for valid structure
        check pseudonym for bad words
        check password for valid structure
        check all for xss vulnerability
        */
    }
    
    return(
        <div className="signup">
            <div className="signup-form">
                <input
                  onChange={(event) => setTempEmail(event.target.value)}
                  type="email"
                  placeholder="email@email.com"
                  required 
                  maxLength="32"/>
                <input
                  onChange={(event) => setTempPass(event.target.value)}
                  type="password"
                  placeholder="password"
                  required 
                  maxLength="20"/>
                <input
                  onChange={(event) => setTempConfPass(event.target.value)}
                  type="password"
                  placeholder="confirm password"
                  required 
                  maxLength="20"/>
                <button onClick={() => checkDetails()}>Créer</button>
            </div>
            <button
                onClick={() => setHasAccount(true)}
                className="hasAccount">
                J'ai déjà un compte.
            </button>
        </div>
    )
}

export default Signup;