const queryString = window.location.search;
let ws;
ws = new WebSocket('ws://18.233.9.49:8080');

/*
if (queryString.includes('dev')) {
} else {
    ws = new WebSocket('ws://18.233.9.49:8080');
}
*/

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
    ws.send(JSON.stringify({ action: 'register', username: username }));
};
const chatWindow = document.getElementById('chatWindow');
const conversationsWindow = document.getElementById('conversationsWindow');

function checkURLPattern() {
    const currentURL = window.location.pathname;
    const pattern = /^\/chats\/[a-zA-Z0-9]+$/;
    const isMatched = pattern.test(currentURL);
    return isMatched;
}

function formatCustomDate(isoDateString) {
    const date = new Date(isoDateString);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const seconds = String(date.getSeconds()).padStart(2, "0");

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
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
ws.onmessage = async (event) => {
    const data = JSON.parse(event.data);
    if (data.is_online && data.is_online !== username) {
        let userElement = document.getElementById("chatItem-" + data.is_online);
        let onlineIndicator = document.createElement("span");
        onlineIndicator.classList.add("user-online");
        onlineIndicator.innerText = "🟢";
        userElement.childNodes[1].prepend(onlineIndicator);
    }

    if (data.is_offline && data.is_offline !== username) {
        let userElement = document.getElementById("chatItem-" + data.is_offline);
        userElement.childNodes[1].childNodes[0].remove();
    }
    if (data.channel === "notifications") {
        let message = JSON.parse(data.message);
        let chatItem = document.getElementById("chatItem-" + message.username);

        const notificationIcon = chatItem.querySelector(".notification-icon");
        if (!notificationIcon && (currentConversation !== message.conversation_hash)) {
            let audioElement = document.getElementById('audioElement');
            audioElement.play();
            const notificationIconElement = document.createElement("span");
            notificationIconElement.classList.add("notification-icon");
            notificationIconElement.textContent = "🔴";
            chatItem.appendChild(notificationIconElement);
        }
    }

    if (data.username && data.message) {
        let own = data.username == username ? true : false;
        chatWindow.insertAdjacentHTML('beforeend', await renderMessage(decryptMessage(data.message, sharedKey), formatCustomDate(data.sent_at), "", own));
    }

};
function fetchMessages() {
    fetch('/messages/latest/' + currentConversation + '?timestamp=' + lastTimestamp)
        .then(response => response.json())
        .then(data => {
            chatWindow.innerHTML = "";

            data.messages.forEach(async message => {
                chatWindow.insertAdjacentHTML('beforeend', await renderMessage(decryptMessage(message.message_text, sharedKey), message.sent_at, message.id, message.own));
                lastTimestamp = message.timestamp
            });
        })
        .catch(error => console.error('Error fetching messages:', error));
}
window.onload = async function () {
    try {
        document.getElementById("button-addon2").disabled = true;
        document.getElementById("button-emoji").disabled = true;
        document.getElementById("button-picture").disabled = true;
        document.getElementById("message").disabled = true;
        await getUsers();

    } catch (error) {
        console.error('Error:', error);
    }
};

async function renderUser(username) {
    const profileImage = "/public/images/" + username + ".jpg";
    const imageSrc = await setImageSource(profileImage);
    const sanitizeUsername = DOMPurify.sanitize(username);
    ws.send(JSON.stringify({ action: 'is_online', username: username }));
    let htmlContent = `
        <a onclick="openChat('${username}')" id="chatItem-${username}"  class="list-group-item list-group-item-action list-group-item-light rounded-0">
                        <div class="media"><img src="${imageSrc}"
                                alt="user" width="50"   height="50" class="rounded-circle">
                            <div class="media-body ml-4">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h6 class="mb-0 username-field">${sanitizeUsername}</h6><small class="small font-weight-bold"></small>
                                </div>
                            </div>
                        </div>
                    </a>
        `
    return htmlContent;
}
function deleteMessage(id) {
    return fetch('/messages/' + id + "/delete")
        .then(response => response.json())
        .then(data => {
            openChat(selectedUsername);
        })
        .catch(error => {
            console.error('Error:', error);
            throw error;
        });
}
let cachedImageSrc = null;

async function cacheImageSource(imageSrc) {
    if (imageSrc !== cachedImageSrc) {
        const image = new Image();
        image.src = imageSrc;
        await image.decode();
        cachedImageSrc = imageSrc;
    }
}
function isBase64StringLikelyImage(base64String) {
    const possibleImageHeaders = ["data:image/jpeg", "data:image/png", "data:image/gif"];

    return possibleImageHeaders.some(header => base64String.startsWith(header));
}


async function renderMessage(message, dateTime, id, own = false) {
    const profileImage = "/public/images/" + selectedUsername + ".jpg";

    const imageSrc = await setImageSource(profileImage);
    await cacheImageSource(profileImage);
    const sanitizedMessage = DOMPurify.sanitize(message);

    function convertTextToLinks(text) {
        // Regular expression to match URLs
        var urlPattern = /(http(s)?:\/\/)?(www\.)?[a-zA-Z0-9]+(\.[a-zA-Z]{2,})+(\S+)?/g;
    
        // Replace URLs with anchor tags
        var replacedText = text.replace(urlPattern, function(matchedUrl) {
            return '<a href="' + matchedUrl + '" target="_blank">' + matchedUrl + '</a>';
        });
    
        return replacedText;
    }
    

    

        let htmlContent = `
        <div class="media w-50 mb-3"><img src="${cachedImageSrc}"
        alt="user" width="50"   height="50" class="profile-image rounded-circle">
            <div class="media-body ml-3">
                 <div class="bg-light rounded py-2 px-3 mb-2">
                <p class="text-small mb-0 text-muted">${convertTextToLinks(sanitizedMessage)}</p>
                </div>
            <p class="small text-muted">${formatNiceDate(dateTime)}</p>
        </div>
        </div>
        `;




    if (own) {
        htmlContent = `
             <div class="media w-50 ml-auto mb-3">
                <div class="media-body">
                    <div class="bg-primary rounded py-2 px-3 mb-2" style="display: flex;justify-content: space-between;"    > 
                        <p class="text-small mb-0 text-white">${convertTextToLinks(sanitizedMessage)}</p>
                        <span onclick="deleteMessage('${id}')" class="clickable"><i class="fa fa-trash"></i></span>
                    </div>
                    <p class="small text-muted">${formatNiceDate(dateTime)}</p>
                </div>
            </div>
        `;

    }
    if(isBase64StringLikelyImage(message) === true){
        htmlContent = `
        <div class="media w-50 ml-auto mb-3">
           <div class="media-body">
               <div class="rounded py-2 px-3 mb-2" style="display: flex;justify-content: space-between;"    > 
                   <img width="250" height="250" src ="${message}" />
                   <span onclick="deleteMessage('${id}')" class="clickable"><i class="fa fa-trash"></i></span>
               </div>
               <p class="small text-muted">${formatNiceDate(dateTime)}</p>
           </div>
       </div>
   `;
    }

    return htmlContent;
}

var lastImageChecked = "";
const imageExists = async (url) => {
    console.log(lastImageChecked);
    try {

        if (url !== lastImageChecked) {
            lastImageChecked = url;
            const response = await fetch(url);
            return response.ok;
        }

    } catch (error) {
        return false;
    }
};

const setImageSource = async (imageUrl) => {
    const defaultImageUrl = "https://cdn3.iconfinder.com/data/icons/vector-icons-6/96/256-256.png";

    if (await imageExists(imageUrl)) {
        return imageUrl;
    }
    return defaultImageUrl;
};

async function openChat(username) {
    let users = document.getElementById("users");
    let chats = document.getElementById("chats");
    users.classList.add("d-none");
    chats.classList.remove("d-none");

    document.getElementById("button-picture").disabled = false;
    document.getElementById("button-addon2").disabled = false;
    document.getElementById("button-emoji").disabled = false;

    const messagesLoading = document.getElementById("messagesLoading");
    messagesLoading.style.visibility = "visible";
    document.getElementById("message").disabled = false;
    selectedUsername = username;
    let chatItem = document.getElementById("chatItem-" + username);
    notificationIcon = chatItem.querySelector(".notification-icon");
    if (notificationIcon) {
        notificationIcon.remove();
    }

    const activeElements = document.getElementsByClassName('active');
    for (const element of activeElements) {
        element.classList.remove('active');
    }
    lastTimestamp = 0;
    ws.send(JSON.stringify({ action: 'unsubscribe', channel: currentConversation }));

    const { hash, key } = await getConversationHashAndKey(username);
    currentConversation = hash;
    sharedKey = key;
    await fetchMessages();
    messagesLoading.style.visibility = "hidden";
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
    const userLoading = document.getElementById("usersLoading");
    return fetch('/users')
        .then(response => response.json())
        .then(data => {
            userLoading.style.visibility = "hidden";
            data.users.forEach(async user => {
                conversationsWindow.insertAdjacentHTML('beforeend', await renderUser(user.username));

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

const messageInput = document.getElementById("message");

messageInput.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === 'Enter') {
        sendMessage();
    }
});
function sendMessage(message=null) {

    if(message === null){
        message = document.getElementById("message").value;
        document.getElementById("message").value = "";
    }
    const dataToSend = {
        conversation_hash: currentConversation,
        message: encryptMessage(message, sharedKey),
        username: username,
        sent_at: new Date().toISOString()
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

function formatNiceDate(dateString) {
    const date = new Date(dateString);

    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
        hour12: true,
    };

    return date.toLocaleString(undefined, options);
}
