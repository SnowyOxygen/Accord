
<?php

class Table{
    function __construct($server, $db, $user, $pwd, $tableName, $list_params, $pk, $verbose)
    {
        $this->servername=$server;
        $this->table = $tableName;
        $this->username = $user;
        $this->password=$pwd;
        $this->verbose = $verbose;
        $this->pk = $pk;
        $this->list_params = $list_params;
        $this->db = $db;
        foreach($list_params as $key=>$param){
            $this->$key = $param;
        }
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->db", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($this->verbose==true)echo "Connected successfully <br/>\n";
        }catch(PDOException){
            if($this->verbose==true)echo "error";
        }
    }
    function getProps(){
            $table = array_map(function($prop){
                return array($prop =>$this->$prop);}, array_keys($this->list_params));
            
            if($this->verbose==true)echo "<br/>"; 
            
           
        
        return array(...$table);
    }

    function create($values){
        $keys = array_keys($values);
        $keysToString = implode(", ",$keys);
        $temp=[];
        foreach($keys as $k){
            if(gettype($values[$k]) == "integer"){
                $temp[] = $values[$k];
            }elseif(gettype($values[$k]) == "string"){
                $temp[] = "'".$values[$k]."'";
            }
        }
        $temp = implode(", ", $temp);

        $sql = "INSERT INTO $this->table($keysToString) VALUES($temp);";
        if($this->verbose==true)echo $sql."<br/>";
        $this->conn->prepare($sql)->execute();


        $publisher_id = $this->conn->lastInsertId();

        if($this->verbose==true)echo 'The publisher id ' . $publisher_id . ' was inserted';
        return $this->find(array($this->pk=>$publisher_id));
        
    }
    
    function find($where=NULL, $join=NULL){
        //features we want back
        $features = [...array_map(function($m){return $this->table.".".$m." AS `".$this->table.".".$m."`";},array_keys($this->list_params))];
        //list of tables in FROM part
        $tableList = [$this->table];
        $temp = "";
        //i.e $join=[["model1"=>NULL, "attr1"=>"id", "model2"=>$userplanes, "attr2"=>"id_user"], ["model1"=>$userplanes, "attr1"=>"id_plane","model2"=>$planes, "attr2"=>"id"]]
        if($join !== NULL){
            $temp .= " WHERE ";
            foreach($join as $j){
                
                if($j["model1"] != NULL){
                    if(!in_array($j["model1"]->table, $tableList)){
                        
                            foreach(array_keys($j["model1"]->list_params) as $l){
                                //items we want to get back

                                $features[] = $j["model1"]->table.".".$l." AS `".$j["model1"]->table.".".$l."`";
                            }
                        
                        $tableList[] = $j["model1"]->table;
                    }
                }
                if(!in_array($j["model2"]->table, $tableList)){
                    foreach(array_keys($j["model2"]->list_params) as $l){
                        //items we want to get back
                        
                        $features[] = $j["model2"]->table.".".$l." AS `".$j["model2"]->table.".".$l."` ";
                    }
                    $tableList[] = $j["model2"]->table;
                }
                //conditions of join
                $a = $j["model1"] == NULL?$this->table:$j["model1"]->table;
                $temp.= $a.".".$j["attr1"]." = ".$j["model2"]->table.".".$j["attr2"]." ";
                
                if($j !== $join[array_key_last($join)]){
                    $temp.=" AND ";
                }
            }
        }
        
        $features = implode(", ", $features);
        $stmt = "SELECT $features FROM ".implode(", ", $tableList);
        $stmt.= $temp;
        if($where == NULL){
            if($this->verbose == true) echo "no params";
            
        }else{
            if($join == NULL){ $stmt .= " WHERE ";}else{$stmt .= " AND ";}
            foreach(array_keys($where) as $key){
                if(gettype($where[$key])== "string"){
                    $stmt.= "$this->table.$key = '".$where[$key]."' ";
                }else  if(gettype($where[$key])== "integer"){
                    $stmt.= "$this->table.$key = ".$where[$key]." ";
                }
                
            }

        }
        $stmt.= " LIMIT 1";
        
        if($this->verbose == true) echo "stmt ".$stmt; 
        $stmt = $this->conn->query($stmt);
        $row = $stmt->fetch();
        if($this->verbose == true){
            echo "user";
            var_dump($row);
            echo "<br/>";
        }
       
        $string = "";
        $args = [];
        $result = [];
        if($row != false){
        foreach(array_keys($this->list_params) as $param){
            $string.=$row[$this->table.".".$param];
            $args[$param] = $row[$this->table.".".$param];
        }
        if($this->verbose == true) var_dump(json_encode($args));
        
        if($join !== NULL){
            
            foreach($join as $table){
                if($table["model1"] != NULL){
                
                    $argsN = [];
                    foreach(array_keys($table["model1"]->list_params) as $param){
                        $string.=$row[$table["model1"]->table.".".$param];
                        $argsN[$param] = $row[$table["model1"]->table.".".$param];
                    }
                    $u = $table["model1"];
                    $result[$u->table] = new Table($u->servername, $u->db, $u->username, $u->password, $u->table, $argsN ,$u->pk, false);
                
                }
                $argsN = [];
                foreach(array_keys($table["model2"]->list_params) as $param){
                    $string.=$row[$table["model2"]->table.".".$param];
                    $argsN[$param] = $row[$table["model2"]->table.".".$param];
                }
                $u = $table["model2"];
                $result[$u->table] = new Table($u->servername, $u->db, $u->username, $u->password, $u->table, $argsN ,$u->pk, false);
            }
            
        }
        $result[$this->table] = new Table($this->servername, $this->db, $this->username, $this->password, $this->table, $args ,$this->pk, false);
        if($this->verbose == true)echo $string;
        }
        
        return $result;
    }
    
    function findAll($where=NULL, $join=NULL){
        //features we want back
        $features = [...array_map(function($m){return $this->table.".".$m." AS `".$this->table.".".$m."`";},array_keys($this->list_params))];
        //list of tables in FROM part
        $tableList = [$this->table];
        $temp = "";
        //i.e $join=[["model1"=>NULL, "attr1"=>"id", "model2"=>$userplanes, "attr2"=>"id_user"], ["model1"=>$userplanes, "attr1"=>"id_plane","model2"=>$planes, "attr2"=>"id"]]
        if($join !== NULL){
            $temp .= " WHERE ";
            foreach($join as $j){
                
                if($j["model1"] != NULL){
                    if(!in_array($j["model1"]->table, $tableList)){
                        
                            foreach(array_keys($j["model1"]->list_params) as $l){
                                //items we want to get back

                                $features[] = $j["model1"]->table.".".$l." AS `".$j["model1"]->table.".".$l."`";
                            }
                        
                        $tableList[] = $j["model1"]->table;
                    }
                }
                if(!in_array($j["model2"]->table, $tableList)){
                    foreach(array_keys($j["model2"]->list_params) as $l){
                        //items we want to get back
                        
                        $features[] = $j["model2"]->table.".".$l." AS `".$j["model2"]->table.".".$l."`";
                    }
                    $tableList[] = $j["model2"]->table;
                }
                //conditions of join
                $a = $j["model1"] == NULL?$this->table:$j["model1"]->table;
                $temp.= $a.".".$j["attr1"]." = ".$j["model2"]->table.".".$j["attr2"]." ";
                
                if($j !== $join[array_key_last($join)]){
                    $temp.=" AND ";
                }
            }
        }
        
        $features = implode(", ", $features);
        $stmt = "SELECT $features FROM ".implode(", ", $tableList);
        $stmt.= $temp;
        if($where == NULL){
            if($this->verbose == true) echo "no params";
            
        }else{
            if($join == NULL){ $stmt .= " WHERE ";}else{$stmt .= " AND ";}
            foreach(array_keys($where) as $key){
                if(gettype($where[$key])== "string"){
                    $stmt.= "$this->table.$key = '".$where[$key]."' ";
                }else  if(gettype($where[$key])== "integer"){
                    $stmt.= "$this->table.$key = ".$where[$key]." ";
                }
            }

        }
        //$stmt.= " LIMIT 1";
        
        if($this->verbose == true) echo "statement $stmt <br/>";
        echo $stmt."<br/>";
        $stmt = $this->conn->query($stmt);
        $rows = $stmt->fetchAll();
        if($this->verbose == true){
            echo "<br> <pre>";
            var_dump($rows);
            echo "</pre><br/>";
        }
       
        $string = "";
        $args = [];
        $result = [];
        if($rows != false){
            foreach($rows as $row){
                $temp = [];
                //ADD THIS TABLE TO RESULT    
                foreach(array_keys($this->list_params) as $param){
                    $string.=$row[$this->table.".".$param];
                    $args[$param] = $row[$this->table.".".$param];
                }
                
                
                $temp[$this->table] = new Table($this->servername, $this->db, $this->username, $this->pwd, $this->table, $args ,$this->pk, false);
                if($join !== NULL){
                    //ADD JOIN TABLES TO RESULT
                    foreach($join as $table){
                        if($table["model1"] != NULL){
                        
                            $argsN = [];
                            foreach(array_keys($table["model1"]->list_params) as $param){
                                $string.=$row[$table["model1"]->table.".".$param];
                                $argsN[$param] = $row[$table["model1"]->table.".".$param];
                            }
                            $u = $table["model1"];
                            $temp[$u->table] = new Table($u->servername, $u->db, $u->username, $u->password, $u->table, $argsN ,$u->pk, false);
                        
                        }
                        $argsN = [];
                        foreach(array_keys($table["model2"]->list_params) as $param){
                            $string.=$row[$table["model2"]->table.".".$param];
                            $argsN[$param] = $row[$table["model2"]->table.".".$param];
                        }
                        $u = $table["model2"];
                        $temp[$u->table] = new Table($u->servername, $u->db, $u->username, $u->password, $u->table, $argsN ,$u->pk, false);
                    }
                    
                }
            
                if($this->verbose == true)echo $string;
                $result[] = $temp;
            }
        }
        
        return $result;
    }

    
    function update($attr){
        $stmt = "UPDATE $this->table SET ";
        foreach(array_keys($attr) as $key){
            if(gettype($attr[$key])=="string"){
                $stmt.= "$key = '".$attr[$key]."' ";
            }elseif(gettype($attr[$key])=="int"){
                $stmt.= "$key = ".$attr[$key]." ";
            }
            if($key !== array_key_last($attr)){
                $stmt.= ", ";
            }
        }
        
        $stmt.="WHERE id = $this->id ;";
        echo $stmt;
        $this->conn->prepare($stmt)->execute();
      
    }
    function delete($id=NULL){
        $pk = $this->pk;
        echo var_dump($this->$pk);
        $stmt="DELETE FROM users WHERE ";
        if($id == NULL){
            $stmt.= "$this->pk=";
            if(gettype($this->$pk)=="string"){
                $stmt.= "'".$this->$pk."'";
            }elseif(gettype($this->$pk)=="integer"){
                $stmt.= $this->$pk;
            }
            
        }else{
            
            $keys = array_keys($id);
            foreach($keys as $key){
                $stmt.= "$key=";
                if(gettype($id[$key])=="string"){
                    $stmt.= "'$id[$key]'";
                }elseif(gettype($id[$key])=="integer"){
                    $stmt.= "$id[$key]";
                }
                if($key !== array_key_last($id)){
                    $stmt.= " AND ";
                }
            }
        }
        echo "stmt <br/>";
        echo $stmt;
        $stmt= $this->conn->prepare($stmt);
        $stmt->execute();
    
}
}
class TableGenerator{
    function __construct($server, $db, $user, $pwd){
      $this->db = $db;
      $this->pwd=$pwd;
      $this->user = $user;
      $this->server = $server;
    }
    function create($name, $list_params, $pk, $verbose){
        return new Table($this->server, $this->db, $this->user,$this->pwd, $name, $list_params, $pk, $verbose);
    }
    
}
/*
$myGenerator = new TableGenerator("localhost", "mercure", "root", "");
$user = $myGenerator->create("users", ["id"=>NULL, "firstname"=>NULL, "lastname"=>NULL, "pwd"=>NULL, "pwd_recup"=>NULL], "id", false);
$userplanes = $myGenerator->create("userplanes", ["id_plane"=>NULL, "id_user"=>NULL], "id", false);
$planes = $myGenerator->create("planes", ["id"=>NULL, "firstname"=>NULL, "name"=>NULL], "name", false);
//var_dump($user->getProps());
//$user = $user->create(["firstname"=>"Jean-Charles", "lastname"=>"Harris", "pwd"=>"1234", "pwd_recup"=>"1234"]);

echo "<pre>";
var_dump($user->find($where=["id"=>67], $join=[["model1"=>NULL, "attr1"=>"id", "model2"=>$userplanes, "attr2"=>"id_user"], ["model1"=>$userplanes, "attr1"=>"id_plane","model2"=>$planes, "attr2"=>"id"]]));

echo "</pre>";
//var_dump($user->findAll());
//$user->update(["firstname"=>"Tanguy", "lastname"=>"Leroy"]);
//$user->delete(["firstname"=>"Jean-Charles", "lastname"=>"Harris"]);
*/
?>

