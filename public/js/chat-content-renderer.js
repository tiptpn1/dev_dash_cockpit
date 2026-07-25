/**
 * Chat Content Renderer - Handles rich content display
 * Supports: Markdown, Charts, Maps, Files, Images, Videos
 */

class ChatContentRenderer {
    constructor() {
        this.chartCounter = 0;
        this.mapCounter = 0;
    }

    /**
     * Process and render message content
     * @param {string} content - Raw content from AI
     * @returns {string} - Processed HTML
     */
    async renderContent(content) {
        if (!content) return '';

        // Extract and process special content blocks
        content = await this.processCharts(content);
        content = await this.processMaps(content);
        content = await this.processFiles(content);
        
        // Process markdown
        content = this.processMarkdown(content);
        
        return content;
    }

    /**
     * Process Markdown to HTML
     */
    processMarkdown(content) {
        if (typeof marked === 'undefined') {
            // Fallback to basic formatting if marked.js not loaded
            return this.basicMarkdownFallback(content);
        }

        // Configure marked
        marked.setOptions({
            breaks: true,
            gfm: true,
            headerIds: false,
            mangle: false
        });

        try {
            return marked.parse(content);
        } catch (e) {
            console.error('Markdown parse error:', e);
            return this.basicMarkdownFallback(content);
        }
    }

    /**
     * Basic Markdown fallback (if marked.js fails)
     */
    basicMarkdownFallback(content) {
        return content
            // Headers
            .replace(/^### (.*$)/gm, '<h3>$1</h3>')
            .replace(/^## (.*$)/gm, '<h2>$1</h2>')
            .replace(/^# (.*$)/gm, '<h1>$1</h1>')
            // Bold
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            // Italic
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            // Code blocks
            .replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>')
            // Inline code
            .replace(/`([^`]+)`/g, '<code>$1</code>')
            // Line breaks
            .replace(/\n/g, '<br>');
    }

    /**
     * Process Chart data blocks
     * Format: ```chart:type\n{data}\n```
     */
    async processCharts(content) {
        const chartRegex = /```chart:(bar|line|pie|doughnut|radar)\n([\s\S]*?)```/g;
        let match;
        
        while ((match = chartRegex.exec(content)) !== null) {
            const chartType = match[1];
            const chartData = match[2];
            const chartId = `chart-${++this.chartCounter}`;
            
            try {
                const data = JSON.parse(chartData);
                const chartHTML = `
                    <div class="chart-container" id="${chartId}-container">
                        <canvas id="${chartId}" width="400" height="200"></canvas>
                    </div>
                    <script>
                        setTimeout(() => {
                            const ctx = document.getElementById('${chartId}');
                            if (ctx && typeof Chart !== 'undefined') {
                                new Chart(ctx, {
                                    type: '${chartType}',
                                    data: ${JSON.stringify(data)},
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                labels: { color: '#ffffff' }
                                            }
                                        },
                                        scales: ${chartType !== 'pie' && chartType !== 'doughnut' ? `{
                                            y: {
                                                ticks: { color: '#ffffff' },
                                                grid: { color: '#37474f' }
                                            },
                                            x: {
                                                ticks: { color: '#ffffff' },
                                                grid: { color: '#37474f' }
                                            }
                                        }` : '{}'}
                                    }
                                });
                            }
                        }, 100);
                    </script>
                `;
                
                content = content.replace(match[0], chartHTML);
            } catch (e) {
                console.error('Chart parse error:', e);
                content = content.replace(match[0], '<p class="error">⚠️ Invalid chart data</p>');
            }
        }
        
        return content;
    }

    /**
     * Process Map blocks
     * Format: ```map\n{lat, lng, zoom, markers}\n```
     */
    async processMaps(content) {
        const mapRegex = /```map\n([\s\S]*?)```/g;
        let match;
        
        while ((match = mapRegex.exec(content)) !== null) {
            const mapData = match[1];
            const mapId = `map-${++this.mapCounter}`;
            
            try {
                const data = JSON.parse(mapData);
                const { lat = 0, lng = 0, zoom = 13, markers = [] } = data;
                
                const mapHTML = `
                    <div class="map-container" id="${mapId}"></div>
                    <script>
                        setTimeout(() => {
                            if (typeof L !== 'undefined') {
                                const map = L.map('${mapId}').setView([${lat}, ${lng}], ${zoom});
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '© OpenStreetMap contributors'
                                }).addTo(map);
                                
                                ${markers.map(m => `
                                    L.marker([${m.lat}, ${m.lng}])
                                        .addTo(map)
                                        ${m.popup ? `.bindPopup('${m.popup}')` : ''};
                                `).join('\n')}
                            }
                        }, 100);
                    </script>
                `;
                
                content = content.replace(match[0], mapHTML);
            } catch (e) {
                console.error('Map parse error:', e);
                content = content.replace(match[0], '<p class="error">⚠️ Invalid map data</p>');
            }
        }
        
        return content;
    }

    /**
     * Process File attachments
     * Format: ```file\n{name, size, url, type}\n```
     */
    async processFiles(content) {
        const fileRegex = /```file\n([\s\S]*?)```/g;
        let match;
        
        while ((match = fileRegex.exec(content)) !== null) {
            const fileData = match[1];
            
            try {
                const data = JSON.parse(fileData);
                const { name, size, url, type = 'file' } = data;
                
                const icon = this.getFileIcon(type);
                const sizeFormatted = this.formatFileSize(size);
                
                const fileHTML = `
                    <a href="${url}" class="file-attachment" download="${name}" target="_blank">
                        ${icon}
                        <div class="file-info">
                            <span class="file-name">${name}</span>
                            <span class="file-size">${sizeFormatted}</span>
                        </div>
                    </a>
                `;
                
                content = content.replace(match[0], fileHTML);
            } catch (e) {
                console.error('File parse error:', e);
                content = content.replace(match[0], '<p class="error">⚠️ Invalid file data</p>');
            }
        }
        
        return content;
    }

    /**
     * Get file icon SVG based on type
     */
    getFileIcon(type) {
        const icons = {
            pdf: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.5,17C14.5,17 13.5,16.5 13.5,15C13.5,13.5 14.5,13 15.5,13C16.5,13 17.5,13.5 17.5,15C17.5,16.5 16.5,17 15.5,17M10,11.5V17H8.5V15.2H6.5V17H5V11.5H6.5V13.7H8.5V11.5H10M19,17H17.5V15.5H16.5V17H15V11.5H17C18,11.5 19,12 19,13.5V15C19,16 18.5,16.5 17.5,16.5H17V17H19V17Z" /></svg>',
            image: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z" /></svg>',
            video: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z" /></svg>',
            excel: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.8,20H14L12,16.6L10,20H8.2L11.1,15.5L8.2,11H10L12,14.4L14,11H15.8L12.9,15.5L15.8,20Z" /></svg>',
            word: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.2,20H13.8L12,13.2L10.2,20H8.8L6.6,11H8.1L9.5,17.8L11.3,11H12.6L14.4,17.8L15.8,11H17.3L15.2,20Z" /></svg>',
            file: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" /></svg>'
        };
        
        return icons[type] || icons.file;
    }

    /**
     * Format file size
     */
    formatFileSize(bytes) {
        if (!bytes) return 'Unknown size';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    /**
     * Extract plain text for text-to-speech (removes formatting/special content)
     */
    extractSpeakableText(content) {
        let text = content;
        
        // Remove code blocks
        text = text.replace(/```[\s\S]*?```/g, ' kode program ');
        
        // Remove inline code
        text = text.replace(/`[^`]+`/g, ' kode ');
        
        // Remove special blocks (charts, maps, files)
        text = text.replace(/```(chart|map|file)[\s\S]*?```/g, '');
        
        // Remove URLs
        text = text.replace(/https?:\/\/[^\s]+/g, ' link ');
        
        // Remove markdown syntax
        text = text.replace(/[#*_~`\[\]]/g, '');
        
        // Remove HTML tags
        text = text.replace(/<[^>]*>/g, '');
        
        // Remove extra whitespace
        text = text.replace(/\s+/g, ' ').trim();
        
        // Remove special characters that shouldn't be spoken
        text = text.replace(/[|{}]/g, '');
        
        return text;
    }
}

// Export for use in chat-icon.blade.php
if (typeof window !== 'undefined') {
    window.ChatContentRenderer = ChatContentRenderer;
}
