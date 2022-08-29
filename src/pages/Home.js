import { Link } from "react-router-dom";

export function Home(){
    return(
        <div>
            <header id='homeheader' className="App-header">
                <p id="mercureTitre">{`M\u03B5rcur\u03B5`}</p>
            </header>
            <nav>
                <Link to="/login">Login</Link>
                <Link to="/create_account">Create Account</Link>
            </nav>
        </div>
    )
}