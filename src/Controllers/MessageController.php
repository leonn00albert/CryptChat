<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Utils\Auth\Authentication;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class MessageController
{
    /**
     * Create a new message in a conversation.
     *
     * @param array<string> $data The data for creating a message.
     */
    public static function create(array $data): void
    {
        try {
            Authentication::checkIfLoggedIn();
            $sanitized = [
                'conversation_hash' => trim(htmlspecialchars($data['conversation_hash'])),
                'message' => trim(htmlspecialchars($data['message'])),
            ];
            $conversation = Conversation::findByHash($sanitized['conversation_hash']);
            Authentication::isUserMemberOfConversation($conversation);
            $message = new Message($conversation->id, $sanitized['message'], $_SESSION['username']);
            $message->save();
            JSON::response(JSON::HTTP_STATUS_OK, 'success', 'Created a new message.');
        } catch (AuthException $e) {
            JSON::response($e->getCode(), 'error', $e->getMessage());
        } catch (Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }

    public static function getMessageByTimestamp(string $url): void
    {
        try {
            Authentication::checkIfLoggedIn();
            $parsedUrl = parse_url($url);
            $hash = $parsedUrl['path'];
            parse_str($parsedUrl['query'], $queryParams);
            $conversation = Conversation::findByHash($hash);
            Authentication::isUserMemberOfConversation($conversation);
            $messages = Message::findByConversationIdAndTimeStamp($conversation->id, $queryParams['timestamp']);
            $messages = array_map(
                static function ($message) {
                    if ($message->username === $_SESSION['username']) {
                        $message->own = true;
                    }
                    return $message;
                },
                $messages
            );
            echo json_encode(
                [
                    'messages' => $messages,
                ]
            );
        } catch (AuthException | Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }
}
