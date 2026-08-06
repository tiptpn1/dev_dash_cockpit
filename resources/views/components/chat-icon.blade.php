<div class="chat-icon-container">
    <img src="{{ asset('evo.gif') }}" alt="Chat Icon" class="chat-icon" id="chatIcon" style="width: 100px; height: 100px;">
</div>

<div class="chat-container" id="chatContainer">
    <div class="chat-header">
        <div class="chat-title">AIGR1 Assistant</div>
        <div class="chat-controls">
            <button class="expand-btn" id="expandChat" title="Expand/Collapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                </svg>
            </button>
            <button class="close-btn" id="closeChat" title="Close">&times;</button>
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
        <button class="mic-button" id="micButton" title="Voice Input">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
                <line x1="12" y1="19" x2="12" y2="23"/>
                <line x1="8" y1="23" x2="16" y2="23"/>
            </svg>
        </button>
        <button class="send-button" id="sendMessage" title="Send Message">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg>
        </button>
    </div>
</div>

<!-- Load external libraries for rich content -->
<link rel="stylesheet" href="{{ asset('css/chat-rich-content.css') }}">
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/chat-content-renderer.js') }}"></script>
<script src="{{ asset('js/chat-page-context.js') }}"></script>

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
    width: 400px;
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

.thread-id {
    font-size: 12px;
    color: #b0b0b0;
    margin-top: 2px;
    text-align: right;
    display: none;
}

.message-content.streaming::after {
    content: '▋';
    animation: chatCursorBlink 1s infinite;
    margin-left: 2px;
}

@keyframes chatCursorBlink {
    0%, 49% { opacity: 1; }
    50%, 100% { opacity: 0; }
}

.chart-generating-hint {
    font-size: 12px;
    color: #90caf9;
    margin-top: 6px;
    opacity: 0.85;
}

.message-content code {
    background: #1e1e1e;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
}

.message-content pre {
    background: #1e1e1e;
    padding: 10px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 10px 0;
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
    let currentSessionId = ''; // sessionId untuk percakapan berkelanjutan (follow-up)
    
    // Initialize ChatContentRenderer
    const contentRenderer = new ChatContentRenderer();
    
    // Initialize Page Context Manager
    const pageContext = new ChatPageContext();
    
    // Collect context on page load
    setTimeout(() => {
        pageContext.collectAll();
        console.log('📋 Initial page context collected:', pageContext.getContextSummary());
    }, 1000);
    
    // Listen to context updates
    pageContext.onContextUpdate((context) => {
        console.log('🔄 Page context updated:', pageContext.getContextSummary());
    });

    // Initially hide the chat container
    chatContainer.style.display = 'none';

    // --- Drag and Drop for Chat Icon ---
    const chatIconContainer = document.querySelector('.chat-icon-container');
    let isDragging = false;
    let isMoved = false;
    let shiftX, shiftY;

    function startDrag(e) {
        if (e.button !== 0 && e.type !== 'touchstart') return; // only left click
        
        isDragging = true;
        isMoved = false;

        const rect = chatIconContainer.getBoundingClientRect();
        
        let clientX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
        let clientY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;

        shiftX = clientX - rect.left;
        shiftY = clientY - rect.top;

        // Switch to absolute positioning based on fixed viewport
        chatIconContainer.style.bottom = 'auto';
        chatIconContainer.style.right = 'auto';

        function moveAt(cX, cY) {
            // Constrain within window bounds
            let newLeft = cX - shiftX;
            let newTop = cY - shiftY;

            const maxLeft = window.innerWidth - chatIconContainer.offsetWidth;
            const maxTop = window.innerHeight - chatIconContainer.offsetHeight;

            newLeft = Math.max(0, Math.min(newLeft, maxLeft));
            newTop = Math.max(0, Math.min(newTop, maxTop));

            chatIconContainer.style.left = newLeft + 'px';
            chatIconContainer.style.top = newTop + 'px';
        }

        function onMouseMove(event) {
            if (!isDragging) return;
            isMoved = true;
            
            if (event.type === 'touchmove') {
                event.preventDefault(); // Prevent scrolling while dragging
            }
            
            let currentClientX = event.type === 'touchmove' ? event.touches[0].clientX : event.clientX;
            let currentClientY = event.type === 'touchmove' ? event.touches[0].clientY : event.clientY;
            
            moveAt(currentClientX, currentClientY);
        }

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('touchmove', onMouseMove, { passive: false });

        function onMouseUp() {
            isDragging = false;
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('touchmove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
            document.removeEventListener('touchend', onMouseUp);
        }

        document.addEventListener('mouseup', onMouseUp);
        document.addEventListener('touchend', onMouseUp);
    }

    chatIconContainer.addEventListener('mousedown', startDrag);
    chatIconContainer.addEventListener('touchstart', startDrag, { passive: false });

    chatIconContainer.ondragstart = function() {
        return false;
    };

    // Toggle chat container when clicking the icon
    chatIcon.addEventListener('click', function(e) {
        if (isMoved) {
            e.preventDefault();
            return;
        }
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
    function getCsrfToken() {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (!metaTag) {
            console.error('CSRF token meta tag not found!');
            return null;
        }
        return metaTag.getAttribute('content');
    }

    async function sendUserMessage() {
        const message = chatInput.value.trim();
        if (message) {
            // Get CSRF token
            const csrfToken = getCsrfToken();
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page.');
                return;
            }
            
            // Collect latest page context
            pageContext.collectAll();
            const contextSummary = pageContext.getContextSummary();
            const fullContext = pageContext.getFullContext();

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

            // Create assistant message container for streaming
            const assistantMessageDiv = document.createElement('div');
            assistantMessageDiv.className = 'message assistant';
            assistantMessageDiv.innerHTML = `
                <div class="message-content">🧠 Thinking...</div>
            `;
            chatMessages.appendChild(assistantMessageDiv);

            const messageContent = assistantMessageDiv.querySelector('.message-content');
            let fullResponse = '';
            let isThinking = true;
            let lastRenderPromise = Promise.resolve(); // lacak render async terakhir agar tidak race dengan gambar/chart

            try {
                const response = await fetch('/ai/response', {
                    method: 'POST', 
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'text/event-stream',
                    },
                    body: JSON.stringify({ 
                        message: message,
                        stream: true,
                        sessionId: currentSessionId, // kunci follow-up (kosong = sesi baru)
                        agent: { name: 'agrinav_agent' }, // Auth & userId ditangani backend
                        
                        // Page context untuk AI reference
                        pageContext: {
                            summary: contextSummary,  // Format ringkas
                            full: fullContext         // Data lengkap
                        }
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // Stream response using ReadableStream
                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';
                let currentEvent = null;

                while (true) {
                    const { done, value } = await reader.read();
                    
                    if (done) break;
                    
                    buffer += decoder.decode(value, { stream: true });
                    const lines = buffer.split('\n');
                    buffer = lines.pop() || '';
                    
                    for (const line of lines) {
                        // Handle SSE event type
                        if (line.startsWith('event:')) {
                            currentEvent = line.substring(6).trim();
                            continue;
                        }
                        
                        if (line.startsWith('data:')) {
                            try {
                                const jsonStr = line.substring(5).trim();
                                if (!jsonStr) continue;
                                
                                const data = JSON.parse(jsonStr);
                                
                                // Use event type from SSE or from data.type
                                const eventType = currentEvent || data.type;
                                
                                switch (eventType) {
                                    case 'thinking':
                                        // Hanya timpa bubble dengan indikator "berpikir" SEBELUM ada teks jawaban.
                                        // Setelah token/partial_response tampil, event thinking lanjutan (mis. saat
                                        // proses pembuatan chart) TIDAK BOLEH menimpa jawaban yang sudah ditampilkan.
                                        if (isThinking) {
                                            messageContent.textContent = `🧠 ${data.message}`;
                                        }
                                        break;
                                        
                                    case 'skill_called': {
                                        // Backend sekarang mengirim field 'label' yang sudah user-friendly
                                        // (mis. "mengambil data", "membuat visualisasi"). JANGAN tampilkan
                                        // data.skill mentah (nama teknis seperti "trigger_n8n") ke user.
                                        // Fallback ke mapping manual hanya untuk kompatibilitas mundur jika
                                        // backend lama belum mengirim field 'label'.
                                        const skillLabelFallback = {
                                            generate_chart_image: 'membuat visualisasi',
                                            trigger_n8n: 'mengambil data',
                                        };
                                        const friendlyLabel = data.label || skillLabelFallback[data.skill] || 'memproses permintaan';
                                        const isChartSkill = data.skill === 'generate_chart_image';
                                        
                                        if (isThinking) {
                                            messageContent.textContent = `${isChartSkill ? '📊' : '⚙️'} ${friendlyLabel}...`;
                                        } else if (isChartSkill) {
                                            // Teks jawaban sudah tampil (dari partial_response) — tampilkan
                                            // indikator kecil terpisah tanpa mengganggu teks yang sudah ada.
                                            if (!assistantMessageDiv.querySelector('.chart-generating-hint')) {
                                                const hint = document.createElement('div');
                                                hint.className = 'chart-generating-hint';
                                                hint.textContent = `📊 ${friendlyLabel}...`;
                                                assistantMessageDiv.appendChild(hint);
                                            }
                                        }
                                        break;
                                    }
                                        
                                    case 'skill_result': {
                                        // Sama seperti skill_called: gunakan label user-friendly, bukan
                                        // data.skill mentah. Event ini opsional untuk UI (progress "selesai").
                                        const resultLabel = data.label || data.skill || 'proses';
                                        console.log(`✔️ Skill selesai: ${resultLabel}`);
                                        break;
                                    }
                                        
                                    case 'partial_response': {
                                        // Backend: teks jawaban sudah final (chart, jika ada, masih diproses
                                        // dan menyusul di event 'done'). Tampilkan teks SEKARANG, jangan tunggu done.
                                        // Strategi B (sesuai panduan): render dari partial_response, idempotent
                                        // terhadap isi 'token' yang identik (set, bukan append, ke fullResponse).
                                        const partialContent = data.response && data.response.message && data.response.message.content;
                                        if (partialContent) {
                                            isThinking = false;
                                            messageContent.classList.remove('streaming');
                                            fullResponse = partialContent;
                                            lastRenderPromise = contentRenderer.renderContent(fullResponse).then(rendered => {
                                                const cleaned = rendered.replace(/【\d+:\d+†source】/g, '');
                                                messageContent.innerHTML = cleaned;
                                                chatMessages.scrollTop = chatMessages.scrollHeight;
                                            });
                                        }
                                        
                                        const partialSessionId = data.sessionId || (data.response && data.response.sessionId);
                                        if (partialSessionId) {
                                            currentSessionId = partialSessionId;
                                        }
                                        
                                        // PENTING: jangan tutup/cancel stream di sini — tunggu event 'done' (bisa
                                        // membawa chart) atau 'error'. Loop pembaca di bawah tetap berjalan normal.
                                        break;
                                    }
                                        
                                    case 'token':
                                        // Remove thinking indicator on first token
                                        if (isThinking) {
                                            isThinking = false;
                                            messageContent.textContent = '';
                                            fullResponse = '';
                                        }
                                        
                                        // Add streaming class for cursor effect
                                        messageContent.classList.add('streaming');
                                        
                                        // Append token to response
                                        fullResponse += data.token;
                                        
                                        // Render with ChatContentRenderer (async)
                                        lastRenderPromise = contentRenderer.renderContent(fullResponse).then(rendered => {
                                            // Clean up unwanted markers
                                            const cleaned = rendered.replace(/【\d+:\d+†source】/g, '');
                                            messageContent.innerHTML = cleaned;
                                            
                                            // Auto-scroll to bottom
                                            chatMessages.scrollTop = chatMessages.scrollHeight;
                                        });
                                        
                                        break;
                                        
                                    case 'done': {
                                        console.log('✅ Response completed');
                                        
                                        // Remove streaming cursor
                                        messageContent.classList.remove('streaming');
                                        
                                        // Bersihkan hint "Membuat grafik..." (chart final akan tampil sebagai gambar)
                                        const chartHint = assistantMessageDiv.querySelector('.chart-generating-hint');
                                        if (chartHint) chartHint.remove();
                                        
                                        // Simpan sessionId untuk follow-up (percakapan berkelanjutan)
                                        const sessionId = data.sessionId || (data.response && data.response.sessionId);
                                        if (sessionId) {
                                            currentSessionId = sessionId;
                                            
                                            // Tampilkan Session ID di bawah pesan user
                                            const existingSessionId = userMessageDiv.querySelector('.thread-id');
                                            if (!existingSessionId) {
                                                const sessionIdDiv = document.createElement('div');
                                                sessionIdDiv.className = 'thread-id';
                                                sessionIdDiv.textContent = `Session ID: ${sessionId}`;
                                                userMessageDiv.appendChild(sessionIdDiv);
                                            }
                                        }
                                        
                                        const contentBlocks = data.response && data.response.contentBlocks;
                                        
                                        if (Array.isArray(contentBlocks) && contentBlocks.length > 0) {
                                            // Kontrak A (disarankan): render urutan teks+chart apa adanya dari backend,
                                            // mendukung BANYAK chart tersisip di posisi yang tepat (bukan hanya yang terakhir).
                                            lastRenderPromise.then(() => {
                                                return contentRenderer.renderContentBlocks(contentBlocks);
                                            }).then(html => {
                                                messageContent.innerHTML = html;
                                                chatMessages.scrollTop = chatMessages.scrollHeight;
                                            });
                                            
                                            // Untuk TTS, tetap pakai teks lengkap dari message.content (bukan gabungan
                                            // per-block) supaya narasi tidak terpotong-potong.
                                            const blocksSpeechText = (data.response && data.response.message && data.response.message.content) || '';
                                            if (blocksSpeechText) {
                                                speakText(blocksSpeechText);
                                            }
                                        } else {
                                            // Kontrak B (fallback lama, backward compatible)
                                            let finalResponse = '';
                                            if (data.response && data.response.message) {
                                                finalResponse = data.response.message.content;
                                            } else if (data.response) {
                                                finalResponse = data.response;
                                            }
                                            
                                            // Display final response if not already streamed
                                            if (finalResponse && !fullResponse) {
                                                lastRenderPromise = contentRenderer.renderContent(finalResponse).then(rendered => {
                                                    const cleaned = rendered.replace(/【\d+:\d+†source】/g, '');
                                                    messageContent.innerHTML = cleaned;
                                                });
                                                fullResponse = finalResponse;
                                            }
                                            
                                            // Render gambar/chart hasil skill backend (chart PNG dari generate_chart_image,
                                            // atau hasil vision). Format: response.images = { output: url, input: url }.
                                            // Catatan: images.output hanya berisi chart TERAKHIR jika ada lebih dari satu.
                                            // Tunggu render teks selesai dulu (lastRenderPromise) agar <img> tidak
                                            // ketimpa innerHTML dari renderContent() yang masih berjalan (race condition).
                                            const images = data.response && data.response.images;
                                            if (images && images.output) {
                                                lastRenderPromise.then(() => {
                                                    const imgWrap = document.createElement('div');
                                                    imgWrap.className = 'ai-generated-image';
                                                    imgWrap.innerHTML = `<img src="${images.output}" alt="Chart/Visualisasi dari AI" loading="lazy">`;
                                                    messageContent.appendChild(imgWrap);
                                                    chatMessages.scrollTop = chatMessages.scrollHeight;
                                                });
                                            }
                                            
                                            // Automatically speak the complete response using speakable text extraction
                                            if (fullResponse) {
                                                speakText(fullResponse);
                                            }
                                        }
                                        break;
                                    }
                                        
                                    case 'error':
                                        console.error('❌ Error:', data.error);
                                        messageContent.innerHTML = `<span style="color: #ff6b6b;">Error: ${data.error}</span>`;
                                        break;
                                }
                                
                                // Reset current event after processing
                                currentEvent = null;
                                
                            } catch (parseError) {
                                console.error('Failed to parse SSE data:', parseError, 'Line:', line);
                            }
                        }
                    }
                }
                
            } catch (error) {
                console.error('Streaming Error:', error);
                
                // Show error message
                messageContent.innerHTML = `<span style="color: #ff6b6b;">Maaf, terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi.</span>`;
            }

            // Scroll to bottom after completion
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Modified speak text function - uses ChatContentRenderer to extract speakable text
    function speakText(text) {
        // Cancel any ongoing speech
        window.speechSynthesis.cancel();
        
        // Extract speakable text using ChatContentRenderer (removes code, charts, maps, etc.)
        const cleanText = contentRenderer.extractSpeakableText(text);
        
        // Skip if nothing to speak
        if (!cleanText.trim()) {
            console.log('No speakable text found');
            return;
        }
        
        const utterance = new SpeechSynthesisUtterance(cleanText);
        utterance.lang = 'id-ID'; // Set to Indonesian language
        utterance.rate = 1.3;  // Slightly slower rate for better clarity
        utterance.pitch = 1.0; // Speech pitch
        
        // Resume speaking if browser pauses it
        let isPlaying = true;
        
        utterance.onend = () => {
            isPlaying = false;
        };
        
        utterance.onerror = (event) => {
            console.error('SpeechSynthesis Error:', event);
            isPlaying = false;
        };
        
        // Keep checking and resume if needed
        const resumeInfinity = setInterval(() => {
            if (!isPlaying) {
                clearInterval(resumeInfinity);
                return;
            }
            
            if (speechSynthesis.paused) {
                speechSynthesis.resume();
            }
        }, 100);
        
        // Speak the text
        window.speechSynthesis.speak(utterance);
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

// --- WEBSOCKET CHAT FEATURE (DISABLED) ---
/*
// Ganti ws://localhost:6001 dengan endpoint WebSocket server Anda
const ws = new WebSocket('ws://localhost:6001');

ws.onopen = function() {
    console.log('WebSocket connected');
};

ws.onmessage = function(event) {
    try {
        const wsData = JSON.parse(event.data);
        if (wsData.type === 'chat-message') {
            // Tampilkan pesan baru dari server
            const assistantMessageDiv = document.createElement('div');
            assistantMessageDiv.className = 'message assistant';
            assistantMessageDiv.innerHTML = `
                <div class="message-content">${wsData.message}</div>
            `;
            chatMessages.appendChild(assistantMessageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            speakText(wsData.message);
        }
    } catch (e) {
        console.error('WebSocket message error:', e);
    }
};

ws.onerror = function(error) {
    console.error('WebSocket error:', error);
};

// Kirim pesan ke server via WebSocket (opsional, jika backend support)
function sendUserMessageWS(message) {
    if (ws.readyState === WebSocket.OPEN) {
        ws.send(JSON.stringify({ type: 'chat-message', message: message, thread_id: currentThreadId }));
    }
}
*/
</script>