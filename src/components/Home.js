import React, { useState } from "react";

//Components
import Connection from './Connection';
import Signup from "./Signup";

function Home({setEmail, setPassword}){
    const [hasAccount, setHasAccount] = useState(true);

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
                <Signup/>
            )}

        </div>
    )
}

export default Home;