<div class="api-tester">
    <!-- Left Panel: Chatbot Test Form -->
    <div class="api-left">
        <div class="api-form">
            <h3 style="color: #4CAF50; margin-bottom: 20px;">
                <i class="fas fa-comments"></i> Chatbot Test
            </h3>

            <!-- Provider Selector -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: 700; color: #aaa; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">LLM Provider</label>
                <div style="display: flex; gap: 10px; margin-top: 8px;">
                    <button id="btnProviderAgrinav"
                            onclick="selectProvider('agrinav')"
                            style="flex:1; padding: 10px 8px; border-radius: 8px; border: 2px solid #4CAF50;
                                   background: rgba(76,175,80,0.15); color: #4CAF50; font-weight: 700;
                                   font-size: 12px; cursor: pointer; transition: all 0.2s;">
                        <i class="fas fa-robot"></i><br>
                        <span style="font-size: 11px;">agrinav_agent</span><br>
                        <span style="font-size: 10px; color: #888;">be.ptpn1.co.id</span>
                    </button>
                    <button id="btnProviderWorkflow"
                            onclick="selectProvider('workflow')"
                            style="flex:1; padding: 10px 8px; border-radius: 8px; border: 2px solid #444;
                                   background: transparent; color: #888; font-weight: 700;
                                   font-size: 12px; cursor: pointer; transition: all 0.2s;">
                        <i class="fas fa-project-diagram"></i><br>
                        <span style="font-size: 11px;">aigr1_assistant</span><br>
                        <span style="font-size: 10px; color: #666;">workflow.ptpn1.co.id</span>
                    </button>
                </div>
            </div>

            <!-- Config Info (dinamis sesuai provider) -->
            <div id="configInfoAgrinav" class="info-card"
                 style="margin-bottom: 16px; padding: 12px; background: #141829; border: 1px solid #2a3555; border-radius: 6px;">
                <div style="font-weight: 600; margin-bottom: 8px; color: #888; font-size: 11px;">
                    <i class="fas fa-cog"></i> Konfigurasi: agrinav_agent
                </div>
                <div style="font-size: 11px; color: #555; font-family: 'Courier New', monospace; line-height: 1.8;">
                    <div>URL: <span style="color:#4CAF50;">{{ env('AI_BACKEND_URL', 'Not configured') }}</span></div>
                    <div>Agent: <span style="color:#4CAF50;">{{ env('AI_BACKEND_AGENT', 'Not configured') }}</span></div>
                    <div>Username: <span style="color:#4CAF50;">{{ env('AI_BACKEND_USERNAME', 'Not configured') }}</span></div>
                    <div>Auth: <span style="color:#4CAF50;">webChatToken (Bearer)</span></div>
                    <div>Format: <span style="color:#4CAF50;">application/json</span></div>
                </div>
            </div>
            <div id="configInfoWorkflow" class="info-card"
                 style="display:none; margin-bottom: 16px; padding: 12px; background: #141829; border: 1px solid #2a3555; border-radius: 6px;">
                <div style="font-weight: 600; margin-bottom: 8px; color: #888; font-size: 11px;">
                    <i class="fas fa-cog"></i> Konfigurasi: aigr1_assistant
                </div>
                <div style="font-size: 11px; color: #555; font-family: 'Courier New', monospace; line-height: 1.8;">
                    <div>URL: <span style="color:#FF9800;">{{ env('WORKFLOW_WEBHOOK_URL', 'Not configured') }}</span></div>
                    <div>Agent: <span style="color:#FF9800;">aigr1_assistant</span></div>
                    <div>Auth: <span style="color:#FF9800;">Tidak diperlukan</span></div>
                    <div>Format: <span style="color:#FF9800;">application/x-www-form-urlencoded</span></div>
                    <div>Field: <span style="color:#FF9800;">query (bukan message)</span></div>
                </div>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label for="chatbotMessage">Message</label>
                <textarea id="chatbotMessage" rows="4" placeholder="Enter your test message...">Halo, test connection</textarea>
            </div>

            <!-- Stream (hanya untuk agrinav) -->
            <div class="form-group" id="streamGroup">
                <label for="chatbotStream">Response Type</label>
                <select id="chatbotStream">
                    <option value="false" selected>Non-Streaming (Immediate)</option>
                    <option value="true">Streaming (SSE)</option>
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
                            onclick="setTestMessage('Test connection from admin panel')">
                        <i class="fas fa-plug"></i> Connection test
                    </button>
                </div>
            </div>

            <!-- Execute Button -->
            <button class="btn btn-execute" id="btnExecuteChatbot" onclick="executeChatbotTest()">
                <i class="fas fa-paper-plane"></i> Test Chatbot
            </button>
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
                    <p>Pilih provider lalu klik "Test Chatbot"</p>
                    <p style="font-size: 12px; margin-top: 10px; color: #888;">
                        Provider <strong style="color:#4CAF50;">agrinav_agent</strong>: login → webChatToken → kirim message (JSON)<br>
                        Provider <strong style="color:#FF9800;">aigr1_assistant</strong>: langsung kirim query (form-urlencoded)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.api-tester { display: flex; height: 100%; }
.api-left   { width: 50%; border-right: 1px solid #2a3555; display: flex; flex-direction: column; overflow: hidden; }
.api-right  { width: 50%; display: flex; flex-direction: column; overflow: hidden; }
.api-form   { padding: 20px; overflow-y: auto; flex: 1; }
.response-container { flex: 1; display: flex; flex-direction: column; background: #141829; overflow: hidden; }
.response-header    { padding: 15px 20px; border-bottom: 1px solid #2a3555; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
.response-body      { flex: 1; overflow-y: auto; padding: 20px; font-family: 'Courier New', monospace; font-size: 13px; white-space: pre-wrap; word-wrap: break-word; }
</style>

<script>
let activeProvider = 'agrinav';

function selectProvider(provider) {
    activeProvider = provider;

    const btnAgrinav  = document.getElementById('btnProviderAgrinav');
    const btnWorkflow = document.getElementById('btnProviderWorkflow');
    const cfgAgrinav  = document.getElementById('configInfoAgrinav');
    const cfgWorkflow = document.getElementById('configInfoWorkflow');
    const streamGroup = document.getElementById('streamGroup');

    if (provider === 'agrinav') {
        btnAgrinav.style.border      = '2px solid #4CAF50';
        btnAgrinav.style.background  = 'rgba(76,175,80,0.15)';
        btnAgrinav.style.color       = '#4CAF50';
        btnWorkflow.style.border     = '2px solid #444';
        btnWorkflow.style.background = 'transparent';
        btnWorkflow.style.color      = '#888';
        cfgAgrinav.style.display     = 'block';
        cfgWorkflow.style.display    = 'none';
        streamGroup.style.display    = 'block'; // SSE tersedia di agrinav
    } else {
        btnWorkflow.style.border     = '2px solid #FF9800';
        btnWorkflow.style.background = 'rgba(255,152,0,0.15)';
        btnWorkflow.style.color      = '#FF9800';
        btnAgrinav.style.border      = '2px solid #444';
        btnAgrinav.style.background  = 'transparent';
        btnAgrinav.style.color       = '#888';
        cfgWorkflow.style.display    = 'block';
        cfgAgrinav.style.display     = 'none';
        streamGroup.style.display    = 'none'; // workflow tidak support SSE
        document.getElementById('chatbotStream').value = 'false';
    }
}

function setTestMessage(msg) {
    document.getElementById('chatbotMessage').value = msg;
}

async function executeChatbotTest() {
    const message  = document.getElementById('chatbotMessage').value.trim();
    const stream   = document.getElementById('chatbotStream').value === 'true';
    const provider = activeProvider;

    if (!message) {
        alert('Masukkan pesan terlebih dahulu.');
        return;
    }

    const btn = document.getElementById('btnExecuteChatbot');
    btn.disabled   = true;
    btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i> Testing...';

    const responseDiv = document.getElementById('chatbotResponse');
    const statusSpan  = document.getElementById('chatbotStatus');
    const timeSpan    = document.getElementById('chatbotTime');

    responseDiv.textContent = 'Sending request...';
    statusSpan.textContent  = '';
    timeSpan.textContent    = '';

    const startTime = Date.now();

    try {
        const res = await fetch('/admin/logs/test-chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept':        'application/json',
            },
            body: JSON.stringify({ message, stream, provider }),
        });

        const elapsed = ((Date.now() - startTime) / 1000).toFixed(2);
        const data    = await res.json();

        // Status badge
        const ok = data.success && res.ok;
        statusSpan.innerHTML = ok
            ? '<span style="color:#4CAF50;">✅ Success</span>'
            : '<span style="color:#f44336;">❌ Failed</span>';
        timeSpan.textContent = elapsed + 's';

        // Provider badge
        const providerColor = data.provider === 'workflow' ? '#FF9800' : '#4CAF50';
        const providerLabel = data.provider === 'workflow' ? 'aigr1_assistant' : 'agrinav_agent';

        let output = `Provider : ${providerLabel} (${data.provider})\n`;
        output    += `Status   : ${data.status_code ?? 'N/A'}\n`;
        output    += `Time     : ${data.execution_time ?? elapsed + 's'}\n\n`;

        if (data.request) {
            output += `--- Request ---\n`;
            output += `URL    : ${data.request.url}\n`;
            output += `Format : ${data.request.format}\n`;
            output += `Payload: ${JSON.stringify(data.request.payload, null, 2)}\n\n`;
        }

        if (data.error) {
            output += `--- Error ---\n${data.error}\n\n`;
        }

        output += `--- Response ---\n`;
        try {
            const parsed = JSON.parse(data.response_body);
            output += JSON.stringify(parsed, null, 2);
        } catch {
            output += data.response_body ?? '(empty)';
        }

        responseDiv.textContent = output;

    } catch (err) {
        const elapsed = ((Date.now() - startTime) / 1000).toFixed(2);
        statusSpan.innerHTML = '<span style="color:#f44336;">❌ Error</span>';
        timeSpan.textContent = elapsed + 's';
        responseDiv.textContent = 'Request failed: ' + err.message;
    } finally {
        btn.disabled  = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Test Chatbot';
    }
}
</script>
