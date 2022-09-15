<?php
    require __DIR__ . '/vendor/autoload.php';

    echo "hello";

?>


<script>


let socket = new WebSocket("ws://localhost:8080");

socket.onopen = function(e) {
  alert("[open] Connection established");
  alert("Sending to server");
  socket.send("My name is John");
};

socket.onmessage = function(event) {
  alert(`[message] Data received from server: ${event.data}`);
};
</script>