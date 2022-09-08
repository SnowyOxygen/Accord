import React from "react";

function Groups({setRooms}){

    const groupList = [ //TODO: get groups from backend
        {
            lIcon : "f",
            rooms : [
                "general",
                "off-topic",
                "memes"
            ]
        },
        {
            lIcon : "e",
            rooms : [
                "général",
                "on-topic",
                "mèmes"
            ]
        }
    ];

    // setRooms(groupList[0].rooms);

    return(
        <div className="groups-wrapper">
            {/* Show group icons */}
            <ul className="groups-list">
                {
                    groupList.map((el, i) => {
                        return(
                            <li key={i} className="group-element">
                                <button
                                 onClick={() => setRooms(el.rooms)} 
                                 className="group-button">
                                    {el.lIcon}
                                </button>
                            </li>
                        );
                    })
                }
            </ul>

        </div>
    );
}

export default Groups;