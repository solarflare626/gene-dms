<?php

require_once 'core/init.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

echo "Starting server on http:localhost:8080 \n";
$server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
          8080
         );

$server->run();



