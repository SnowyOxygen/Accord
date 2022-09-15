import React, { useEffect, useContext } from "react";
import { useState } from "react";
import { PopupContext } from "../App";
import Content from "./chatbox/Content";
import Groups from "./chatbox/Groups";
import Rooms from "./chatbox/Rooms";
import { getCookie } from "../App";

//TODO: Import isMobile from react device detect

function ChatBox({email, password}){
    const [rooms, setRooms] = useState([]);
    const [room, setRoom] = useState({}); //Current viewed room
    const [group, setGroup] = useState({});

    let context = useContext(PopupContext);


    useEffect(()=>{
        let i= getCookie("infos");
        console.log("NEW ROOM CHOSEN ", {...context.state_.state_, room: room});
        let temp = {...context.state_.state_, room: room};
        if(i){
                temp = {...temp, ...JSON.parse(i.value)};
        }
        if(Object.keys(room).length > 1){
            console.log(context.state_.state_)
            let tc = JSON.parse(context.state_.state_.value);
            
        const event = new CustomEvent("joinRoom", {
            
            detail:{group: context.state_.state_.group.name, room: room.name, firstname: tc.firstname},
            bubbles: true,
            cancelable: true,
            composed: false,
          }); 
          window.dispatchEvent(event);
        context.state_.setState_({...context.state_.state_, room: room});
       }
    }, [room])

    useEffect(()=>{
        context.state_.setState_({...context.state_.state_, group: group});
    }, [group])

    return(
        <div className="chatbox-wrapper">
           
            <header className="chatbox-header">
                <p className="welcome">Bienvenu(e), {email}</p>
            </header>

            <div className="chatbox-horizontal">
                <Groups group={group} setGroup={setGroup} setRooms={setRooms} setRoom={setRoom} room={room}/>
                <Rooms group={group} room={room} rooms={rooms} setRoom={setRoom}/>
                <Content room={room} setRoom={setRoom}/>
            </div>
        </div>
    )
}

export default ChatBox;