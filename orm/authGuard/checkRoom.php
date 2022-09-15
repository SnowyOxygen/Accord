<?php

function($id_room){
    if(isset($_COOKIE["auth"])){
        $auth = str_replace(file_get_contents("./client.txt"), "", $_COOKIE['auth']);
        $auth = json_decode(decrypt($auth), true);
        if($auth['admin'] !== true){
            echo json_encode(["message"=>"User not admin"]);
            die();}
    }else{
        echo json_encode(["message"=>"User not logged"]);
        die();
    }
}
?>