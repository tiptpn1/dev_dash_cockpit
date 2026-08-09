<div class="system-info">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="color: #4CAF50; margin: 0;">
            <i class="fas fa-server"></i> System Information
        </h3>
        <button class="btn" style="background: #2196F3; color: white;" onclick="loadSystemInfo()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    <div id="system-info-container" data-loaded="false">
        <div class="loading">
            <div class="spinner"></div>
            Click tab to load system information...
        </div>
    </div>
</div>

<style>
.system-info {
    padding: 20px;
    overflow-y: auto;
    height: 100%;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.info-card {
    background: #141829;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #2a3555;
    transition: all 0.2s;
}

.info-card:hover {
    border-color: #4CAF50;
    transform: translateY(-2px);
}

.info-card-title {
    font-weight: 600;
    color: #4CAF50;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
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
    font-size: 13px;
    text-align: right;
    max-width: 60%;
    word-break: break-word;
}

.info-value.success {
    color: #4CAF50;
}

.info-value.warning {
    color: #FFC107;
}

.info-value.error {
    color: #f44336;
}
</style>
