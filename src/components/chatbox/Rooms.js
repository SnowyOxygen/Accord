import React from "react";

function Rooms({rooms}){
    return(
        <div className="rooms-wrapper">
            <ul className="rooms-list">
                {rooms.map((el, i) => {
                    return(
                        <li key={i} className="room-element">
                            <button 
                             className="room-button">
                             {el}
                            </button>
                        </li>
                    )
                })}
            </ul>
        </div>
    );
}

export default Rooms;