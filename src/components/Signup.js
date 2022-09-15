import React, { useRef } from "react";
import { useState } from "react";

function Signup({setHasAccount}){
    //Form data
    const [tempEmail, setTempEmail] = useState('');
    const [tempPass, setTempPass] = useState('');
    const [tempConfPass, setTempConfPass] = useState('');


    let [firstname, setFirstName] = useState("");
    let [lastname, setLastName] = useState("");
    let [email, setEmail] = useState("");
    let [pwd, setPwd] = useState("");
    let [pwd_rec, setPwd_rec] = useState("");

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
   
    //INSCRIPTION
    
    
    function submit(){
      let server = "http://localhost:4000/orm";

      console.log("submit ",{firstname, lastname, email, pwd, pwd_rec});
    fetch(server+"/signup.php", {headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify({firstname, lastname, email, pwd})})
    .then(e=>
        e.text()
    )
    .then(e=>console.log(e));
    }
    return(
        <div className="signup">
            <div className="signup-form">
              <input
                    onChange={(event) => setFirstName(event.target.value)}
                   
                    placeholder="Jean"
                    required 
                    maxLength="32"
                  />
                <input
                    onChange={(event) => setLastName(event.target.value)}
                  
                    placeholder="Robert"
                    required 
                    maxLength="32"
                   />    
                <input
                  onChange={(event) => setEmail(event.target.value)}
                  type="email"
                  placeholder="email@email.com"
                  required 
                  maxLength="32"
               />
                <input
                  onChange={(event) => setPwd(event.target.value)}
                  type="password"
                  placeholder="password"
                  required 
                  maxLength="20"
                />
                <input
                  onChange={(event) => setPwd_rec(event.target.value)}
                  type="password"
                  placeholder="confirm password"
                  required 
                  maxLength="20"
                 />
                <button onClick={() => {checkDetails(); submit()} }>Créer</button>
            </div>
            <button
                onClick={() =>{ setHasAccount(true);}}
                className="hasAccount">
                J'ai déjà un compte.
            </button>
        </div>
    )
}

export default Signup;