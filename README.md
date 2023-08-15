# CrypChat

A encrypted realtime chat application using AES encryption and websockets
## Table of Contents

- [CrypChat](#crypchat)
  - [Table of Contents](#table-of-contents)
  - [Project Description](#project-description)
  - [Features](#features)
  - [Installation](#installation)

## Project Description

Project for Jagaad Academy module 3. 

Messages are encrypted via AES client side and are store encrypted in a sql db. The user decrypts the shared key via private key and shared key decrypt messages. 
Real time communication via Websocket server supprorts picture uploads , emojis and hyperlinks

## Features

- End to end encrypted 
- Realtime chatting 
- encrypted picture sharing
- emojis 
- hyperlinks


## Installation


```bash
git clone https://github.com/leonn00albert/CryptChat
cd CryptChat
composer install
php -S locahost:8000 
```

