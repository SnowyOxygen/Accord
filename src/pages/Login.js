import { Link } from 'react-router-dom';
import '../styles/Login.css';

export function Login(){
    return(
        <div id="pageWrapper" className="Login">
            <header id='homeheader' className="App-header">
                <p id="mercureTitre">{`M\u03B5rcur\u03B5`}</p>
            </header>
            <div id="login">
                <Link to="/create_account">Créer un compte</Link>
                <form id="loginform">                 
                    <input type="text" id="username" name="username" required placeholder="username"></input>
                    <input type="password" id="password" name="password" required placeholder="password"></input>
                    <input type="submit" id="submitlogin" name="submit"></input>
                </form>
            </div>
        </div>
    )
}