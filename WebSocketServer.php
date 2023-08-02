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
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection {$conn->resourceId} has disconnected\n";
        $this->unsubscribe($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function register(ConnectionInterface $conn, string $username)
    {
        $this->users[$username] = $conn;
        echo "New register : " . $username;
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
        echo "Subscribed {$conn->resourceId} to channel '{$channel}'\n";
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
        if (isset($this->subscribers[$channel])) {
            foreach ($this->subscribers[$channel] as $conn) {
                $message["channel"] = $channel;
                $conn->send(json_encode($message));
            }
        }
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
