import React from "react";
import { useState } from "react";
import Content from "./chatbox/Content";
import Groups from "./chatbox/Groups";
import Rooms from "./chatbox/Rooms";

//TODO: Import isMobile from react device detect

function ChatBox({email, password}){
    const [rooms, setRooms] = useState([]);
    const [room, setRoom] = useState({}); //Current viewed room
    const [group, setGroup] = useState({});

    return(
        <div className="chatbox-wrapper">
            <header className="chatbox-header">
                <p className="welcome">Bienvenu(e), {email}</p>
            </header>

            <div className="chatbox-horizontal">
                <Groups group={group} setGroup={setGroup} setRooms={setRooms} setRoom={setRoom}/>
                <Rooms group={group} rooms={rooms} setRoom={setRoom}/>
                <Content room={room}/>
            </div>
        </div>
    )
}

export default ChatBox;