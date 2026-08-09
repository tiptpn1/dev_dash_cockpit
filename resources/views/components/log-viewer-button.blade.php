{{-- Discrete Log Viewer Button - Add this to your main layout --}}

@if(app()->environment('local') || (auth()->check() && auth()->user()->role === 'superadmin'))
<style>
    .log-viewer-trigger {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 36px;
        height: 36px;
        background: rgba(26, 31, 58, 0.7);
        border: 1px solid rgba(42, 53, 85, 0.5);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 999;
        opacity: 0.4;
        backdrop-filter: blur(10px);
    }

    .log-viewer-trigger:hover {
        opacity: 1;
        background: rgba(26, 31, 58, 0.95);
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .log-viewer-trigger svg {
        width: 18px;
        height: 18px;
        fill: #90caf9;
    }

    .log-viewer-trigger:hover svg {
        fill: #64b5f6;
    }

    .log-viewer-tooltip {
        position: absolute;
        right: 45px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(26, 31, 58, 0.95);
        color: #e0e0e0;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        border: 1px solid rgba(42, 53, 85, 0.5);
    }

    .log-viewer-trigger:hover .log-viewer-tooltip {
        opacity: 1;
    }

    /* Badge untuk error count (optional) */
    .log-error-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #f44336;
        color: white;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        font-size: 10px;
        display: none;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border: 2px solid #0a0e27;
    }

    .log-error-badge.has-errors {
        display: flex;
    }
</style>

<div class="log-viewer-trigger" onclick="openLogViewer()" title="View Logs">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6zm2-8h8v2H8v-2zm0 4h8v2H8v-2z"/>
    </svg>
    <span class="log-viewer-tooltip">View Logs (Dev)</span>
    <span class="log-error-badge" id="logErrorBadge">!</span>
</div>

<script>
function openLogViewer() {
    // Open in new window/tab
    const width = Math.min(1400, window.screen.width * 0.9);
    const height = Math.min(900, window.screen.height * 0.9);
    const left = (window.screen.width - width) / 2;
    const top = (window.screen.height - height) / 2;
    
    window.open(
        '{{ route("admin.logs.index") }}',
        'LogViewer',
        `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`
    );
}

// Optional: Check for recent errors and show badge
async function checkRecentErrors() {
    try {
        const response = await fetch('/admin/logs/get', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                path: '{{ storage_path("logs/laravel.log") }}',
                lines: 50,
                level: 'ERROR'
            })
        });
        
        const data = await response.json();
        
        if (data.success && data.total > 0) {
            // Show error badge
            const badge = document.getElementById('logErrorBadge');
            if (badge) {
                badge.classList.add('has-errors');
                badge.textContent = Math.min(data.total, 9);
                if (data.total > 9) badge.textContent = '9+';
            }
        }
    } catch (error) {
        console.log('Could not check log errors:', error);
    }
}

// Check on page load (only if logged in and in development)
@if(app()->environment('local'))
    setTimeout(checkRecentErrors, 2000);
@endif
</script>
@endif
