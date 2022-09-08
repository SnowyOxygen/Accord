import React from "react";
import { useState } from "react";

function Connection({setHasAccount, setEmail, setPassword}){
    const [tempEmail, setTempEmail] = useState('');
    const [tempPass, setTempPass] = useState('');

    const [warningsList, setWarningsList] = useState([]);

    const checkDetails = () => {
        
        //TODO: check with backend

        if(tempEmail !== "" && tempPass !== ""){
            setEmail(tempEmail);
            setPassword(tempPass);
        }
    } 

    const toggleWarning = (warning, toggle) => {
        if(toggle){
            setWarningsList((list) => [...list].filter(x => x != warning));
        }
        else
        {
            if(!warningsList.includes(warning)){
                setWarningsList((list) => [...list, warning]);
            }
        }
    }

    const regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/gi;

    const checkEmail = (e) => { //Check for email structure
        var emailInput = document.getElementById("emailInput");
        var warning = "email pas valide";

        if(regex.test(e)){
            emailInput.setAttribute("className", "cInput cField valid");
            setTempEmail(e);

            toggleWarning(warning, true);
            
        } 
        else{
            emailInput.setAttribute("className", "cInput cField invalid");

            toggleWarning(warning, false);

            setTempEmail("");
        }
    }

    const checkPassword = (e) => { //Check for password structure
        var lWarning = "mot de passe trop court"

        if(e.length >= 8){
            toggleWarning(lWarning, true);
            setTempPass(e);
        }else{
            toggleWarning(lWarning, false);
            setTempPass("");
        }
    }

    return(
        <div>
            <div className="connection">
                <input
                    id="emailInput"
                    className="cInput cField"
                    onChange={(event) => {checkEmail(event.target.value)}}
                    type="email"
                    placeholder="email"
                    required 
                    maxLength="32"/>
                <input
                    id="passwordInput"
                    className="cInput cField"
                    onChange={(event) => {checkPassword(event.target.value)}}
                    type="password"
                    placeholder="password"
                    required 
                    maxLength="20"/>
                <button onClick={() => checkDetails()}>Se connecter</button>
                {
                    warningsList.length > 0 ? (
                        warningsList.map((warning, index) => {
                            return (
                                <p className="warning" key={index}>{warning}</p>
                            )
                        })
                    ) : (
                        <p></p>
                    )
                }
            </div>
            <button
              onClick={() => setHasAccount(false)}
              className="hasAccount">
                Je n'ai pas de compte.
            </button>
        </div>
    )
}

export default Connection;