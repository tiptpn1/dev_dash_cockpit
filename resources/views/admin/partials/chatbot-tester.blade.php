<div class="api-tester">
    <!-- Left Panel: Chatbot Test Form -->
    <div class="api-left">
        <div class="api-form">
            <h3 style="color: #4CAF50; margin-bottom: 20px;">
                <i class="fas fa-comments"></i> Chatbot Test
            </h3>

            <div class="info-card" style="margin-bottom: 20px; padding: 15px; background: rgba(76, 175, 80, 0.1); border: 1px solid #4CAF50; border-radius: 6px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <i class="fas fa-info-circle" style="color: #4CAF50;"></i>
                    <strong style="color: #4CAF50;">Quick Chatbot Test</strong>
                </div>
                <p style="font-size: 13px; color: #b0b0b0; line-height: 1.6; margin: 0;">
                    Test chatbot endpoint dengan automatic token retrieval. 
                    Endpoint dan credentials diambil dari .env file.
                </p>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label for="chatbotMessage">Message</label>
                <textarea id="chatbotMessage" rows="4" placeholder="Enter your test message...">Halo, test connection</textarea>
            </div>

            <!-- Stream -->
            <div class="form-group">
                <label for="chatbotStream">Response Type</label>
                <select id="chatbotStream">
                    <option value="true" selected>Streaming (SSE) - Recommended</option>
                    <option value="false">Non-Streaming (Immediate Response)</option>
                </select>
            </div>

            <!-- Quick Actions -->
            <div class="form-group">
                <label>Quick Test Messages</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="btn" style="background: #2196F3; color: white; justify-content: flex-start;" 
                            onclick="setTestMessage('Halo')">
                        <i class="fas fa-comment"></i> Simple greeting
                    </button>
                    <button class="btn" style="background: #2196F3; color: white; justify-content: flex-start;" 
                            onclick="setTestMessage('Apa kabar?')">
                        <i class="fas fa-comment-dots"></i> Question
                    </button>
                    <button class="btn" style="background: #2196F3; color: white; justify-content: flex-start;" 
                            onclick="setTestMessage('Test connection from debug tools')">
                        <i class="fas fa-plug"></i> Connection test
                    </button>
                </div>
            </div>

            <!-- Execute Button -->
            <button class="btn btn-execute" id="btnExecuteChatbot" onclick="executeChatbotTest()">
                <i class="fas fa-paper-plane"></i> Test Chatbot
            </button>

            <!-- Config Info -->
            <div class="info-card" style="margin-top: 20px; padding: 15px; background: #141829; border: 1px solid #2a3555; border-radius: 6px;">
                <div style="font-weight: 600; margin-bottom: 10px; color: #888;">
                    <i class="fas fa-cog"></i> Configuration
                </div>
                <div style="font-size: 12px; color: #666; font-family: 'Courier New', monospace; line-height: 1.8;">
                    <div>URL: {{ env('AI_BACKEND_URL', 'Not configured') }}</div>
                    <div>Agent: {{ env('AI_BACKEND_AGENT', 'Not configured') }}</div>
                    <div>Username: {{ env('AI_BACKEND_USERNAME', 'Not configured') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel: Response -->
    <div class="api-right">
        <div class="response-container">
            <div class="response-header">
                <div class="response-title">
                    <i class="fas fa-terminal"></i> Test Results
                </div>
                <div class="response-meta" id="chatbotMeta">
                    <span id="chatbotStatus"></span>
                    <span id="chatbotTime"></span>
                </div>
            </div>
            <div class="response-body" id="chatbotResponse">
                <div style="text-align: center; color: #666; padding: 40px;">
                    <i class="fas fa-robot" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <p>Click "Test Chatbot" to start testing</p>
                    <p style="font-size: 12px; margin-top: 10px; color: #888;">
                        This will test the full chatbot flow:<br>
                        1. Get authentication token<br>
                        2. Send message to AI Backend<br>
                        3. Display response
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.api-tester {
    display: flex;
    height: 100%;
}

.api-left {
    width: 50%;
    border-right: 1px solid #2a3555;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.api-right {
    width: 50%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.api-form {
    padding: 20px;
    overflow-y: auto;
    flex: 1;
}

.response-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #141829;
    overflow: hidden;
}

.response-header {
    padding: 15px 20px;
    border-bottom: 1px solid #2a3555;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.response-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    font-family: 'Courier New', monospace;
    font-size: 13px;
    white-space: pre-wrap;
    word-wrap: break-word;
}
</style>
