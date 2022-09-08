import React from "react";
import { useState } from "react";
import Groups from "./chatbox/Groups";
import Rooms from "./chatbox/Rooms";

function ChatBox({email, password}){
    const [rooms, setRooms] = useState([]);

    return(
        <div>
            <header className="chatbox-header">
                <p className="welcome">Welcome, {email}</p>
            </header>

            <Groups setRooms={setRooms}/>
            <Rooms rooms={rooms}/>
        </div>
    )
}

export default ChatBox;