import React, { useEffect, useContext, useRef, useCallback } from "react";
import { useState } from "react";
import { PopupContext } from "../../App";

function Content({room, setRoom}){
    let context = useContext(PopupContext);
    const [message, setMessage] = useState("");
    let [sent, setSent] = useState(false);
    let room_ = useRef(room);
    let room_2 = useRef(room);
    let setRoom_ = (v)=>{
        if(Object.keys(v).length > 0){
            room_.current = v;
            room_2.current = v;
            setRoom(v)
        }
    };


    useEffect(()=>{
        setRoom_(room);
    }, [room])
    
    let myCall = (e)=>{
          
        
        
         console.log("event messag received ", e.detail);
         console.log("current ", room_.current);
         console.log("room ", room);
         let temp = [...room_.current.messages, e.detail];
         console.log('temp', temp);
         let t2 = room_2.current;
         console.log("t2 ", t2);
         t2.messages = temp;
         console.log({...t2});
         setRoom_({...t2})
       
         
         console.log("temp ", room.current)
      
     
};

const useRefEventListener = fn => {
    const fnRef = useRef(fn);
    fnRef.current = fn;
    return fnRef;
  };

let call = useRefEventListener(myCall);

 




useEffect(()=>{
    
    
     window.addEventListener("messageReceived", call.current);

     return ()=>window.removeEventListener("messageReceived", call.current);
}, [])

useEffect(()=>{
    if(sent == true){
        
        let temp = {...room};
        temp.messages.push({message, user: context.state_.state_.firstname, time: new Date().toISOString().split("T")[0].replaceAll("-", "/")});

        console.log("firstname ",context.state_.state_.group);
        let event = new CustomEvent("sendMessage", {
            detail: {message, room: room.name, group: context.state_.state_.group.name, user: context.state_.state_.value, time: new Date().toISOString().split("T")[0].replaceAll("-", "/")},
            bubbles: true,
            cancelable: true,
            composed: false,
          });
          window.dispatchEvent(event);
          setSent(false);
        //Socket.send({type: "sendMessage", data: message});

        
        }


}, [sent])






    const getMessages = (messages) => {
        return(
            <div className="content-wrapper">
                <div className="messages-wrapper">
               
                    <ul className="message-list">
                    { JSON.stringify(room_.current.messages)  }
                   
                        {
                            messages.map((el, i) => {
                                return <li key={i} className="message">
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
                    <input onChange={(event) => setMessage(event.target.value)} type="text" className="chatinput" maxLength="100"/>
                    <input className="image-upload" type="image"/>
                    <button onClick={() => sendMessage()} className="chatsubmit">{`\u2709`}</button>
                </div>
            </div>
        )
    }

    const sendMessage = () => {
       setSent(true);
    }

    return (
        <div className="content-wrapper">
            {Object.keys(room).length > 0 ? getMessages(room_.current.messages?room_.current.messages:[])
            : (
                <p className="choose-room">Choissisez une salle pour commencer</p>
            )}
            
        </div>
    );
}

export default Content;