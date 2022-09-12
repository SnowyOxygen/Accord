import React, { useState } from "react";
import { useContext } from "react";
import { PopupContext } from "../App";

//Components
import Connection from './Connection';
import Signup from "./Signup";

function Home({setEmail, setPassword}){
    const [hasAccount, setHasAccount] = useState(true);
    //TODO: check cookies for login details with component

    //If true, show details. If false, show form.
    const [contactPage, setContactPage] = useState(true);

    //#region Contact
    const ppContext = useContext(PopupContext);

    //Contact form
    const [contFirst, setContFirst] = useState(''); //First name
    const [contLast, setContLast] = useState(''); //Last name
    const [contEmail, setContEmail] = useState('');
    const [contNumber, setContNumber] = useState('');
    const [contText, setContText] = useState('');

    const OpenContactUs = () => {
        //TODO: pageswitch button only works when clicking contacts again
        return(
            <div className="popup-wrapper vertical-center">
                <button onClick={() => setContactPage(!contactPage)} className="pageswitch">
                    {contactPage ? ('Envoyez-nous') : ('Coordonnées')}
                </button>
                <button onClick={() => {
                    ppContext.setppDisplay('none');
                    setContactPage(true);}} className="contact-close">
                        x
                </button>
                <div className="contactus">
                    {contactPage ? (
                        <div className="details">
                            <p className="contact-title">Contactez-nous</p>
                            <p className="contact-detail">contact@accord.com</p>
                            <p className="contact-detail">09 87 65 32 12</p>
                        </div>
                    ) : (
                        <div className="contact-form">
                            <input onChange={(e) => setContFirst(e.target.value)} 
                                type="text" 
                                placeholder="prénom" maxLength="20"/>
                            <input onChange={(e) => setContLast(e.target.value)} 
                                type="text" 
                                placeholder="nom" maxLength="20"/>
                            <input onChange={(e) => setContEmail(e.target.value)} 
                                type="email" 
                                placeholder="email" maxLength="20" required/>
                            <input onChange={(e) => setContNumber(e.target.value)} 
                                type="tel" 
                                placeholder="09 87 65 43 32" required/>
                            <textarea onChange={(e) => setContText(e.target.value)} name="contactinput" id="contactinput" cols="25" rows="5"></textarea>
                            <button onClick={() => sendContactMessage()} className="contact-submit">{`\u2709`}</button>
                        </div>
                    )}
                </div>
            </div>
        )
    };
    //Email structure regex
    const regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/gi;

    const sendContactMessage = () => {
        //TODO: Send message
        //TODO: check for invalid characters

        var message = {
            first : contFirst,
            last : contLast,
            email : contEmail,
            number: contNumber,
            text : contText
        };
    };

    //#endregion

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
            <div className="contact-us">
                <button onClick={() => {
                    ppContext.setppContent(<OpenContactUs/>);
                    ppContext.setppDisplay('block');
                }} className="contact-toggle">
                    Contactez-Nous
                </button>
            </div>
        </div>
    );
}

export default Home;