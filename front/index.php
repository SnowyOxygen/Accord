<?php
header("Access-Control-Allow-Headers: *");

header('Access-Control-Allow-Origin: http://www.localhost:4000');

header('Access-Control-Allow-Methods: GET, POST, OPTIONS');



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
   
    <div id="divInscription">
        <h1>INSCRIPTION</h1>
        <div>
            <label for="">firstname</label>
            <input type="text" name="firstname" value="louis mariott">
        </div>
        <div>
            <label for="">lastname</label>
            <input type="text" name="lastname" value="mariott">
        </div>
        <div>
            <label for="">email</label>
            <input type="text" name="email" value="louis@mariott.en">
        </div>
        <div>
            <label for="">pwd</label>
            <input type="text" name="pwd" value="1234">
        </div>
        <div>
            <label for="">pwd_recup</label>
            <input type="text" name="pwd_rec" value="1234">
        </div>
        <button name="submit">Inscription</button>
    </div>
    <div id="divConnexion">
        <h1>CONNEXION</h1>
     
        <div>
            <label for="">email</label>
            <input type="text" name="email" value="louis@mariott.en">
        </div>
        <div>
            <label for="">pwd</label>
            <input type="text" name="pwd" value="1234">
        </div>
        <button name="submit">Connexion</button>
    </div>
  
    <div id="divCreateGroup">
        <h1>CREATE GROUP</h1>
     
        <div>
            <label for="">name</label>
            <input type="text" name="name" value="cheatCodes">
        </div>
        <div>
            <label for="">desc</label>
            <textarea name="desc">A place to share cheat codes !</textarea>
        </div>
        <div>
            <label for="">Logo</label>
            <input name="logo" type="file"/>
        </div>
        <button name="submit">Créer un groupe</button>
    </div>
   
    <div id="divCreateRoom">
        <h1>CREATE ROOM</h1>
     
        <div>
            <label for="">Id groupe</label>
            <input type="text" name="id_group" value=0>
        </div>
        <div>
            <label for="">desc</label>
            <textarea name="descr">Dofus cheatcodes</textarea>
        </div>
        <div>
            <label for="">name</label>
            <input name="name" value="Dofus" />
        </div>
        <button name="submit">Connexion</button>
    </div>

    <div id="divInvite">
        <h1>INVITE</h1>
     
        <div>
            <label for="">Id room</label>
            <input type="number" name="id_room" min=0 value=0>
        </div>
        <div>
            <label for="">Id user invited</label>
            <input type="text" name="email_invited" value="Jean@Robert.fr">
        </div>
      
        <button name="submit">Invite</button>
    </div>
   
    <div id="divMessage">
        <h1>SEND MESSAGE</h1>
     
        <div>
            <label for="">from id</label>
            <input type="number" name="from_id">
        </div>
        <div>
            <label for="">content</label>
            <textarea name="content"></textarea>
        </div>
        <div>
            <label for="">room id</label>
            <input name="room_id" type="number"/>
        </div>
        <button name="submit">Send message</button>
    </div>

    <div id="divVideo">
        <h1>Make a call</h1>
     
        <div>
            <label for="">from id</label>
            <input type="number" name="from_id">
        </div>
        <div>
            <label for="">room id</label>
            <input name="room_id" type="number"/>
        </div>
        <button name="submit">Make a call</button>
    </div>
    <div id="divJoinRoom">
        <h1>Make a call</h1>
     
        <div>
            <label for="">from id</label>
            <input type="number" name="from_id">
        </div>
        <div>
            <label for="">room id</label>
            <input name="room_id" type="number"/>
        </div>
        <button name="submit">Make a call</button>
    </div>
    
<script>
    //<img src="http://localhost:4000/cookie.php"/>
    //fetch("http://localhost:4000/cookie.php", {method: "POST", credentials: "include"}).then(e=>e.text()).then(e=>console.log(e))
    //window.location.href = "http://localhost:4000/cookie.php";

</script>
<script>
    let server = "http://localhost:4000/orm/";
    //INSCRIPTION
    let inscription = {
        element: document.querySelector("#divInscription"),
        firstname: function(){return this.element.querySelector("[name='firstname']").value},
        lastname: function(){return this.element.querySelector("[name='lastname']").value},
        email: function(){return this.element.querySelector("[name='email']").value},
        pwd: function(){return this.element.querySelector("[name='pwd']").value},
        pwd_rec: function(){return this.element.querySelector("[name='pwd_rec']").value},
        submit: function(){return this.element.querySelector("[name='submit']")},
    }

    console.log(inscription);
    
    inscription.submit().addEventListener("click", (e)=>{

        temp_data = {
            firstname: inscription.firstname(),
            lastname: inscription.lastname(),
            email: inscription.email(),
            pwd: inscription.pwd(),
            pwd_rec: inscription.pwd_rec()
        };

        console.log(temp_data);

        //fetch("http://localhost:4000/cookie.php", {method: "POST", credentials: "include"}).then(e=>e.text()).then(e=>console.log(e))
        fetch(server+"./signup.php", {headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify(temp_data)})
        .then(e=>
            e.text()
        )
        .then(e=>console.log(e));
    })

    //CONNEXION
    let connexion = {
        element: document.querySelector("#divConnexion"),
       
        email: function(){return this.element.querySelector("[name='email']").value},
        pwd: function(){return this.element.querySelector("[name='pwd']").value},
        submit: function(){return this.element.querySelector("[name='submit']")},
    }

    console.log(connexion);

    connexion.submit().addEventListener("click", (e)=>{
        temp_data = {
            email: inscription.email(),
            pwd: inscription.pwd(),
        };

        console.log(temp_data);

        fetch(server+"./signin.php", {credentials: "include",headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify(temp_data)})
        .then(e=>
            e.json()
        )
        .then(e=>{console.log(e)});
    })

    //CreateGroup

    let groupCreation = {
        element: document.querySelector("#divCreateGroup"),
       
        name: function(){return this.element.querySelector("[name='name']").value},
        desc: function(){return this.element.querySelector("[name='desc']").value},
        logo: function(){return this.element.querySelector("[name='logo']").files},
        submit: function(){return this.element.querySelector("[name='submit']")},
    }
    
    console.log(groupCreation);
    
    groupCreation.submit().addEventListener("click", async(e)=>{
        if(groupCreation.logo[0]){
        let reader = new FileReader();

        reader.onload = await function (e) {
            temp_data = {
                logo: e.target.result,
                name: groupCreation.name(),
                descr: groupCreation.desc(),
            };
        }

        reader.readAsDataURL(groupCreation.logo[0]);
            }else{
                temp_data = {
                name: groupCreation.name(),
                descr: groupCreation.desc(),
            }; 
        }
    console.log("temp data ",temp_data);
    fetch(server+"./createGroup.php", {credentials: "include",headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify(temp_data)})
    .then(e=>
        e.text()
    )
    .then(e=>console.log(e));
    })

    //CREATEROOM

    let roomCreation = {
        element: document.querySelector("#divCreateRoom"),
       
        name: function(){return this.element.querySelector("[name='name']").value},
        descr: function(){return this.element.querySelector("[name='descr']").value},
        submit: function(){return this.element.querySelector("[name='submit']")},
    }
    console.log(roomCreation);
    
    roomCreation.submit().addEventListener("click", async(e)=>{
        temp_data = {
                name: roomCreation.name(),
                descr: roomCreation.descr(),
            }; 
    console.log("temp data ",temp_data);
    fetch(server+"./createRoom.php", {credentials: "include",headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify(temp_data)})
    .then(e=>
        e.text()
    )
    .then(e=>console.log(e));
    })

    //INVITE
    let invite = {
        element: document.querySelector("#divInvite"),
       
        id_room: function(){return this.element.querySelector("[name='id_room']").value},
        email_invited: function(){return this.element.querySelector("[name='email_invited']").value},
        submit: function(){return this.element.querySelector("[name='submit']")},
    }
    console.log(roomCreation);
    
    invite.submit().addEventListener("click", async(e)=>{
        temp_data = {
            email_invited: invite.email_invited(),
            id_room: parseInt(invite.id_room()),
            }; 
    console.log("temp data ",temp_data);
    fetch(server+"./invite.php", {credentials: "include",headers: {'Accept': 'application/json', 'Content-Type':'application/json'},method: 'POST', body: JSON.stringify(temp_data)})
    .then(e=>
        e.text()
    )
    .then(e=>console.log(e));
    })

</script>
</body>
</html>