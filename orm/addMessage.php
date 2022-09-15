<?php
header("Access-Control-Allow-Headers: Accept, Content-Type");
$a = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin: $a");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include __DIR__."/Generator.php";
include __DIR__."/Rooms.php";
include __DIR__."/RoomUsers.php";
include __DIR__."/authGuard/decrypt.php";
include __DIR__."/authGuard/checkAuth.php";



if($_SERVER['REQUEST_METHOD'] == "POST"){
    $auth = checkAuth();
    if($auth){
       
        $data = json_decode(file_get_contents("php://input"), true);
        if(isset($data['content']) && isset($data['from_email']) && isset($data['sent_at']) && isset($data['id_room'])){
            $data['content'] = htmlspecialchars($data['content']);
            $data['from_email'] = htmlspecialchars($data['from_email']);
            $data['id_room'] = htmlspecialchars($data['id_room']);

            //img save
            try {
                $Room = $Rooms->create([...$data]);
                try {
                    $RoomUser = $RoomUsers->create(["email_user"=>$auth["email"], "id_room"=>$Room['rooms']->id, "admin"=>1]);
                    echo json_encode(["message"=>true, "error"=>"", "data"=>["roomUsers"=>$RoomUser, "rooms">$Room]]);
    
                } catch (PDOException $ee) {
                    echo json_encode(["message"=>false, "error"=>"Impossible to set User as admin of room: $ee", "data"=>[]]);
                    exit;
                }

            } catch (PDOException $e) {
                echo json_encode(["message"=>false, "error"=>"Impossible to create room: $e", "data"=>[]]);
                exit;
            }
           
        
            if(count($Room)<1){
                echo json_encode(["message"=>false, "error"=>"Group couldn't be created", "data"=>[]]);
                die();
            }
           
        
            

        }else{
            echo json_encode(["message"=>"false","error"=>"Missing keys", "data"=>""]);
        }
   
        die();
    }else{
        echo json_encode(["message"=>"false", "error"=>"User not logged", "data"=>[]]);
    }
    


}else{
    echo "GET";
}
