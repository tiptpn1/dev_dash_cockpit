<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AIGR1 - PTPN 1</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">    
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
</head>
<body>
    <div class="chat-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <button class="new-chat">+ New chat</button>
                </div>
                <div class="chat-history">
                    <ul id="history-list">
                        <!-- Template untuk item riwayat chat -->
                        <li class="history-item">
                            <span class="chat-title">Chat 1</span>
                            <div class="history-actions">
                                <button class="edit-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/>
                                    </svg>
                                </button>
                                <button class="delete-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24">
                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12z"/>
                                    </svg>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sidebar-header bottom-button">
                <a href="{{ route('overview') }}" class="new-chat" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Back To AGRINAV
                </a>
            </div>
        </aside>

        <!-- Main chat area -->
        <main class="main-content">
            <div id="chat-container">
                <div style="text-align: center; padding: 1rem;">
                    <img src="https://ptpn1.co.id/wp-content/themes/logistic_new/asset_apn/logo/aset_2.png" alt="PTPN 1 Logo" style="max-width: 100px;">
                </div>
                <div class="chat-header">
                    <h1>Artificial Intelligence for Agribusiness PTPN 1</h1>
                    <h2>(AIGR1)</h2>
                </div>
                <div class="chat-interface">
                    <div class="chat-container" id="chat-messages">
                        <div class="message assistant">
                            <div class="avatar">
                                <img src="{{ asset('evopng.png') }}" alt="AI Avatar">
                            </div>
                            <div class="message-content">
                                Hi! I'm EVO. Your AI assistant. How can I help you today?
                            </div>
                        </div>
                    </div>
                    <div class="input-container">
                        <textarea 
                            id="message-input" 
                            placeholder="Type your message here..." 
                            rows="1"
                            style="height: 52px;"
                        ></textarea>
                        <button id="send-button" class="send-button">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.01 21L23 12L2.01 3L2 10L17 12L2 14L2.01 21Z" fill="currentColor"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="loading-popup" class="loading-popup hidden">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">AI sedang berpikir...</div>
        </div>
    </div>

    <style>
    .chat-interface {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .chat-container {
        flex-grow: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .message {
        display: flex;
        gap: 20px;
        padding: 10px 20px;
        border-radius: 8px;
        max-width: 80%;
        align-items: flex-start;
    }

    .message .avatar {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message .avatar img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .message.user {
        background-color: #f3f4f6;  /* Abu-abu muda */
        color: #000000;            /* Teks hitam */
        margin-left: auto;
    }

    .message.user .avatar svg {
        width: 24px;
        height: 24px;
        color: #4b5563;  /* Warna abu-abu untuk icon user */
    }

    .message.assistant {
        background-color: #000000;
        color: white;
        margin-right: auto;
    }

    .message-content {
        line-height: 1.5;
    }

    .input-container {
        display: flex;
        gap: 10px;
        padding: 20px;
        background: white;
        border-top: 1px solid #e5e7eb;
    }

    #message-input {
        flex-grow: 1;
        padding: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        resize: none;
        font-family: inherit;
        font-size: inherit;
        line-height: 1.5;
    }

    .send-button {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .send-button:hover {
        background-color: #1d4ed8;
    }

    .thinking {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .thinking span {
        width: 8px;
        height: 8px;
        background-color: #ffffff;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
    }

    .thinking span:nth-child(1) { animation-delay: -0.32s; }
    .thinking span:nth-child(2) { animation-delay: -0.16s; }

    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }

    .history-item {
        cursor: pointer;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        transition: background-color 0.2s;
    }
    .history-item:hover {
        background-color: #f3f4f6;
    }
    .history-item.active {
        background-color: #e5e7eb;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        const historyList = document.getElementById('history-list');
        let isProcessing = false;
        let currentChatId = Date.now();

        // Definisikan fungsi addMessage di awal
        function addMessage(content, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'message user' : 'message assistant';
            
            let messageHTML = '';
            
            if (isUser) {
                messageHTML = `
                    <div class="avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="message-content">${content}</div>
                `;
            } else {
                messageHTML = `
                    <div class="avatar">
                        <img src="{{ asset('evopng.png') }}" alt="AI Avatar">
                    </div>
                    <div class="message-content">${content}</div>
                `;
            }
            
            messageDiv.innerHTML = messageHTML;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function addThinkingMessage() {
            const thinkingDiv = document.createElement('div');
            thinkingDiv.className = 'message assistant';
            thinkingDiv.innerHTML = `
                <div class="avatar">
                    <img src="{{ asset('evopng.png') }}" alt="AI Avatar">
                </div>
                <div class="message-content thinking">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            chatMessages.appendChild(thinkingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return thinkingDiv;
        }

        // Fungsi untuk menyimpan chat ke localStorage
        function saveChat(chatId, messages) {
            const chats = JSON.parse(localStorage.getItem('chats') || '{}');
            chats[chatId] = {
                id: chatId,
                title: messages[0]?.content.slice(0, 30) + '...' || 'New Chat',
                messages: messages,
                timestamp: Date.now()
            };
            localStorage.setItem('chats', JSON.stringify(chats));
            updateHistoryList();
        }

        // Fungsi untuk memuat chat dari localStorage
        function loadChat(chatId) {
            const chats = JSON.parse(localStorage.getItem('chats') || '{}');
            const chat = chats[chatId];
            if (chat) {
                chatMessages.innerHTML = '';
                chat.messages.forEach(msg => {
                    if (typeof msg === 'string') {
                        // Handle legacy format
                        addMessage(msg, false);
                    } else {
                        // Handle new format with isUser property
                        addMessage(msg.content, msg.isUser);
                    }
                });
                currentChatId = chatId;
                
                // Highlight active chat in history
                document.querySelectorAll('.history-item').forEach(item => {
                    item.classList.remove('active');
                    if (item.dataset.chatId === chatId.toString()) {
                        item.classList.add('active');
                    }
                });
            }
        }

        // Fungsi untuk update daftar history
        function updateHistoryList() {
            const chats = JSON.parse(localStorage.getItem('chats') || '{}');
            historyList.innerHTML = '';
            
            Object.values(chats)
                .sort((a, b) => b.timestamp - a.timestamp)
                .forEach(chat => {
                    const li = document.createElement('li');
                    li.className = 'history-item';
                    li.dataset.chatId = chat.id;
                    li.innerHTML = `
                        <span class="chat-title">${chat.title}</span>
                        <div class="history-actions">
                            <button class="edit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/>
                                </svg>
                            </button>
                            <button class="delete-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12z"/>
                                </svg>
                            </button>
                        </div>
                    `;

                    // Tambahkan event listener untuk klik pada history item
                    li.addEventListener('click', function(e) {
                        if (!e.target.closest('.edit-btn') && !e.target.closest('.delete-btn')) {
                            loadChat(chat.id);
                        }
                    });

                    historyList.appendChild(li);
                });
        }

        // Fungsi untuk membuat chat baru
        function startNewChat() {
            currentChatId = Date.now();
            chatMessages.innerHTML = `
                <div class="message assistant">
                    <div class="avatar">
                        <img src="{{ asset('evopng.png') }}" alt="AI Avatar">
                    </div>
                    <div class="message-content">
                        Hi! I'm your AI assistant. How can I help you today?
                    </div>
                </div>
            `;
            messageInput.value = '';
            
            // Simpan chat baru ke localStorage
            saveChat(currentChatId, [{
                content: "Hi! I'm your AI assistant. How can I help you today?",
                isUser: false
            }]);
        }

        async function handleSubmit() {
            if (isProcessing) return;

            const message = messageInput.value.trim();
            if (!message) return;

            isProcessing = true;
            messageInput.value = '';
            messageInput.style.height = '52px';
            
            // Simpan pesan user
            const messages = [];
            const userMessage = { content: message, isUser: true };
            messages.push(userMessage);
            addMessage(message, true);

            const thinkingMessage = addThinkingMessage();

            try {
                const response = await fetch('/ai/response', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const response_data = await response.json();
                const data = response_data.data;

                thinkingMessage.remove();
                
                if (data && data.response) {
                    const cleanResponse = data.response
                        .replace(/【\d+:\d+†source】/g, '')
                        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\n/g, '<br>');
                    
                    // Simpan response AI
                    const aiMessage = { content: cleanResponse, isUser: false };
                    messages.push(aiMessage);
                    addMessage(cleanResponse);
                    
                    // Update chat history
                    saveChat(currentChatId, messages);
                } else {
                    addMessage('Sorry, I received an empty response.');
                }
            } catch (error) {
                console.error('Error:', error);
                thinkingMessage.remove();
                addMessage('Sorry, there was an error processing your request. Please try again.');
            } finally {
                isProcessing = false;
            }
        }

        // Event Listeners
        sendButton.addEventListener('click', handleSubmit);

        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleSubmit();
            }
        });

        // New Chat button handler
        const newChatButton = document.querySelector('.new-chat');
        if (newChatButton) {
            newChatButton.addEventListener('click', startNewChat);
        }

        // Update event listeners untuk history items
        historyList.addEventListener('click', function(e) {
            const historyItem = e.target.closest('.history-item');
            if (!historyItem) return;

            const chatId = historyItem.dataset.chatId;

            if (e.target.closest('.edit-btn')) {
                loadChat(chatId);
            } else if (e.target.closest('.delete-btn')) {
                const chats = JSON.parse(localStorage.getItem('chats') || '{}');
                delete chats[chatId];
                localStorage.setItem('chats', JSON.stringify(chats));
                updateHistoryList();
                if (currentChatId === chatId) {
                    startNewChat();
                }
            }
        });

        // Tambahkan style untuk active chat
        const style = document.createElement('style');
        style.textContent = `
            .history-item {
                cursor: pointer;
                padding: 10px;
                margin: 5px 0;
                border-radius: 5px;
                transition: background-color 0.2s;
            }
            .history-item:hover {
                background-color: #f3f4f6;
            }
            .history-item.active {
                background-color: #e5e7eb;
            }
        `;
        document.head.appendChild(style);

        // Initialize
        updateHistoryList();
        if (!localStorage.getItem('chats')) {
            startNewChat();
        }
    });
    </script>
</body>
</html>
