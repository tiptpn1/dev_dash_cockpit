/**
 * Log Viewer & Debug Tools - JavaScript
 * Handles all interactions for logs, API tester, chatbot tester, and system info
 */

let searchTimeout = null;

// ============================================================================
// LOG VIEWER FUNCTIONS
// ============================================================================

/**
 * Load log on page load
 */
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('logContent')) {
        loadLog();
    }
});

/**
 * Load and display logs
 */
function loadLog() {
    const logPath = document.getElementById('logSelect').value;
    const lines = document.getElementById('linesCount').value;
    const level = document.getElementById('levelFilter').value;
    const filter = document.getElementById('searchFilter').value;

    document.getElementById('statusText').innerHTML = '<span class="status-badge loading">Loading...</span>';
    document.getElementById('logContent').innerHTML = '<div class="loading"><div class="spinner"></div>Loading logs...</div>';

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

/**
 * Render log entries
 */
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
                    <span class="log-timestamp"><i class="far fa-clock"></i> ${entry.timestamp}</span>
                    <span class="log-level ${entry.level}">${entry.level}</span>
                    <span style="color: #666;">${entry.environment}</span>
                </div>
                <div class="log-message">${message}</div>
                ${context.trim() ? `<div class="log-context">${context}</div>` : ''}
            </div>
        `;
    });

    container.innerHTML = html;
    container.scrollTop = 0;
}

/**
 * Clear log file
 */
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

/**
 * Download log file
 */
function downloadLog() {
    const logPath = document.getElementById('logSelect').value;
    const url = `/admin/logs/download?path=${encodeURIComponent(logPath)}`;
    window.open(url, '_blank');
}

/**
 * Debounced search
 */
function debouncedSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        loadLog();
    }, 500);
}

// ============================================================================
// API TESTER FUNCTIONS
// ============================================================================

/**
 * Add header field
 */
function addHeader() {
    const headersList = document.getElementById('headersList');
    const headerItem = document.createElement('div');
    headerItem.className = 'header-item';
    headerItem.innerHTML = `
        <input type="text" placeholder="Header name" class="header-key">
        <input type="text" placeholder="Header value" class="header-value">
        <button class="btn-remove" onclick="removeHeader(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    headersList.appendChild(headerItem);
}

/**
 * Remove header field
 */
function removeHeader(button) {
    button.parentElement.remove();
}

/**
 * Execute API test
 */
function executeApiTest() {
    const url = document.getElementById('apiUrl').value.trim();
    const method = document.getElementById('apiMethod').value;
    const body = document.getElementById('apiBody').value.trim();
    const timeout = parseInt(document.getElementById('apiTimeout').value);
    
    // Get headers
    const headers = {};
    document.querySelectorAll('#headersList .header-item').forEach(item => {
        const key = item.querySelector('.header-key').value.trim();
        const value = item.querySelector('.header-value').value.trim();
        if (key && value) {
            headers[key] = value;
        }
    });

    // Validation
    if (!url) {
        alert('Please enter a URL');
        return;
    }

    // Disable button
    const btn = document.getElementById('btnExecuteApi');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Executing...';

    // Show loading
    document.getElementById('apiResponse').innerHTML = `
        <div class="loading">
            <div class="spinner"></div>
            Executing request...
        </div>
    `;
    document.getElementById('responseStatus').innerHTML = '';
    document.getElementById('responseTime').innerHTML = '';

    const startTime = Date.now();

    // Execute
    fetch('/admin/logs/test-api', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            url: url,
            method: method,
            headers: headers,
            body: body,
            timeout: timeout
        })
    })
    .then(response => response.json())
    .then(data => {
        const duration = Date.now() - startTime;
        displayApiResponse(data, duration);
    })
    .catch(error => {
        document.getElementById('apiResponse').innerHTML = `
            <div style="color: #f44336;">
                <strong>Error:</strong><br>
                ${escapeHtml(error.message)}
            </div>
        `;
        document.getElementById('responseStatus').innerHTML = '<span class="status-badge error">Error</span>';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-play"></i> Execute Request';
    });
}

/**
 * Display API response
 */
function displayApiResponse(data, duration) {
    // Status
    const statusClass = data.success ? 'success' : 'error';
    const statusText = data.status_code ? `${data.status_code}` : 'Error';
    document.getElementById('responseStatus').innerHTML = `<span class="status-badge ${statusClass}">${statusText}</span>`;
    document.getElementById('responseTime').innerHTML = `<i class="fas fa-clock"></i> ${data.execution_time || duration + ' ms'}`;

    // Response body
    let output = '';
    
    if (data.error) {
        output += `<div style="color: #f44336; margin-bottom: 15px;">
            <strong>Error:</strong> ${escapeHtml(data.error)}
        </div>`;
    }

    if (data.response_headers) {
        output += `<div style="margin-bottom: 15px;">
            <strong style="color: #4CAF50;">Response Headers:</strong>
            <pre style="margin-top: 5px; color: #888;">${escapeHtml(data.response_headers)}</pre>
        </div>`;
    }

    if (data.response_body) {
        output += `<div>
            <strong style="color: #4CAF50;">Response Body:</strong>
            <pre style="margin-top: 5px;">${formatJson(data.response_body)}</pre>
        </div>`;
    }

    if (data.curl_info) {
        output += `<div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #2a3555;">
            <strong style="color: #888;">Debug Info:</strong>
            <pre style="margin-top: 5px; color: #666; font-size: 12px;">${JSON.stringify(data.curl_info, null, 2)}</pre>
        </div>`;
    }

    document.getElementById('apiResponse').innerHTML = output || '<div style="color: #666;">No response data</div>';
}

// ============================================================================
// CHATBOT TESTER FUNCTIONS
// ============================================================================

/**
 * Set test message
 */
function setTestMessage(message) {
    document.getElementById('chatbotMessage').value = message;
}

/**
 * Execute chatbot test
 */
async function executeChatbotTest() {
    const message = document.getElementById('chatbotMessage').value.trim();
    const stream = document.getElementById('chatbotStream').value === 'true';

    if (!message) {
        alert('Please enter a message');
        return;
    }

    // Disable button
    const btn = document.getElementById('btnExecuteChatbot');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';

    // Show loading
    document.getElementById('chatbotResponse').innerHTML = `
        <div class="loading">
            <div class="spinner"></div>
            Testing chatbot connection...<br>
            <span style="font-size: 12px; color: #666; margin-top: 10px; display: block;">
                ${stream ? '🔄 Streaming mode - watching for events...' : '⏳ Non-streaming mode - waiting for response...'}
            </span>
        </div>
    `;
    document.getElementById('chatbotStatus').innerHTML = '';
    document.getElementById('chatbotTime').innerHTML = '';

    const startTime = Date.now();

    try {
        // If streaming, use EventSource
        if (stream) {
            await executeChatbotTestStreaming(message, startTime);
        } else {
            // Non-streaming (original fetch)
            await executeChatbotTestNonStreaming(message, startTime);
        }
    } catch (error) {
        document.getElementById('chatbotResponse').innerHTML = `
            <div style="color: #f44336;">
                <strong>Error:</strong><br>
                ${escapeHtml(error.message)}
            </div>
        `;
        document.getElementById('chatbotStatus').innerHTML = '<span class="status-badge error">Error</span>';
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Test Chatbot';
    }
}

/**
 * Execute chatbot test with streaming
 */
async function executeChatbotTestStreaming(message, startTime) {
    const responseContainer = document.getElementById('chatbotResponse');
    let events = [];
    let streamEnded = false;
    let statusCode = 'pending';
    
    // Create display elements
    responseContainer.innerHTML = `
        <div style="margin-bottom: 15px; padding: 10px; background: rgba(33, 150, 243, 0.1); border: 1px solid #2196F3; border-radius: 4px;">
            <strong style="color: #2196F3;"><i class="fas fa-stream"></i> Streaming Mode</strong>
            <div style="margin-top: 5px; color: #888; font-size: 13px;" id="streamStatus">
                Connecting to chatbot...
            </div>
        </div>
        
        <div style="margin-bottom: 15px;">
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <button class="btn" style="background: #2196F3; color: white; padding: 6px 12px; font-size: 13px;" onclick="document.getElementById('rawView').style.display='none'; document.getElementById('parsedView').style.display='block'; this.style.opacity='0.5'; this.nextElementSibling.style.opacity='1';">
                    <i class="fas fa-list"></i> Parsed View
                </button>
                <button class="btn" style="background: #4CAF50; color: white; padding: 6px 12px; font-size: 13px;" onclick="document.getElementById('parsedView').style.display='none'; document.getElementById('rawView').style.display='block'; this.style.opacity='1'; this.previousElementSibling.style.opacity='0.5';">
                    <i class="fas fa-code"></i> Raw View
                </button>
            </div>
        </div>
        
        <!-- Parsed View -->
        <div id="parsedView" style="display: block;">
            <div id="streamEvents" style="margin-bottom: 15px;">
                <strong style="color: #4CAF50;">Received Events:</strong>
                <div id="eventsList" style="margin-top: 10px;"></div>
            </div>
            <div id="streamResponse" style="margin-top: 15px;">
                <strong style="color: #888;">Accumulated Response:</strong>
                <div id="accumulatedText" style="margin-top: 10px; padding: 15px; background: #141829; border-radius: 4px; min-height: 100px; font-family: 'Courier New', monospace; white-space: pre-wrap;"></div>
            </div>
        </div>
        
        <!-- Raw View -->
        <div id="rawView" style="display: none;">
            <strong style="color: #FFC107;"><i class="fas fa-terminal"></i> Raw Stream Data:</strong>
            <div id="rawStreamData" style="margin-top: 10px; padding: 15px; background: #0a0e27; border: 1px solid #2a3555; border-radius: 4px; font-family: 'Courier New', monospace; font-size: 12px; white-space: pre-wrap; max-height: 500px; overflow-y: auto; color: #00ff00;"></div>
        </div>
    `;
    
    const streamStatus = document.getElementById('streamStatus');
    const eventsList = document.getElementById('eventsList');
    const accumulatedText = document.getElementById('accumulatedText');
    const rawStreamData = document.getElementById('rawStreamData');
    
    let fullText = '';
    let eventCount = 0;
    let rawData = ''; // Store raw stream data

    // Use fetch with ReadableStream instead of EventSource (more control)
    const response = await fetch('/admin/logs/test-chatbot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'text/event-stream'
        },
        body: JSON.stringify({
            message: message,
            stream: true
        })
    });

    statusCode = response.status;
    
    // Update status
    const statusClass = response.ok ? 'success' : 'error';
    document.getElementById('chatbotStatus').innerHTML = `<span class="status-badge ${statusClass}">${statusCode}</span>`;
    
    if (!response.ok) {
        throw new Error(`HTTP ${statusCode}: ${response.statusText}`);
    }

    streamStatus.innerHTML = '<i class="fas fa-check-circle" style="color: #4CAF50;"></i> Connected - receiving events...';

    // Read stream
    const reader = response.body.getReader();
    const decoder = new TextDecoder();
    let buffer = '';

    try {
        while (true) {
            const { done, value } = await reader.read();
            
            if (done) {
                streamStatus.innerHTML = '<i class="fas fa-check-circle" style="color: #4CAF50;"></i> Stream completed';
                streamEnded = true;
                break;
            }
            
            buffer += decoder.decode(value, { stream: true });
            
            // Append to raw view (with timestamp)
            const chunk = decoder.decode(value, { stream: false });
            rawData += chunk;
            rawStreamData.textContent = rawData;
            rawStreamData.scrollTop = rawStreamData.scrollHeight;
            
            const lines = buffer.split('\n');
            buffer = lines.pop() || '';
            
            for (const line of lines) {
                const trimmed = line.trim();
                
                // Skip empty lines
                if (!trimmed) {
                    continue;
                }
                
                // Handle event type
                if (trimmed.startsWith('event:')) {
                    const eventType = trimmed.substring(6).trim();
                    // Store for next data line
                    continue;
                }
                
                // Handle data
                if (trimmed.startsWith('data:')) {
                    const jsonStr = trimmed.substring(5).trim();
                    if (!jsonStr || jsonStr === '[DONE]') continue;
                    
                    try {
                        const data = JSON.parse(jsonStr);
                        eventCount++;
                        
                        // Determine event type from various sources
                        let eventType = data.type || data.event || 'unknown';
                        let content = '';
                        
                        // Handle different response formats
                        if (typeof data === 'string') {
                            // Plain text response
                            eventType = 'text';
                            content = data;
                            fullText += data;
                        } else if (data.response) {
                            // Wrapped response format
                            if (data.response.success && data.response.sessionId) {
                                // Done event with response object
                                eventType = 'done';
                                const finalResponse = data.response.message?.content || data.response.content || '';
                                if (finalResponse) {
                                    fullText = finalResponse;
                                    content = `Response received (${finalResponse.length} chars)`;
                                } else {
                                    content = 'Stream completed';
                                }
                            } else {
                                content = JSON.stringify(data.response).substring(0, 100);
                            }
                        } else if (data.token) {
                            // Token event
                            eventType = 'token';
                            content = data.token;
                            fullText += data.token;
                        } else if (data.message && !data.type) {
                            // Thinking messages without type field
                            // These are usually status updates
                            eventType = 'thinking';
                            content = data.message;
                        } else if (data.skill) {
                            // Skill called
                            eventType = data.type || 'skill_called';
                            content = `Calling ${data.skill}`;
                        } else {
                            // Unknown format - try to extract any text
                            content = data.message || data.text || data.content || JSON.stringify(data).substring(0, 50);
                        }
                        
                        // Add event to list
                        const eventDiv = document.createElement('div');
                        eventDiv.style.cssText = 'margin-bottom: 8px; padding: 8px; background: #1a1f3a; border-left: 3px solid #2196F3; border-radius: 4px;';
                        
                        // Color based on event type
                        let badgeColor = '#2196F3';
                        if (eventType === 'done') badgeColor = '#4CAF50';
                        else if (eventType === 'error') badgeColor = '#f44336';
                        else if (eventType === 'thinking') badgeColor = '#FFC107';
                        else if (eventType === 'token') badgeColor = '#9C27B0';
                        
                        const eventBadge = `<span style="background: ${badgeColor}; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px; font-weight: 600;">${eventType}</span>`;
                        
                        eventDiv.innerHTML = `
                            ${eventBadge}
                            <span style="color: #888; font-size: 12px; margin-left: 8px;">${escapeHtml(content)}</span>
                        `;
                        
                        eventsList.appendChild(eventDiv);
                        
                        // Update accumulated text
                        accumulatedText.textContent = fullText || '(waiting for content...)';
                        
                        // Scroll to bottom
                        eventsList.scrollTop = eventsList.scrollHeight;
                        
                        events.push({ type: eventType, data: data });
                    } catch (e) {
                        console.error('Parse error:', e, trimmed);
                        // Show parse error as event
                        const errorDiv = document.createElement('div');
                        errorDiv.style.cssText = 'margin-bottom: 8px; padding: 8px; background: rgba(244, 67, 54, 0.1); border-left: 3px solid #f44336; border-radius: 4px;';
                        errorDiv.innerHTML = `
                            <span style="background: #f44336; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px; font-weight: 600;">parse-error</span>
                            <span style="color: #f44336; font-size: 11px; margin-left: 8px;">${escapeHtml(e.message)}</span>
                        `;
                        eventsList.appendChild(errorDiv);
                    }
                }
            }
        }
    } catch (error) {
        streamStatus.innerHTML = `<i class="fas fa-exclamation-circle" style="color: #f44336;"></i> Stream error: ${error.message}`;
        throw error;
    }

    // Update time
    const duration = Date.now() - startTime;
    document.getElementById('chatbotTime').innerHTML = `<i class="fas fa-clock"></i> ${duration} ms`;
    
    // Add summary
    responseContainer.innerHTML += `
        <div style="margin-top: 20px; padding: 15px; background: #141829; border: 1px solid #2a3555; border-radius: 6px;">
            <strong style="color: #4CAF50;"><i class="fas fa-chart-bar"></i> Stream Summary</strong>
            <div style="margin-top: 10px; color: #888; font-size: 13px; line-height: 1.8;">
                <div>Total events: <strong style="color: #e0e0e0;">${eventCount}</strong></div>
                <div>Status: <strong style="color: ${streamEnded ? '#4CAF50' : '#FFC107'};">${streamEnded ? 'Completed' : 'Incomplete'}</strong></div>
                <div>Total text: <strong style="color: #e0e0e0;">${fullText.length} characters</strong></div>
                <div>Duration: <strong style="color: #e0e0e0;">${duration} ms</strong></div>
            </div>
        </div>
    `;
}

/**
 * Execute chatbot test without streaming (original)
 */
async function executeChatbotTestNonStreaming(message, startTime) {
    const response = await fetch('/admin/logs/test-chatbot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            message: message,
            stream: false
        })
    });
    
    const data = await response.json();
    const duration = Date.now() - startTime;
    displayChatbotResponse(data, duration);
}

/**
 * Display chatbot response
 */
function displayChatbotResponse(data, duration) {
    // Status
    const statusClass = data.success ? 'success' : 'error';
    const statusText = data.status_code ? `${data.status_code}` : 'Error';
    document.getElementById('chatbotStatus').innerHTML = `<span class="status-badge ${statusClass}">${statusText}</span>`;
    document.getElementById('chatbotTime').innerHTML = `<i class="fas fa-clock"></i> ${data.execution_time || duration + ' ms'}`;

    // Response
    let output = '';
    
    // Success/Error indicator
    if (data.success) {
        const streamBadge = data.stream_mode ? ' <span style="background: #2196F3; padding: 2px 6px; border-radius: 3px; font-size: 11px;">STREAM</span>' : '';
        output += `<div style="color: #4CAF50; margin-bottom: 15px; padding: 10px; background: rgba(76, 175, 80, 0.1); border-radius: 4px;">
            <i class="fas fa-check-circle"></i> <strong>Success!</strong> Chatbot responded successfully.${streamBadge}
        </div>`;
    } else {
        output += `<div style="color: #f44336; margin-bottom: 15px; padding: 10px; background: rgba(244, 67, 54, 0.1); border-radius: 4px;">
            <i class="fas fa-times-circle"></i> <strong>Failed!</strong> ${data.error ? escapeHtml(data.error) : 'Unknown error'}
        </div>`;
    }

    // Streaming mode info
    if (data.stream_mode && data.events_count) {
        output += `<div style="margin-bottom: 15px; padding: 10px; background: rgba(33, 150, 243, 0.1); border: 1px solid #2196F3; border-radius: 4px;">
            <strong style="color: #2196F3;"><i class="fas fa-stream"></i> Streaming Mode</strong>
            <div style="margin-top: 5px; color: #888; font-size: 13px;">
                Received ${data.events_count} SSE event(s)
            </div>
        </div>`;
    }

    // Request details
    if (data.request) {
        output += `<div style="margin-bottom: 15px;">
            <strong style="color: #2196F3;">Request Details:</strong>
            <pre style="margin-top: 5px; color: #888; font-size: 12px;">${JSON.stringify(data.request, null, 2)}</pre>
        </div>`;
    }

    // Response headers
    if (data.response_headers) {
        output += `<div style="margin-bottom: 15px;">
            <strong style="color: #4CAF50;">Response Headers:</strong>
            <pre style="margin-top: 5px; color: #888; font-size: 12px; max-height: 150px; overflow-y: auto;">${escapeHtml(data.response_headers)}</pre>
        </div>`;
    }

    // Parsed events (for streaming)
    if (data.parsed_events && data.parsed_events.length > 0) {
        output += `<div style="margin-bottom: 15px;">
            <strong style="color: #4CAF50;">Parsed SSE Events:</strong>
            <div style="margin-top: 10px;">`;
        
        data.parsed_events.forEach((event, index) => {
            try {
                const parsed = JSON.parse(event);
                output += `<div style="margin-bottom: 10px; padding: 10px; background: #141829; border-left: 3px solid #2196F3; border-radius: 4px;">
                    <div style="color: #888; font-size: 11px; margin-bottom: 5px;">Event ${index + 1}</div>
                    <pre style="color: #e0e0e0; font-size: 12px;">${JSON.stringify(parsed, null, 2)}</pre>
                </div>`;
            } catch (e) {
                output += `<div style="margin-bottom: 10px; padding: 10px; background: #141829; border-left: 3px solid #666; border-radius: 4px;">
                    <div style="color: #888; font-size: 11px; margin-bottom: 5px;">Event ${index + 1} (Raw)</div>
                    <pre style="color: #888; font-size: 12px;">${escapeHtml(event)}</pre>
                </div>`;
            }
        });
        
        output += `</div></div>`;
    }

    // Response body (for non-streaming or full raw response)
    if (data.response_body && !data.parsed_events) {
        output += `<div style="margin-bottom: 15px;">
            <strong style="color: #4CAF50;">Response Body:</strong>
            <pre style="margin-top: 5px;">${formatJson(data.response_body)}</pre>
        </div>`;
    }

    // Raw response (collapsed by default for streaming)
    if (data.stream_mode && data.response_body) {
        output += `<div style="margin-bottom: 15px;">
            <details style="cursor: pointer;">
                <summary style="color: #888; font-size: 13px; padding: 5px 0;"><strong>Raw Response Body</strong> (click to expand)</summary>
                <pre style="margin-top: 5px; padding: 10px; background: #0a0e27; border-radius: 4px; font-size: 11px; color: #666; max-height: 300px; overflow-y: auto;">${escapeHtml(data.response_body)}</pre>
            </details>
        </div>`;
    }

    // Troubleshooting tips
    if (!data.success) {
        output += `<div style="margin-top: 20px; padding: 15px; background: #141829; border: 1px solid #2a3555; border-radius: 6px;">
            <strong style="color: #FFC107;"><i class="fas fa-lightbulb"></i> Troubleshooting Tips:</strong>
            <ul style="margin-top: 10px; padding-left: 20px; color: #888; font-size: 13px; line-height: 1.8;">
                <li>Check AI Backend URL in .env file</li>
                <li>Verify credentials (AI_BACKEND_USERNAME, AI_BACKEND_PASSWORD)</li>
                <li>Check network connection to AI Backend</li>
                <li>View logs tab for detailed error messages</li>
                <li>Clear cache: <code>php artisan cache:clear</code></li>
            </ul>
        </div>`;
    }

    document.getElementById('chatbotResponse').innerHTML = output;
}

// ============================================================================
// UTILITY FUNCTIONS
// ============================================================================

/**
 * Escape HTML
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Escape regex
 */
function escapeRegex(text) {
    return text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

/**
 * Format JSON for display
 */
function formatJson(text) {
    try {
        const parsed = JSON.parse(text);
        return escapeHtml(JSON.stringify(parsed, null, 2));
    } catch (e) {
        return escapeHtml(text);
    }
}
