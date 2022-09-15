import React, { useEffect, useContext } from "react";
import { useState } from "react";
import App from "../App";
import { PopupContext } from '../App';

function Connection({setHasAccount}){
    const [tempEmail, setTempEmail] = useState('');
    const [tempPass, setTempPass] = useState('');
    let [email, setEmail] = useState("");
    let [pwd, setPassword] = useState("");


    let context = useContext(PopupContext);
    let authContext = context.auth;
    let stateContext = context.state_;

    const [warningsList, setWarningsList] = useState([]);


    function getCookie(name) {
        
        let r = document.cookie.split(";").map(e=>{let key = e.split("=")[0]; let value = decodeURIComponent(e.split("=")[1]); return {name:key, value:value}});
        let index = r.findIndex(e=>e.name == name);
     
        if(index >-1){
            return r[index];
        }else{
            return false;
        }
      }

    useEffect(()=>{
        if(getCookie("auth")){
            authContext.setIsAuth(true);
            console.log("isAuth ", authContext.isAuth);
        }
    }, [])
    useEffect(()=>{
        setEmail(tempEmail);
    }, [tempEmail])
    useEffect(()=>{
        setPassword(tempPass);
    }, [tempPass])

    const checkDetails = () => {
        
        //TODO: check with backend

        if(tempEmail !== "" && tempPass !== ""){
            console.log("DATA SENT ", email, " ", pwd);
            fetch(process.env.REACT_APP_SERVER + "/signin.php", {credentials: "include",headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify({email: email, pwd: pwd})})
            .then(e=>
                e.json()
            )
            .then(e=>{console.log(e);
                if(e.message == true){
                    let c = getCookie("infos");
                    c = c?c:{};
                    stateContext.setState_({...stateContext.state_, ...c});
                    console.log("STATE UPDATED ", stateContext.state_);
                authContext.setIsAuth(true);
                console.log(authContext.isAuth);
            }});
            

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

        if(e.length >= 0){
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
                    {tempEmail}
                <input
                    id="passwordInput"
                    className="cInput cField"
                    onChange={(event) => {checkPassword(event.target.value)}}
                    type="password"
                    placeholder="password"
                    required 
                    maxLength="20"/>
                    {tempPass}
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