<?php




switch($_SERVER["REQUEST_URI"]){
    case "/hello":
        $file = file_get_contents('content/components/hello.html');
        echo $file;
        break;
    case "/content/security/encryption.php":
        echo "404";
        break;    
    default:
        header('Location: content/components/index.php');
        die();
        break;   
}

?>