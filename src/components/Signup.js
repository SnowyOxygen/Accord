import React from "react";

function Signup(){
    return(
        <form action="" className="signup">
            <input type="email" placeholder="email@email.com" required/>
            <input type="pseudonym" placeholder="pseudonym" required/>
            <input type="password" placeholder="password" required/>
            <input type="password" placeholder="confirm password" required/>
        </form>
    )
}

export default Signup;