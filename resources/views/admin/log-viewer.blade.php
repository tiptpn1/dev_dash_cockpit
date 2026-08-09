<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Viewer - AGRINAV</title>
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

        .log-viewer-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .log-header {
            background: #1a1f3a;
            padding: 15px 20px;
            border-bottom: 2px solid #2a3555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .log-title {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .log-title::before {
            content: '📋';
            font-size: 24px;
        }

        .log-actions {
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

        .btn-refresh {
            background: #4CAF50;
            color: white;
        }

        .btn-refresh:hover {
            background: #45a049;
        }

        .btn-clear {
            background: #f44336;
            color: white;
        }

        .btn-clear:hover {
            background: #da190b;
        }

        .btn-download {
            background: #2196F3;
            color: white;
        }

        .btn-download:hover {
            background: #0b7dda;
        }

        .btn-close {
            background: #666;
            color: white;
        }

        .btn-close:hover {
            background: #555;
        }

        /* Controls */
        .log-controls {
            background: #1a1f3a;
            padding: 15px 20px;
            border-bottom: 1px solid #2a3555;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .control-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .control-group label {
            font-size: 14px;
            color: #b0b0b0;
        }

        select, input[type="text"], input[type="number"] {
            padding: 8px 12px;
            border: 1px solid #2a3555;
            border-radius: 4px;
            background: #0a0e27;
            color: #e0e0e0;
            font-size: 14px;
        }

        select:focus, input:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .search-box {
            flex-grow: 1;
            max-width: 300px;
        }

        /* Status Bar */
        .status-bar {
            background: #141829;
            padding: 8px 20px;
            border-bottom: 1px solid #2a3555;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #888;
        }

        .status-info {
            display: flex;
            gap: 20px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        .status-badge.loading {
            background: #FFC107;
            color: #000;
        }

        .status-badge.success {
            background: #4CAF50;
            color: #fff;
        }

        .status-badge.error {
            background: #f44336;
            color: #fff;
        }

        /* Log Content */
        .log-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }

        .log-entry {
            margin-bottom: 15px;
            border-left: 4px solid #2a3555;
            padding: 12px;
            background: #141829;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .log-entry:hover {
            background: #1a1f3a;
            border-left-color: #4CAF50;
        }

        .log-entry.level-ERROR {
            border-left-color: #f44336;
            background: rgba(244, 67, 54, 0.1);
        }

        .log-entry.level-WARNING {
            border-left-color: #FFC107;
            background: rgba(255, 193, 7, 0.1);
        }

        .log-entry.level-INFO {
            border-left-color: #2196F3;
            background: rgba(33, 150, 243, 0.1);
        }

        .log-entry.level-DEBUG {
            border-left-color: #9C27B0;
            background: rgba(156, 39, 176, 0.1);
        }

        .log-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 8px;
            font-size: 12px;
        }

        .log-timestamp {
            color: #888;
        }

        .log-level {
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: 600;
            font-size: 11px;
        }

        .log-level.ERROR {
            background: #f44336;
            color: white;
        }

        .log-level.WARNING {
            background: #FFC107;
            color: #000;
        }

        .log-level.INFO {
            background: #2196F3;
            color: white;
        }

        .log-level.DEBUG {
            background: #9C27B0;
            color: white;
        }

        .log-level.NOTICE {
            background: #00BCD4;
            color: white;
        }

        .log-message {
            color: #e0e0e0;
            word-wrap: break-word;
            margin-bottom: 8px;
        }

        .log-context {
            color: #888;
            font-size: 12px;
            white-space: pre-wrap;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #2a3555;
            max-height: 200px;
            overflow-y: auto;
        }

        .log-context::-webkit-scrollbar {
            width: 6px;
        }

        .log-context::-webkit-scrollbar-track {
            background: #0a0e27;
        }

        .log-context::-webkit-scrollbar-thumb {
            background: #2a3555;
            border-radius: 3px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        /* Scrollbar */
        .log-content::-webkit-scrollbar {
            width: 10px;
        }

        .log-content::-webkit-scrollbar-track {
            background: #0a0e27;
        }

        .log-content::-webkit-scrollbar-thumb {
            background: #2a3555;
            border-radius: 5px;
        }

        .log-content::-webkit-scrollbar-thumb:hover {
            background: #3a4565;
        }

        /* Loading */
        .loading-indicator {
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

        /* Highlight search */
        .highlight {
            background: #FFC107;
            color: #000;
            padding: 2px 4px;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="log-viewer-container">
        <!-- Header -->
        <div class="log-header">
            <div class="log-title">
                Laravel Log Viewer
            </div>
            <div class="log-actions">
                <button class="btn btn-refresh" onclick="refreshLogs()">
                    🔄 Refresh
                </button>
                <button class="btn btn-download" onclick="downloadLog()">
                    📥 Download
                </button>
                <button class="btn btn-clear" onclick="clearLog()">
                    🗑️ Clear Log
                </button>
                <button class="btn btn-close" onclick="window.close() || history.back()">
                    ✕ Close
                </button>
            </div>
        </div>

        <!-- Controls -->
        <div class="log-controls">
            <div class="control-group">
                <label>Log File:</label>
                <select id="logSelect" onchange="loadLog()">
                    @foreach($logs as $log)
                        <option value="{{ $log['path'] }}" {{ $loop->first ? 'selected' : '' }}>
                            {{ $log['name'] }} ({{ number_format($log['size'] / 1024, 2) }} KB)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="control-group">
                <label>Level:</label>
                <select id="levelFilter" onchange="loadLog()">
                    <option value="all">All Levels</option>
                    <option value="ERROR">Error</option>
                    <option value="WARNING">Warning</option>
                    <option value="INFO">Info</option>
                    <option value="DEBUG">Debug</option>
                </select>
            </div>

            <div class="control-group">
                <label>Lines:</label>
                <input type="number" id="linesCount" value="100" min="10" max="1000" step="10" onchange="loadLog()" style="width: 80px;">
            </div>

            <div class="control-group search-box">
                <label>Search:</label>
                <input type="text" id="searchFilter" placeholder="Filter logs..." oninput="debouncedSearch()">
            </div>
        </div>

        <!-- Status Bar -->
        <div class="status-bar">
            <div class="status-info">
                <span id="statusText">Ready</span>
                <span id="logInfo"></span>
            </div>
            <span id="lastUpdate"></span>
        </div>

        <!-- Log Content -->
        <div class="log-content" id="logContent">
            <div class="loading-indicator">
                <div class="spinner"></div>
                Loading logs...
            </div>
        </div>
    </div>

    <script>
        let searchTimeout = null;

        // Load log on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadLog();
        });

        function loadLog() {
            const logPath = document.getElementById('logSelect').value;
            const lines = document.getElementById('linesCount').value;
            const level = document.getElementById('levelFilter').value;
            const filter = document.getElementById('searchFilter').value;

            document.getElementById('statusText').innerHTML = '<span class="status-badge loading">Loading...</span>';
            document.getElementById('logContent').innerHTML = '<div class="loading-indicator"><div class="spinner"></div>Loading logs...</div>';

            fetch('/admin/logs/get', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    path: logPath,
                    lines: parseInt(lines),
                    level: level,
                    filter: filter
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }

                renderLogs(data);
                document.getElementById('statusText').innerHTML = '<span class="status-badge success">Loaded</span>';
                document.getElementById('logInfo').textContent = `${data.total} entries | ${(data.size / 1024).toFixed(2)} KB`;
                document.getElementById('lastUpdate').textContent = `Last modified: ${data.modified}`;
            })
            .catch(error => {
                document.getElementById('statusText').innerHTML = '<span class="status-badge error">Error</span>';
                document.getElementById('logContent').innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">⚠️</div>
                        <h3>Failed to load logs</h3>
                        <p>${error.message}</p>
                    </div>
                `;
            });
        }

        function renderLogs(data) {
            const container = document.getElementById('logContent');
            
            if (data.entries.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>No log entries found</h3>
                        <p>Try adjusting your filters or the log file might be empty.</p>
                    </div>
                `;
                return;
            }

            const filter = document.getElementById('searchFilter').value.toLowerCase();
            
            let html = '';
            data.entries.forEach(entry => {
                let message = escapeHtml(entry.message);
                let context = escapeHtml(entry.context);

                // Highlight search term
                if (filter) {
                    const regex = new RegExp(`(${escapeRegex(filter)})`, 'gi');
                    message = message.replace(regex, '<span class="highlight">$1</span>');
                    context = context.replace(regex, '<span class="highlight">$1</span>');
                }

                html += `
                    <div class="log-entry level-${entry.level}">
                        <div class="log-meta">
                            <span class="log-timestamp">⏰ ${entry.timestamp}</span>
                            <span class="log-level ${entry.level}">${entry.level}</span>
                            <span style="color: #666;">${entry.environment}</span>
                        </div>
                        <div class="log-message">${message}</div>
                        ${context.trim() ? `<div class="log-context">${context}</div>` : ''}
                    </div>
                `;
            });

            container.innerHTML = html;
            
            // Auto-scroll to top (newest entries)
            container.scrollTop = 0;
        }

        function refreshLogs() {
            loadLog();
        }

        function clearLog() {
            if (!confirm('Are you sure you want to clear this log file? This action cannot be undone.')) {
                return;
            }

            const logPath = document.getElementById('logSelect').value;

            fetch('/admin/logs/clear', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ path: logPath })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Log cleared successfully!');
                    loadLog();
                } else {
                    alert('Failed to clear log: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Failed to clear log: ' + error.message);
            });
        }

        function downloadLog() {
            const logPath = document.getElementById('logSelect').value;
            const url = `/admin/logs/download?path=${encodeURIComponent(logPath)}`;
            window.open(url, '_blank');
        }

        function debouncedSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadLog();
            }, 500);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function escapeRegex(text) {
            return text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        // Auto-refresh every 30 seconds (optional)
        // setInterval(refreshLogs, 30000);
    </script>
</body>
</html>
