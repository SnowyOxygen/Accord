import React, { useEffect } from "react";
import { useContext } from "react";
import { useState } from "react";
import {PopupContext} from '../../App';
import { userDataEvent } from '../../events';


function CreateGroup(){
    const [groupName, setGroupName] = useState("");
    const [groupDesc, setGroupDesc] = useState("");
    return(
        <div>
            <label>Nom du groupe</label>
            <input onChange={(e)=>setGroupName(e.target.value)}/>
            <label>Description</label>
            <input onChange={(e)=>setGroupDesc(e.target.value)}/>
            <button onClick={()=>console.log("hello")} />
        </div>
    )
}


function Groups({room, setRooms, setRoom, setGroup, group}){
    const [isOpen, setIsOpen] = useState(false);
    
    let context = useContext(PopupContext).auth;
    let c = useContext(PopupContext);

    

    


    const groupList = [ //TODO: get groups from backend
        {
            name: "cesiGroup",
            lIcon : "f",
            rooms : {
                "general" : {
                    type: "text",
                    messages : [
                        {
                            user : "jeanLuc",
                            message : "lorem lorem lorem lorem",
                            time : "09 : 44 - 09/09/2022"
                        },
                        {
                            user : "henry",
                            message : "what",
                            time : "09 : 46 - 09/09/2022"
                        },
                        {
                            user : "malika",
                            message : "it's a message",
                            time : "09 : 47 - 09/09/2022"
                        },
                        {
                            user : "henry",
                            message : "what",
                            time : "09 : 46 - 09/09/2022"
                        },
                        {
                            user : "malika",
                            message : "it's a message",
                            time : "09 : 47 - 09/09/2022"
                        },
                        {
                            user : "henry",
                            message : "what",
                            time : "09 : 46 - 09/09/2022"
                        },
                        {
                            user : "malika",
                            message : "it's a message",
                            time : "09 : 47 - 09/09/2022"
                        },
                        {
                            user : "henry",
                            message : "what",
                            time : "09 : 46 - 09/09/2022"
                        },
                        {
                            user : "malika",
                            message : "it's a message",
                            time : "09 : 47 - 09/09/2022"
                        }
                    ]
                },
                "off-topic" : {
                    type: "text",
                    messages : [
                        {
                            user: "Jean",
                            message: "J'aime le php",
                            time: "11:59 - 09/09/2022"
                        },
                        {
                            user: "Louis",
                            message: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, quas. Cum, quibusdam nobis facilis, unde officiis ipsa iure porro pariatur, totam nemo distinctio qui! Delectus perferendis eligendi vel molestias ea!",
                            time: "12:00 - 09/09/2022"
                        }
                    ]
                },
                "memes" : {
                    type: "text",
                    messages : [

                    ]
                }
            }
        },
        {
            name: "louis group",
            lIcon : "e",
            rooms : {
                "general" : {
                    type: "text",
                    messages : [

                    ]
                },
                "off-topic" : {
                    type: "text",
                    messages : [

                    ]
                },
                "memes" : {
                    type: "text",
                    messages : [

                    ]
                }
            }
        }
    ];

    const ppContext = useContext(PopupContext);
    // const setppContent = useContext(PopupContext).setppContent;
    // const setppDisplay = useContext(PopupContext).setppDisplay;

    // setRooms(groupList[0].rooms);

    //#region Popup
    const OpenGroupSetting = () => {
        return(
            <div className="popup-wrapper">
                <div className="group-settings">
                    <button onClick={() => ppContext.setppDisplay('none')} className="closex">
                        x
                    </button>
                    <h1 className="gr-settings-title"></h1>
                    <ul className="gr-settings-list">
                        <li className="setting-el">
                            <input className="gr-setting-name" type="text" value={group.name}/>
                            <label></label>
                        </li>
                    </ul>
                </div>
            </div>
        )
    }
    const openNewGroup = () =>{

    }
    //#endregion

    return(
        <div className="groups-wrapper">
            <button onClick={() => {
                // TODO: Check if user chose group
                ppContext.setppContent(<OpenGroupSetting/>);
                ppContext.setppDisplay('block');
                
                }} className="expand">
                {`\u2630`}
            </button>
            {/* Show group icons */}
            <ul className="groups-list">
                {
                    groupList.map((el, i) => {
                        return(
                            <li key={i} className="group-element">
                                <button
                                onClick={() => {
                                   
                                    //window.dispatchEvent(userDataEvent({infos: "hello"}));
                                    setRooms(el.rooms);
                                setGroup(el);}} 
                                className="group-button">
                                    {el.lIcon}
                                </button>
                            </li>
                        );
                    })
                    
                }
                <li className="group-element">
                  <button className="group-button">+</button>
                </li>
            </ul>

        </div>
    );
}

export default Groups;