import React from "react";
import { useEffect } from "react";

function Rooms({rooms, group, setRoom}){
    useEffect(() => {
        setRoom({})
    }, [rooms])
    

    return(
        <div className="rooms-wrapper">
            <p className="rooms-groupname">{Object.keys(group).length > 0 ? (
                <p className="group-name">{group.name}</p>
            ) : (
                <p className="group-name">Veuillez choisir un groupe.</p>
            )}</p>
            <ul className="rooms-list">
                {Object.entries(rooms).map((el, i) => {
                    return(
                        <li key={i} className="room-element">
                            <button 
                             className="room-button"
                             onClick={() => setRoom(el[1])}>
                                {el[0]}
                            </button>
                        </li>
                    )
                })}
            </ul>
        </div>
    );
}

export default Rooms;