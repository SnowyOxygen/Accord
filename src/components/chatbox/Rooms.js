import React from "react";
import { useEffect, useContext } from "react";
import { PopupContext } from "../../App";

function Rooms({room, rooms, group, setRoom}){
    let context = useContext(PopupContext);
   


  


    return(
        <div className="rooms-wrapper">
            <div className="rooms-groupname">{Object.keys(group).length > 0 ? (
                <p className="group-name">{group.name}</p>
            ) : (
                <p className="group-name">Veuillez choisir un groupe.</p>
            )}</div>
            <ul className="rooms-list">

                {Object.entries(rooms).map((el, i) => {
                    el[1].name = el[0];
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