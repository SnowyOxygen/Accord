<?php
$a = $_SERVER['HTTP_ORIGIN'];

header("Access-Control-Allow-Origin: $a");
header("Access-Control-Allow-Origin: $a");
header("Access-Control-Allow-Headers: Accept, Content-Type");

header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');


include __DIR__."/Generator.php";
include __DIR__."/Users.php";
include __DIR__."/authGuard/encrypt.php";
include __DIR__."/authGuard/decrypt.php";



include __DIR__.'/authGuard/checkAuth.php';



if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(checkAuth()){
        echo json_encode(["message"=>"false", "error"=>"User already logged", "data"=>[]]);
        die();
    }
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['pwd']) && isset($data['email'])){
        $data['pwd'] = htmlspecialchars($data['pwd']);
        $data['email'] = htmlspecialchars($data['email']);
        
        $User = $Users->find($where=["email"=>$data["email"]]);
       
        if(count($User)<1){
            echo json_encode(["message"=>false, "error"=>"user doesn't exist", "data"=>[]]);
            die();
        }
        if(password_verify( $data['pwd'], $User["users"]->pwd)) {
            //A COOKIE FOR ONE DAY
           
            setCookie("auth",encrypt(json_encode(["admin"=>false, "firstname"=>$User["users"]->firstname, "lastname"=>$User["users"]->lastname, "email"=>$User["users"]->email])), time() + (86400), "/");
            setCookie("infos",json_encode(["admin"=>false, "firstname"=>$User["users"]->firstname, "lastname"=>$User["users"]->lastname,  "email"=>$User["users"]->email]), time() + (86400), "/");
           
            echo json_encode(["message"=>true, "error"=>"", "data"=>[" $a"]]);
        } else{
            echo json_encode(["message"=>false, "error"=>"wrong password", "data"=>[" $a"]]);
            die();
        }
       
        

    }else{
        echo json_encode(["message"=>"false","error"=>"Missing keys", "data"=>""]);
    }
   


}else{
    echo "GET";
}

