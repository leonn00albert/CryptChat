const ws = new WebSocket('ws://192.168.1.100:8080');


selectedUsername = "";
var lastTimestamp = 0;
var currentConversation;
function getCookie(name) {
    var cookieValue = "";
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
      if (cookie.startsWith(name + "=")) {
        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
        break;
      }
    }
    return cookieValue;
  }
  
  var username = getCookie('username');

  ws.onopen = (event) => {
    ws.send(JSON.stringify({ action: 'register', username: username}));
};
const chatWindow = document.getElementById('chatWindow');
const conversationsWindow = document.getElementById('conversationsWindow');

function checkURLPattern() {
    const currentURL = window.location.pathname;
    const pattern = /^\/chats\/[a-zA-Z0-9]+$/;
    const isMatched = pattern.test(currentURL);
    return isMatched;
}

function extractHashFromURL() {
    const currentURL = window.location.pathname;
    const pattern = /^\/chats\/([a-zA-Z0-9]+)$/;
    const match = currentURL.match(pattern);
    if (match && match[1]) {
        const hash = match[1];
        return hash;
    }
    return null;
}

var sharedKey = null;
ws.onmessage = (event) => {
    const data = JSON.parse(event.data);

    if(data.channel === "notifications"){
        let message = JSON.parse(data.message);
        let chatItem = document.getElementById("chatItem-" + message.username);
        let chatText = document.getElementById("chatText-" + message.username);

        const notificationIcon = chatItem.querySelector(".notification-icon");
        if (!notificationIcon && (currentConversation !== message.conversation_hash)) {
            const notificationIconElement = document.createElement("span");
            notificationIconElement.classList.add("notification-icon");
            notificationIconElement.textContent = "🔴"; 
            chatText.textContent = message.message;
            chatItem.appendChild(notificationIconElement);
        }
    }else {
        let own = data.username == username ? true : false;
   
        chatWindow.insertAdjacentHTML('beforeend', renderMessage(decryptMessage(data.message, sharedKey),  own ));
    }


};
function fetchMessages() {
    fetch('/messages/latest/' + currentConversation + '?timestamp=' + lastTimestamp)
        .then(response => response.json())
        .then(data => {
            data.messages.forEach(message => {
                chatWindow.insertAdjacentHTML('beforeend', renderMessage(decryptMessage(message.message_text, sharedKey), message.own));
                lastTimestamp = message.timestamp
            });
        })
        .catch(error => console.error('Error fetching messages:', error));
}
window.onload = async function () {
    try {

        await getUsers();

    } catch (error) {
        console.error('Error:', error);
    }
};

function renderUser(username) {
    const sanitizeUsername = DOMPurify.sanitize(username);
    let htmlContent = `
        <a onclick="openChat('${username}')" id="chatItem-${username}"  class="list-group-item list-group-item-action list-group-item-light rounded-0">
                        <div class="media"><img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg"
                                alt="user" width="50" class="rounded-circle">
                            <div class="media-body ml-4">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h6 class="mb-0">${sanitizeUsername}</h6><small class="small font-weight-bold">2
                                        Sep</small>
                                </div>
                                <p id="chatText-${username}" class="font-italic text-muted mb-0 text-small">Quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </a>
        `
    return htmlContent;
}

function renderMessage(message, own = false) {

    const sanitizedMessage = DOMPurify.sanitize(message);

    let htmlContent = `
        <div class="media w-50 mb-3"><img src="https://bootstrapious.com/i/snippets/sn-chat/avatar.svg"
            alt="user" width="50" class="rounded-circle">
            <div class="media-body ml-3">
                 <div class="bg-light rounded py-2 px-3 mb-2">
                <p class="text-small mb-0 text-muted">${sanitizedMessage}</p>
                </div>
            <p class="small text-muted">12:00 PM | Aug 13</p>
        </div>
        </div>
        `;




    if (own) {
        htmlContent = `
             <div class="media w-50 ml-auto mb-3">
                <div class="media-body">
                    <div class="bg-primary rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-white">${sanitizedMessage}</p>
                    </div>
                    <p class="small text-muted">12:00 PM | Aug 13</p>
                </div>
            </div>
        `;

    }
    return htmlContent;
}

async function openChat(username) {
    selectedUsername = username;
    let chatItem = document.getElementById("chatItem-" + username);
    notificationIcon = chatItem.querySelector(".notification-icon");
    if (notificationIcon) {
            notificationIcon.remove();
      }

    chatWindow.innerHTML = "";
    const activeElements = document.getElementsByClassName('active');
    for (const element of activeElements) {
        element.classList.remove('active');
    }
    lastTimestamp = 0;
    ws.send(JSON.stringify({ action: 'unsubscribe', channel: currentConversation }));

    const { hash, key } = await getConversationHashAndKey(username);
    currentConversation = hash;
    sharedKey = key;
    fetchMessages();

     ws.send(JSON.stringify({ action: 'subscribe', channel: currentConversation }));

    chatItem.classList.add('active');
}

async function getConversationHashAndKey(username) {
    return fetch('/new/' + username)
        .then(response => response.json())
        .then(data => {
            return {
                hash: data.hash,
                key: data.sharedKey
            }

        })
        .catch(error => {
            console.error('Error:', error);
            throw error;
        });
}

async function getUsers() {
    return fetch('/users')
        .then(response => response.json())
        .then(data => {
            data.users.forEach(user => {
                conversationsWindow.insertAdjacentHTML('beforeend', renderUser(user.username));

            });
        })
        .catch(error => {
            console.error('Error:', error);
            throw error;
        });
}

async function getConversations() {
    return fetch('/conversations')
        .then(response => response.json())
        .then(data => {

        })
        .catch(error => {
            console.error('Error:', error);
            throw error;
        });
}

function encryptMessage(message, sharedKey) {
    return CryptoJS.AES.encrypt(message, sharedKey).toString();
}
function decryptMessage(message, sharedKey) {
    try {
        return CryptoJS.AES.decrypt(message, sharedKey).toString(CryptoJS.enc.Utf8);
    } catch (error) {
        console.error("Error while decrypting message:", error.message);
        return null;
    }
}
function sendMessage() {
    let message = document.getElementById("message").value;
    document.getElementById("message").value = "";
    const dataToSend = {
        conversation_hash: currentConversation,
        message: encryptMessage(message, sharedKey),
        username : username
    };

    ws.send(JSON.stringify({ action: 'sendToUser', username: selectedUsername, message: dataToSend }));

   ws.send(JSON.stringify({ action: 'broadcast', channel: currentConversation, message: dataToSend }));

    return fetch('/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dataToSend),
    })
        .then(response => response.json())
        .then(data => {
         
        })
        .catch(error => {
            console.error('Error:', error);
            throw error;
        });
        

}
