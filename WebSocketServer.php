<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class SubscriptionServer implements MessageComponentInterface
{
    protected $subscribers = [];
    protected $users = [];
    public function onOpen(ConnectionInterface $conn)
    {

        $msg = "New connection! ({$conn->resourceId})\n";
        $this->logRequest($msg);
        echo  $msg;
    }

    public function onClose(ConnectionInterface $conn)
    {
        $foundUser = array_filter($this->users, function ($user) use ($conn) {
            return $user->resourceId === $conn->resourceId;
        });
        $this->goOffline(array_keys($foundUser)[0]);
        $msg = "Connection {$conn->resourceId} has disconnected\n";
        $this->unsubscribe($conn);
        $this->logRequest($msg);
        echo  $msg;
    }

    public function checkIfIsOnline(ConnectionInterface $conn, string $username)
    {
        if (in_array($username, array_keys($this->users))) {
            $conn->send(json_encode(["is_online" => $username]));
        }
    }

    public function goOffline(string $username)
    {
        unset($this->users[$username]);
        $this->broadcast("go_offline", $username);
    }

    public function goOnline(string $username)
    {
        $this->broadcast("go_online", $username);
    }


    public function onError(ConnectionInterface $conn, \Exception $e)
    {

        $conn->close();
        $msg = "An error has occurred: {$e->getMessage()}\n";
        $this->logRequest($msg);
        echo  $msg;
    }

    public function register(ConnectionInterface $conn, string $username)
    {
        $this->goOnline($username);
        $this->users[$username] = $conn;
        $msg = "New register : " . $username;
        $this->logRequest($msg);
        echo  $msg;
    }

    public function sendToUser(ConnectionInterface $conn, string $username, array $message)
    {
        foreach ($this->users as $user) {
            if ($user !== $conn) {
                if ($user->resourceId === $this->users[$username]->resourceId) {
                    $data = [
                        "message" => json_encode($message),
                        "channel" => "notifications",
                    ];
                    $user->send(json_encode($data));
                }
            }
        }
    }


    public function onMessage(ConnectionInterface $conn, $message)
    {
        $messageData = json_decode($message, true);

        if (isset($messageData['action'])) {
            switch ($messageData['action']) {
                case 'broadcast':
                    $this->broadcast($messageData['channel'], $messageData["message"]);
                    break;
                case 'register':
                    $this->register($conn, $messageData["username"]);
                    break;

                case 'sendToUser':
                    $this->sendToUser($conn, $messageData["username"], $messageData["message"]);
                    break;
                case 'subscribe':
                    $this->subscribe($conn, $messageData['channel']);
                    break;
                case 'is_online':
                    $this->checkIfIsOnline($conn, $messageData['username']);
                    break;
                case 'unsubscribe':
                    $this->unsubscribe($conn, $messageData['channel']);
                    break;

                default:
                    echo "Unknown action: {$messageData['action']}\n";
                    break;
            }
        } else {
            echo "Invalid message format\n";
        }
    }

    public function subscribe(ConnectionInterface $conn, $channel)
    {
        if (!isset($this->subscribers[$channel])) {
            $this->subscribers[$channel] = [];
        }

        $this->subscribers[$channel][$conn->resourceId] = $conn;
        $msg = "Subscribed {$conn->resourceId} to channel '{$channel}'\n";
        $this->logRequest($msg);
        echo $msg;
    }

    public function unsubscribe(ConnectionInterface $conn, $channel = null)
    {
        if ($channel !== null && isset($this->subscribers[$channel][$conn->resourceId])) {
            unset($this->subscribers[$channel][$conn->resourceId]);
            echo "Unsubscribed {$conn->resourceId} from channel '{$channel}'\n";
        } else {
            foreach ($this->subscribers as $channel => $subscribers) {
                if (isset($subscribers[$conn->resourceId])) {
                    unset($this->subscribers[$channel][$conn->resourceId]);
                    echo "Unsubscribed {$conn->resourceId} from channel '{$channel}'\n";
                }
            }
        }
    }

    public function broadcast($channel, $message)
    {
        if ($channel === "go_online") {
            foreach ($this->users as $user) {
                $data = [
                    "is_online" => $message,
                ];
                $user->send(json_encode($data));
            }
        }
        if ($channel === "go_offline") {
            foreach ($this->users as $user) {
                $data = [
                    "is_offline" => $message,
                ];
                $user->send(json_encode($data));
            }
        }
        if (isset($this->subscribers[$channel])) {
            foreach ($this->subscribers[$channel] as $conn) {
                $message["channel"] = $channel;
                $conn->send(json_encode($message));
            }
        }
    }

    protected function logRequest($logEntry)
    {
        $logFile =  __DIR__ . '/websocket_log.txt';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "$timestamp | $logEntry" . PHP_EOL;
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new SubscriptionServer()
        )
    ),
    8080
);

echo "WebSocket server is running...\n";

$server->run();
