<?php
header("Access-Control-Allow-Headers: Accept, Content-Type");
$a = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin: $a");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include __DIR__."/Generator.php";
include __DIR__."/Rooms.php";
include __DIR__."/Users.php";
include __DIR__."/RoomUsers.php";
include __DIR__."/authGuard/decrypt.php";
include __DIR__."/authGuard/checkAuth.php";



if($_SERVER['REQUEST_METHOD'] == "POST"){
    $auth = checkAuth();
        $data = json_decode(file_get_contents("php://input"), true);
        if(isset($data['id_room']) && isset($data['email_invited'])){
            $data['id_room'] = htmlspecialchars($data['id_room']);
            $email_user = $auth["email"];
            $data['email_invited'] = htmlspecialchars($data['email_invited']);
            
            try {
                    
                $User = $Users->find($where=["email"=>$email_user], $join=[["model1"=>NULL,"attr1"=>"email", "model2"=>$RoomUsers, "attr2"=>"email_user"],["model1"=>$RoomUsers,"attr1"=>"id_room", "model2"=>$Rooms, "attr2"=>"id"]] );
                //$RoomUser = $RoomUsers->create(["email_user"=>$data['email_invited'], "id_room"=>$data['id_room']]);
                
                if($User["users"]){
                    try {
                        $RoomUser = $RoomUsers->create(["email_user"=>$data['email_invited'], "id_room"=>$data['id_room'], "admin"=>0]);
                        echo json_encode(["message"=>"true","error"=>"", "data"=>$User]);
                        
                    } catch (PDOException $eee) {
                        echo json_encode(["message"=>false, "error"=>"Impossible to add User $ee", "data"=>[]]);
                        exit;
                    }
                }
            } catch (PDOException $e) {
                echo json_encode(["message"=>false, "error"=>"Impossible to check if User has right $e", "data"=>["groups"=>$Group]]);
                exit;
            }


        }else{
            echo json_encode(["message"=>"false","error"=>"Missing keys", "data"=>[]]);
        }
   
        die();
    
    


}else{
    echo "GET";
}




?>