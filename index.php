<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
use App\Utils\HttpLogger;

HttpLogger::logRequest();
Router::get('/login', 'home/login');
Router::get('/logout', 'home/logout');
Router::get('/register', 'home/register');
Router::get('/', 'home/index');
Router::post('/auth/login', 'auth/login');
Router::get('/admin', 'admin/index'); // move later
Router::get('/admin/users/{id}/edit', 'admin/users/edit'); // move later
Router::get('/admin/users/{id}/delete', 'admin/users/delete'); // move later
Router::get('/admin/users', 'admin/users'); // move later
Router::get('/admin/logs', 'admin/logs'); // move later
Router::get('/api/users', 'api/users'); // move later
Router::get('/api/httplogs', 'api/httplogs'); // move later
Router::get('/api/users/{id}', 'api/users/id'); // move later
Router::post('/api/users/{id}/update', 'api/users/update'); // move later
Router::get('/api/messages', 'api/messages'); // move later
if (isset($_SESSION['auth']) && $_SESSION['auth']) {
    Router::get('/chat', 'chat/index');
    Router::get('/settings', 'settings');
    Router::get('/chats/{hash}', 'chat/show');
    Router::get('/new/{username}', 'chat/new');
    Router::get('/users', 'users');
    Router::get('/conversations/{hash}', 'conversations');
    Router::get('/conversation/keys/1', 'get/key');
    Router::get('/users/keys/1', 'users/key');
    Router::get('/message', 'message');
    Router::get('/messages/latest/{hash}', 'messages');
    Router::post('/messages', 'messages/new');
    Router::post('/user', 'user/create');
    Router::post('/users/search', 'users/search');
    Router::post('/upload/image', 'upload/image');
    Router::post('/settings/password', 'settings/password');
}

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
    Router::get('/admin', 'admin/index');
}

Router::start();
