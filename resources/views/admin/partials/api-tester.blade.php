<div class="api-tester">
    <!-- Left Panel: Request Form -->
    <div class="api-left">
        <div class="api-form">
            <h3 style="color: #4CAF50; margin-bottom: 20px;">
                <i class="fas fa-plug"></i> API Request
            </h3>

            <!-- URL -->
            <div class="form-group">
                <label for="apiUrl">URL</label>
                <input type="text" id="apiUrl" placeholder="https://api.example.com/endpoint" 
                       value="https://be.ptpn1.co.id/api/health">
            </div>

            <!-- Method -->
            <div class="form-group">
                <label for="apiMethod">Method</label>
                <select id="apiMethod">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PUT">PUT</option>
                    <option value="DELETE">DELETE</option>
                </select>
            </div>

            <!-- Headers -->
            <div class="form-group">
                <label>Headers</label>
                <div class="headers-list" id="headersList">
                    <div class="header-item">
                        <input type="text" placeholder="Header name" class="header-key" value="Content-Type">
                        <input type="text" placeholder="Header value" class="header-value" value="application/json">
                        <button class="btn-remove" onclick="removeHeader(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <button class="btn-add" onclick="addHeader()">
                    <i class="fas fa-plus"></i> Add Header
                </button>
            </div>

            <!-- Body -->
            <div class="form-group">
                <label for="apiBody">Body (JSON)</label>
                <textarea id="apiBody" rows="8" placeholder='{"key": "value"}'></textarea>
            </div>

            <!-- Timeout -->
            <div class="form-group">
                <label for="apiTimeout">Timeout (seconds)</label>
                <input type="number" id="apiTimeout" value="30" min="1" max="120">
            </div>

            <!-- Execute Button -->
            <button class="btn btn-execute" id="btnExecuteApi" onclick="executeApiTest()">
                <i class="fas fa-play"></i> Execute Request
            </button>
        </div>
    </div>

    <!-- Right Panel: Response -->
    <div class="api-right">
        <div class="response-container">
            <div class="response-header">
                <div class="response-title">
                    <i class="fas fa-terminal"></i> Response
                </div>
                <div class="response-meta" id="responseMeta">
                    <span id="responseStatus"></span>
                    <span id="responseTime"></span>
                </div>
            </div>
            <div class="response-body" id="apiResponse">
                <div style="text-align: center; color: #666; padding: 40px;">
                    <i class="fas fa-info-circle" style="font-size: 48px; margin-bottom: 15px;"></i>
                    <p>Execute a request to see the response here</p>
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

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #b0b0b0;
    font-size: 14px;
    font-weight: 500;
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

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #4CAF50;
}

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
    transition: all 0.2s;
}

.btn-remove:hover {
    background: #da190b;
}

.btn-add {
    background: #2196F3;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 5px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-add:hover {
    background: #0b7dda;
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
</style>
