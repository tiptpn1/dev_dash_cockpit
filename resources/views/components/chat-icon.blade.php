<div class="chat-icon-container">
    <img src="{{ asset('evo.gif') }}" alt="Chat Icon" class="chat-icon" id="chatIcon" style="width: 100px; height: 100px;">
</div>

<div class="chat-container" id="chatContainer">
    <div class="chat-header">
        <div class="chat-title">AIGR1 Assistant</div>
        <div class="chat-controls">
            <button class="expand-btn" id="expandChat">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                </svg>
            </button>
            <button class="close-btn" id="closeChat">&times;</button>
        </div>
    </div>
    <div class="chat-messages" id="chatMessages">
        <div class="message assistant">
            <div class="message-content">
                Halo Saya Evo! Ada yang bisa saya bantu hari ini?
            </div>
        </div>
    </div>
    <div class="chat-input-container">
        <textarea class="chat-input" id="chatInput" placeholder="Type your message..." rows="1"></textarea>
        <button class="mic-button" id="micButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                <line x1="12" y1="19" x2="12" y2="23"/>
                <line x1="8" y1="23" x2="16" y2="23"/>
            </svg>
        </button>
        <button class="send-button" id="sendMessage">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</div>

<style>
.chat-icon-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    cursor: pointer;
}

.chat-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.chat-icon:hover {
    transform: scale(1.1);
}

.chat-container {
    display: none;
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 350px;
    height: 600px;
    background: #0A1929;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 15px;
    background: #202123;
    color: white;
    border-radius: 15px 15px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-title {
    font-weight: bold;
}

.chat-controls {
    display: flex;
    gap: 10px;
    align-items: center;
}

.close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
}

.chat-messages {
    flex-grow: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message {
    display: flex;
    margin-bottom: 10px;
}

.message.user {
    justify-content: flex-end;
}

.message-content {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    background: #132F4C;
    color: #ffffff;
}

.message.user .message-content {
    background: #0084ff;
    color: white;
}

.chat-input-container {
    padding: 15px;
    border-top: 1px solid #1E4976;
    display: flex;
    gap: 10px;
    align-items: flex-end;
}

.chat-input {
    flex-grow: 1;
    border: 1px solid #1E4976;
    border-radius: 8px;
    padding: 8px 12px;
    resize: none;
    max-height: 200px;
    font-family: inherit;
    background: #132F4C;
    color: #ffffff;
}

.mic-button, .send-button {
    background: none;
    border: none;
    color: #0084ff;
    cursor: pointer;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
}

.mic-button:hover, .send-button:hover {
    background: #f0f0f0;
    border-radius: 8px;
}

.mic-button.recording {
    color: #ff0000;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.expand-btn {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
}

.expand-btn:hover {
    color: #0084ff;
}

.chat-container.fullscreen {
    width: 90vw;
    height: 90vh;
    bottom: 5vh;
    right: 5vw;
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatIcon = document.getElementById('chatIcon');
    const chatContainer = document.getElementById('chatContainer');
    const closeChat = document.getElementById('closeChat');
    const chatInput = document.getElementById('chatInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    const micButton = document.getElementById('micButton');
    const expandChat = document.getElementById('expandChat');
    let recognition = null;

    // Initially hide the chat container
    chatContainer.style.display = 'none';

    // Toggle chat container when clicking the icon
    chatIcon.addEventListener('click', function() {
        chatContainer.style.display = 'flex';
    });

    // Close chat when clicking the close button
    closeChat.addEventListener('click', function() {
        chatContainer.style.display = 'none';
    });

    // Check if browser supports speech recognition
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        recognition = new (window.webkitSpeechRecognition || window.SpeechRecognition)();
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'id-ID'; // Set to Indonesian language

        recognition.onstart = function() {
            micButton.classList.add('recording');
            chatInput.placeholder = 'Listening...';
        };

        recognition.onend = function() {
            micButton.classList.remove('recording');
            chatInput.placeholder = 'Type your message...';
        };

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            chatInput.value = transcript;
            // Auto send message after speech recognition
            sendUserMessage();
        };

        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
            micButton.classList.remove('recording');
            chatInput.placeholder = 'Type your message...';
        };

        // Toggle speech recognition on mic button click
        micButton.addEventListener('click', function() {
            if (micButton.classList.contains('recording')) {
                recognition.stop();
            } else {
                recognition.start();
            }
        });
    } else {
        micButton.style.display = 'none';
        console.log('Speech recognition not supported');
    }

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function sendUserMessage() {
        const message = chatInput.value.trim();
        if (message) {
            // Add user message to chat
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'message user';
            userMessageDiv.innerHTML = `
                <div class="message-content">${message}</div>
            `;
            chatMessages.appendChild(userMessageDiv);

            // Clear input and scroll to bottom
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                // Show loading message
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'message assistant';
                loadingDiv.innerHTML = `
                    <div class="message-content">Thinking...</div>
                `;
                chatMessages.appendChild(loadingDiv);

                const response = await fetch('/ai/response', {
                    method: 'POST', 
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: message }) // Kirim data dalam JSON
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const response_data = await response.json();
                const data = response_data.data;

                // Remove loading message
                chatMessages.removeChild(loadingDiv);

                // Add AI response
                const assistantMessageDiv = document.createElement('div');
                assistantMessageDiv.className = 'message assistant';
                assistantMessageDiv.innerHTML = `
                    <div class="message-content">${data.response}</div>
                `;
                chatMessages.appendChild(assistantMessageDiv);
            } catch (error) {
                console.error('Error:', error);
                // Show error message
                const errorMessageDiv = document.createElement('div');
                errorMessageDiv.className = 'message assistant';
                errorMessageDiv.innerHTML = `
                    <div class="message-content">Sorry, there was an error processing your request. Please try again.</div>
                `;
                chatMessages.appendChild(errorMessageDiv);
            }

            // Scroll to bottom after adding new message
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Send message on button click
    sendMessage.addEventListener('click', sendUserMessage);

    // Send message on Enter key (Shift+Enter for new line)
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendUserMessage();
        }
    });

    // Auto-resize textarea
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Add expand/collapse functionality
    expandChat.addEventListener('click', function() {
        chatContainer.classList.toggle('fullscreen');
        const isFullscreen = chatContainer.classList.contains('fullscreen');
        
        // Update expand button icon based on state
        expandChat.innerHTML = isFullscreen 
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/></svg>';
    });
});
</script> 