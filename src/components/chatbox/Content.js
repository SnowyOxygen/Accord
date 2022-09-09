import React from "react";
import { useState } from "react";

function Content({room}){
    const [message, setMessage] = useState("");

    const getContent = () => {
        switch(room.type){
            default:
                return getMessages(room.messages);
        }
    }

    const getMessages = (messages) => {
        return(
            <div className="content-wrapper">
                <div className="messages-wrapper">
                    <ul className="message-list">
                        {
                            messages.map((el) => {
                                return <li className="message">
                                        <p className="messageC">{el.message}</p>
                                        <div className="author-time">
                                            <p className="author">{el.user}</p>
                                            <p className="time">{el.time}</p>
                                        </div>
                                    </li>
                            })
                        }
                    </ul>
                </div>
                <div className="textbox">
                    <input onChange={(event) => setMessage(event.target.value)} type="text" className="chatinput" maxLength="300"/>
                    <button onClick={() => sendMessage()} className="chatsubmit">{`\u2709`}</button>
                </div>
            </div>
        )
    }

    const sendMessage = () => {
        //TODO: Send message to back
    }

    return (
        <div className="content-wrapper">
            {Object.keys(room).length > 0 ? getContent()
            : (
                <p className="choose-room">Choissisez une salle pour commencer</p>
            )}
        </div>
    );
}

export default Content;