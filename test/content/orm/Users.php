<?php
class Player{

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "people";

    function __construct($id=NULL, $name=NULL, $age=NULL)
    {
        $this->id = $id;
        $this->name= $name;
        $this->age=$age;
        $this->table = "player";
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->db", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully <br/>\n";
        }catch(PDOException){
            echo "error";
        }
    }
    function find($where=NULL){
        $stmt = "SELECT * FROM $this->table";
        if($where == NULL){
            echo "no params";
            
        }else{
            $stmt .= " WHERE ";
            foreach(array_keys($where) as $key){
                $stmt.= "$key = ".$where[$key]." ";
            }

        }
        $stmt.= " LIMIT 1";
        echo "statement $stmt <br/>";
        $stmt = $this->conn->query($stmt);
        $user = $stmt->fetch();
        echo "user";
        var_dump($user);
        echo "<br/>";
        echo $user["id"]." ".$user["name"]." ".$user["age"];
        return new Player($id=$user["id"], $name=$user["name"], $age=$user["age"]);
    }
    function findAll($where=NULL){
        $stmt = "SELECT * FROM $this->table";
        if($where == NULL){
            echo "no params";
            
        }else{
            $stmt .= " WHERE ";
            foreach(array_keys($where) as $key){
                $stmt.= "$key = ".$where[$key]." ";
            }

        }
        $rows = array();
        $data = $this->conn->query($stmt)->fetchAll();
        foreach ($data as $row) {
            echo $row['name']." ".$row['age']." ".$row['id']."<br />\n";
            array_push($rows, new Player($id=$row["id"], $name=$row["name"], $age=$row["age"] ));
        }
        return $rows;
    }

    function create($name, $age){
        
        $sql = "INSERT INTO $this->table(name, age) VALUES('$name', $age);";
       
        $this->conn->prepare($sql)->execute();


        $publisher_id = $this->conn->lastInsertId();

        echo 'The publisher id ' . $publisher_id . ' was inserted';
        return $this->find(array("id"=>$publisher_id));
        
    }
    function update($attr){
        $stmt = "UPDATE $this->table SET ";
        foreach(array_keys($attr) as $key){
            if(gettype($attr[$key])=="string"){
                $stmt.= "$key = '".$attr[$key]."' ";
            }elseif(gettype($attr[$key])=="int"){
                $stmt.= "$key = ".$attr[$key]." ";
            }
        }
        $stmt.="WHERE id = $this->id";
        echo $stmt;
        $this->conn->prepare($stmt)->execute();

        foreach(array_keys($attr) as $key){
            $this->$key =$attr[$key];
        }
        echo "$this->id  $this->name   $this->age";
    }

    function delete($id=NULL){
            $stmt="DELETE FROM users WHERE id=";
            if($id == NULL){
                
                if(gettype($this->id)=="string"){
                    $stmt.= "'$this->id'";
                }elseif(gettype($this->id)=="int"){
                    $stmt.= "$this->id";
                }
                
            }else{
                if(gettype($id)=="string"){
                    $stmt.= "'$id'";
                }elseif(gettype($id)=="int"){
                    $stmt.= "$id";
                }
    
            }
            $stmt= $this->conn->prepare($stmt);
            $stmt->execute();
        
    }
}
$player = new Player();

$temp = $player->find(array("id"=>2));
echo "find <br/> ";
echo "id: $temp->id  name: $temp->name age: $temp->age";
$temp->update(array("name"=>"Josianne", "age"=>199));
$temp->delete();
/*
$temp = $player->findAll();
echo "findAll <br/> ";
forEach($temp as $temp){
echo "id: $temp->id  name: $temp->name age: $temp->age  <br/>";
}

echo "create <br/> ";
$new_player = $player->create($name="gerard", $age=14);
echo "id: $new_player->id  name: $new_player->name age: $new_player->age";
*/
?>