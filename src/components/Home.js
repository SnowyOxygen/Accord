import React, { useState } from "react";

//Components
import Connection from './Connection';
import Signup from "./Signup";

function Home({setEmail, setPassword}){
    const [hasAccount, setHasAccount] = useState(true);
    //TODO: check cookies for login details with component

    return (
        <div className="home">

            <header className="title">
                {`\u0394ccord`}
            </header>
            <div className="accounts">
                {hasAccount ? (
                    <Connection
                    setEmail={setEmail}
                    setPassword={setPassword}
                    setHasAccount={setHasAccount} />
                ) : (
                    <Signup
                    setHasAccount={setHasAccount}/>
                )}
            </div>

        </div>
    )
}

export default Home;