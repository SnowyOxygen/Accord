<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->groups= [];
    }
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n \n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $groups= [];    
        $test  =[];
        //{type: "event", data:"myData"}
        $data = json_decode($msg, true);
        switch($data['type']){
            case "joinGroup":
                $group = $data["data"]["group"];
                $groups[$group][] = $from;
                break;


            case "joinRoom":
                $test[] = json_encode($from);
                $room = $data["data"]['room'];
                $group = $data["data"]['group'];
                foreach($this->clients as $client){
                    if($client == $from){
                        $client->group = $group.$room;
                    }
                }
                
                echo "joinRoom \n";
                echo sprintf('message "%s"' . "\n \n"
                    ,json_encode($data));

                //Broadcast
               
                
                break;

            case "sendMessage":
                echo "\n sendMessage \n";
                echo sprintf('message "%s"' . "\n \n"
                     ,json_encode($data["data"]['room']));

                //Broadcast
                $room = $data["data"]['room'];
                $group = $data["data"]['group'];
                foreach ($this->clients as $client) {
                    if($client->group == $group.$room){
                        if($from !== $client){
                            $client->send($msg);
                        }
                    }
                }

                break;
            case "joinVideo":
                break;  
            case "leaveVideo":
                break;           
            default:
                
                break;
        }





        
      
    }

    public function onClose(ConnectionInterface $conn) {
         // The connection is closed, remove it, as we can no longer send it messages
         $this->clients->detach($conn);

         echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

?>