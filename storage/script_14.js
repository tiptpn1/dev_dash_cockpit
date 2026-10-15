
function openLogViewer() {
    // Open in new window/tab
    const width = Math.min(1400, window.screen.width * 0.9);
    const height = Math.min(900, window.screen.height * 0.9);
    const left = (window.screen.width - width) / 2;
    const top = (window.screen.height - height) / 2;
    
    window.open(
        'http://localhost/admin/logs',
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
                path: "D:\\laragon\\www\\dev_dash_cockpit\\storage\\logs\/laravel.log",
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
    setTimeout(checkRecentErrors, 2000);
