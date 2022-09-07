import React, { useState } from "react";

//Components
import Connection from './Connection';
import Signup from "./Signup";

function Home({setEmail, setPassword}){
    const [hasAccount, setHasAccount] = useState(true);
    //TODO: check cookies for login details with component

    return (
        <div>

            <header className="title">
                {`\u0394ccord`}
            </header>

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
    )
}

export default Home;