<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Debug Tools - AGRINAV</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0e27;
            color: #e0e0e0;
            overflow: hidden;
        }

        .debug-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .debug-header {
            background: #1a1f3a;
            padding: 15px 20px;
            border-bottom: 2px solid #2a3555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .debug-title {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .debug-title::before {
            content: '🛠️';
            font-size: 24px;
        }

        .debug-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-close {
            background: #666;
            color: white;
        }

        .btn-close:hover {
            background: #555;
        }

        /* Tabs */
        .tabs {
            background: #141829;
            display: flex;
            border-bottom: 1px solid #2a3555;
        }

        .tab {
            padding: 15px 25px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #888;
        }

        .tab:hover {
            background: #1a1f3a;
            color: #e0e0e0;
        }

        .tab.active {
            color: #4CAF50;
            border-bottom-color: #4CAF50;
            background: #1a1f3a;
        }

        .tab-icon {
            font-size: 16px;
        }

        /* Tab Content */
        .tab-content {
            display: none;
            flex: 1;
            overflow: hidden;
        }

        .tab-content.active {
            display: flex;
            flex-direction: column;
        }

        /* Logs Tab (reuse previous styles) */
        @import url('{{ asset('css/log-viewer.css') }}');
        
        .log-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }

        /* API Tester Tab */
        .api-tester {
            display: flex;
            height: 100%;
            flex: 1;
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #b0b0b0;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #2a3555;
            border-radius: 4px;
            background: #141829;
            color: #e0e0e0;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            font-family: 'Courier New', monospace;
            min-height: 100px;
            resize: vertical;
        }

        .btn-execute {
            background: #4CAF50;
            color: white;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
        }

        .btn-execute:hover {
            background: #45a049;
        }

        .btn-execute:disabled {
            background: #666;
            cursor: not-allowed;
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

        .response-title {
            font-weight: 600;
            color: #4CAF50;
        }

        .response-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #888;
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

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
        }

        .status-badge.success {
            background: #4CAF50;
            color: white;
        }

        .status-badge.error {
            background: #f44336;
            color: white;
        }

        .status-badge.warning {
            background: #FFC107;
            color: #000;
        }

        /* System Info */
        .system-info {
            padding: 20px;
            overflow-y: auto;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: #141829;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #2a3555;
        }

        .info-card-title {
            font-weight: 600;
            color: #4CAF50;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #2a3555;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #888;
            font-size: 14px;
        }

        .info-value {
            color: #e0e0e0;
            font-weight: 500;
            font-family: 'Courier New', monospace;
        }

        /* Quick Actions */
        .quick-actions {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .action-card {
            background: #141829;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #2a3555;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .action-card:hover {
            background: #1a1f3a;
            border-color: #4CAF50;
            transform: translateY(-2px);
        }

        .action-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .action-title {
            font-weight: 600;
            color: #e0e0e0;
            margin-bottom: 5px;
        }

        .action-desc {
            font-size: 13px;
            color: #888;
        }

        /* Headers Editor */
        .headers-list {
            margin-top: 10px;
        }

        .header-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .header-item input {
            flex: 1;
        }

        .btn-remove {
            padding: 10px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-add {
            background: #2196F3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 5px;
        }

        /* Scrollbar */
        *::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        *::-webkit-scrollbar-track {
            background: #0a0e27;
        }

        *::-webkit-scrollbar-thumb {
            background: #2a3555;
            border-radius: 5px;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: #3a4565;
        }

        /* Loading */
        .loading {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        .spinner {
            border: 3px solid #2a3555;
            border-top: 3px solid #4CAF50;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="debug-container">
        <!-- Header -->
        <div class="debug-header">
            <div class="debug-title">
                Debug Tools & Log Viewer
            </div>
            <div class="debug-actions">
                <button class="btn btn-close" onclick="window.close() || history.back()">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <div class="tab active" onclick="switchTab('logs')">
                <span class="tab-icon"><i class="fas fa-file-alt"></i></span>
                <span>Logs</span>
            </div>
            <div class="tab" onclick="switchTab('api-tester')">
                <span class="tab-icon"><i class="fas fa-plug"></i></span>
                <span>API Tester</span>
            </div>
            <div class="tab" onclick="switchTab('chatbot')">
                <span class="tab-icon"><i class="fas fa-comments"></i></span>
                <span>Chatbot Test</span>
            </div>
            <div class="tab" onclick="switchTab('system')">
                <span class="tab-icon"><i class="fas fa-server"></i></span>
                <span>System Info</span>
            </div>
        </div>

        <!-- Tab Content: Logs -->
        <div id="tab-logs" class="tab-content active">
            @include('admin.partials.log-viewer-content')
        </div>

        <!-- Tab Content: API Tester -->
        <div id="tab-api-tester" class="tab-content">
            @include('admin.partials.api-tester')
        </div>

        <!-- Tab Content: Chatbot Test -->
        <div id="tab-chatbot" class="tab-content">
            @include('admin.partials.chatbot-tester')
        </div>

        <!-- Tab Content: System Info -->
        <div id="tab-system" class="tab-content">
            @include('admin.partials.system-info')
        </div>
    </div>

    <script src="{{ asset('js/log-viewer.js') }}"></script>
    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            // Show selected tab
            document.querySelector(`[onclick="switchTab('${tabName}')"]`).classList.add('active');
            document.getElementById(`tab-${tabName}`).classList.add('active');
            
            // Load content if needed
            if (tabName === 'system') {
                loadSystemInfo();
            }
        }

        function loadSystemInfo() {
            const container = document.getElementById('system-info-container');
            if (container.dataset.loaded === 'true') return;
            
            container.innerHTML = '<div class="loading"><div class="spinner"></div>Loading system information...</div>';
            
            fetch('/admin/logs/system-info')
                .then(response => response.json())
                .then(data => {
                    renderSystemInfo(data);
                    container.dataset.loaded = 'true';
                })
                .catch(error => {
                    container.innerHTML = `<div class="loading">Failed to load: ${error.message}</div>`;
                });
        }

        function renderSystemInfo(data) {
            const container = document.getElementById('system-info-container');
            
            let html = '<div class="info-grid">';
            
            // PHP Info
            html += `
                <div class="info-card">
                    <div class="info-card-title"><i class="fab fa-php"></i> PHP Info</div>
                    <div class="info-item">
                        <span class="info-label">Version</span>
                        <span class="info-value">${data.php_version}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Memory Limit</span>
                        <span class="info-value">${data.memory_limit}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Max Execution Time</span>
                        <span class="info-value">${data.max_execution_time}s</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Upload Max</span>
                        <span class="info-value">${data.upload_max_filesize}</span>
                    </div>
                </div>
            `;
            
            // Laravel Info
            html += `
                <div class="info-card">
                    <div class="info-card-title"><i class="fab fa-laravel"></i> Laravel Info</div>
                    <div class="info-item">
                        <span class="info-label">Version</span>
                        <span class="info-value">${data.laravel_version}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Environment</span>
                        <span class="info-value">${data.environment}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Debug Mode</span>
                        <span class="info-value">${data.debug_mode ? 'Enabled' : 'Disabled'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Timezone</span>
                        <span class="info-value">${data.timezone}</span>
                    </div>
                </div>
            `;
            
            // AI Backend Info
            html += `
                <div class="info-card">
                    <div class="info-card-title"><i class="fas fa-robot"></i> LLM Provider 1 — agrinav_agent (Active)</div>
                    <div class="info-item">
                        <span class="info-label">URL</span>
                        <span class="info-value">${data.ai_backend_url}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Agent</span>
                        <span class="info-value">${data.ai_backend_agent}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Base URL</span>
                        <span class="info-value">${data.ai_backend_base}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Username</span>
                        <span class="info-value">${data.ai_backend_user}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Timeout</span>
                        <span class="info-value">${data.ai_timeout}s</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Auth</span>
                        <span class="info-value">webChatToken (Bearer)</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Format</span>
                        <span class="info-value">application/json</span>
                    </div>
                </div>
            `;

            html += `
                <div class="info-card">
                    <div class="info-card-title"><i class="fas fa-project-diagram"></i> LLM Provider 2 — aigr1_assistant (Legacy)</div>
                    <div class="info-item">
                        <span class="info-label">URL</span>
                        <span class="info-value" style="word-break:break-all;">${data.ai_workflow_url}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Agent</span>
                        <span class="info-value">aigr1_assistant</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Auth</span>
                        <span class="info-value">Tidak diperlukan</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Format</span>
                        <span class="info-value">application/x-www-form-urlencoded</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Field pesan</span>
                        <span class="info-value">query (bukan message)</span>
                    </div>
                </div>
            `;
            
            // Server Info
            html += `
                <div class="info-card">
                    <div class="info-card-title"><i class="fas fa-hdd"></i> Server</div>
                    <div class="info-item">
                        <span class="info-label">Cache Driver</span>
                        <span class="info-value">${data.cache_driver}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Session Driver</span>
                        <span class="info-value">${data.session_driver}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Queue Driver</span>
                        <span class="info-value">${data.queue_driver}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Disk Free Space</span>
                        <span class="info-value">${data.disk_free_space}</span>
                    </div>
                </div>
            `;
            
            html += '</div>';
            container.innerHTML = html;
        }
    </script>
</body>
</html>
