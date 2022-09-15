<?php



header("Access-Control-Allow-Headers: *");

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: POST');

include __DIR__."/Generator.php";
include __DIR__."/Users.php";
include __DIR__."/passwordGenerate.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if(isset($data['firstname']) && isset($data['lastname']) && isset($data['pwd']) && isset($data['email'])){
        $data['firstname'] = htmlspecialchars($data['firstname']);
        $data['lastname'] = htmlspecialchars($data['lastname']);
        $data['pwd'] = password_hash(htmlspecialchars($data['pwd']), PASSWORD_DEFAULT);
        $data['email'] = htmlspecialchars($data['email']);
        try {
            $User = $Users->create(["firstname"=>$data["firstname"],"lastname"=>$data["lastname"], "email"=>$data["email"], "pwd"=>$data["pwd"], "pwd_rec"=>generatePwdRec() ]);
            echo json_encode(["message"=>true, "error"=>"", "data"=>$User]);
        } catch (PDOException $e) {
            echo json_encode(["message"=>false, "error"=>"an account with this email already exits", "data"=>[]]);
            exit;
        }
       
        

    }else{
        echo json_encode(["message"=>"","error"=>"Missing keys", "data"=>""]);
    }
   


}else{
    echo "GET";
}



?>