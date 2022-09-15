<?php
function checkAuth(){
    if(isset($_COOKIE["auth"])){
        $auth = json_decode(decrypt($_COOKIE["auth"]), true);
        return $auth;
    
    }else{
        return false;
    }
}
?>