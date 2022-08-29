import { useState } from 'react';
import '../styles/CreationCompte.css';

export function CreationCompte(){
    let [username, setUsername] = useState('');

    function HandleSubmit(e){
        e.preventDefault();
        
    }

    function HandleUserName(e){
        setUsername(e.target.value);
    }

    return(
        <div>
            <header id='ccheader' className="App-header">
                <p id="ccmercure">{`M\u03B5rcur\u03B5`}</p>
                {username}
            </header>

            <form>
                <input type="text" onchange={e=>{HandleUserName(e)}}></input>
                <input type="submit" onclick={e=>{HandleSubmit(e)}}>Créer</input>
            </form>
        </div>
    )
}