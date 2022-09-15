<?php
header("Access-Control-Allow-Headers: Accept, Content-Type");
$a = $_SERVER['HTTP_ORIGIN'];
header("Access-Control-Allow-Origin: $a");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include __DIR__."/Generator.php";
include __DIR__."/Groups.php";
include __DIR__."/GroupUsers.php";
include __DIR__."/authGuard/decrypt.php";
include __DIR__."/authGuard/checkAuth.php";



if($_SERVER['REQUEST_METHOD'] == "POST"){
    $auth = checkAuth();
    if($auth){
       
        $data = json_decode(file_get_contents("php://input"), true);
        if(isset($data['name'])){
            $data['name'] = htmlspecialchars($data['name']);
            if(!isset($data["logo"])){
                $data["logo"] = "";
            }else{
                $data['logo'] = htmlspecialchars($data['logo']);  
            }
            if(!isset($data["descr"]) || strlen($data["descr"]) <1){
                $data["descr"] = "";
            }else{
                $data['descr'] = htmlspecialchars($data['descr']);
            }
            try {
                $Group = $Groups->create([...$data]);
                try {
                    
                    $GroupUser = $GroupUsers->create(["email_user"=>$auth['email'],"id_group"=>$Group["groups"]->id, "admin"=>1]);
                    echo json_encode(["message"=>true, "error"=>"", "data"=>["groups"=>$Group, "groupUsers"=>$GroupUser]]);
                    
                } catch (PDOException $e) {
                    echo json_encode(["message"=>false, "error"=>"Impossible to add User to Group as admin $e", "data"=>["groups"=>$Group]]);
                    exit;
                }

            } catch (PDOException $e) {
                echo json_encode(["message"=>false, "error"=>"Impossible to create group: $e", "data"=>[]]);
                exit;
            }
           
        
            if(count($Group)<1){
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
