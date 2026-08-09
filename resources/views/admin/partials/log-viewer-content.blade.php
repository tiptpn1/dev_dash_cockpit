<!-- Log Viewer Controls -->
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

    <div class="control-group" style="margin-left: auto;">
        <button class="btn btn-refresh" onclick="loadLog()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
        <button class="btn btn-download" onclick="downloadLog()">
            <i class="fas fa-download"></i> Download
        </button>
        <button class="btn btn-clear" onclick="clearLog()">
            <i class="fas fa-trash"></i> Clear
        </button>
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
    <div class="loading">
        <div class="spinner"></div>
        Loading logs...
    </div>
</div>

<style>
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

.search-box {
    flex-grow: 1;
    max-width: 300px;
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

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-state-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.highlight {
    background: #FFC107;
    color: #000;
    padding: 2px 4px;
    border-radius: 2px;
}
</style>
