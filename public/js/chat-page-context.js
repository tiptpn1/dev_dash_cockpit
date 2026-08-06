/**
 * Chat Page Context Manager
 * Mengumpulkan dan mengelola context halaman untuk chatbot
 * 
 * @author AGRINAV Team
 * @version 1.0.0
 */

class ChatPageContext {
    constructor() {
        this.context = {
            page: {},
            data: {},
            filters: {},
            user: {},
            meta: {}
        };
        
        this.observers = [];
        this.updateCallbacks = [];
        
        this.init();
    }

    /**
     * Inisialisasi context manager
     */
    init() {
        // Collect initial context
        this.collectPageInfo();
        this.collectUserInfo();
        this.setupObservers();
        
        console.log('📋 Chat Page Context initialized', this.context);
    }

    /**
     * Collect informasi halaman dasar
     */
    collectPageInfo() {
        this.context.page = {
            url: window.location.href,
            pathname: window.location.pathname,
            title: document.title,
            module: this.detectModule(),
            timestamp: new Date().toISOString()
        };

        // Custom page metadata dari data attribute
        const pageData = document.querySelector('[data-page-context]');
        if (pageData) {
            try {
                this.context.meta = JSON.parse(pageData.getAttribute('data-page-context'));
            } catch (e) {
                console.warn('Failed to parse page context:', e);
            }
        }
    }

    /**
     * Detect module/section dari URL atau DOM
     */
    detectModule() {
        const path = window.location.pathname;
        
        // Parse dari URL pattern
        if (path.includes('/dashboard')) return 'Dashboard';
        if (path.includes('/bigquery')) return 'BigQuery Analytics';
        if (path.includes('/skyview')) return 'SkyView';
        if (path.includes('/management')) return 'User Management';
        if (path.includes('/aigr1')) return 'AIGR1 Analytics';
        
        // Fallback ke page title
        return document.querySelector('h1')?.textContent || 'Unknown';
    }

    /**
     * Collect informasi user dari meta tag atau global var
     */
    collectUserInfo() {
        // Dari Laravel auth (jika ada global var)
        if (window.authUser) {
            this.context.user = {
                id: window.authUser.id,
                name: window.authUser.name,
                email: window.authUser.email,
                role: window.authUser.role
            };
        } else {
            // Parse dari DOM
            const userName = document.querySelector('[data-user-name]')?.textContent;
            const userEmail = document.querySelector('[data-user-email]')?.textContent;
            
            if (userName) {
                this.context.user = { name: userName, email: userEmail };
            }
        }
    }

    /**
     * Collect data dari tabel (DataTables, tables biasa)
     */
    collectTableData(selector = 'table') {
        const tables = document.querySelectorAll(selector);
        const tableData = [];

        tables.forEach((table, index) => {
            const headers = Array.from(table.querySelectorAll('thead th'))
                .map(th => th.textContent.trim());
            
            const rows = Array.from(table.querySelectorAll('tbody tr'))
                .slice(0, 20) // Limit 20 rows untuk performa
                .map(tr => {
                    const cells = Array.from(tr.querySelectorAll('td'))
                        .map(td => td.textContent.trim());
                    
                    // Mapping ke object
                    const rowData = {};
                    headers.forEach((header, i) => {
                        rowData[header] = cells[i] || '';
                    });
                    return rowData;
                });

            if (rows.length > 0) {
                tableData.push({
                    tableIndex: index,
                    tableId: table.id || `table-${index}`,
                    headers: headers,
                    rowCount: table.querySelectorAll('tbody tr').length,
                    visibleRows: rows,
                    summary: `Tabel ${headers.join(', ')} dengan ${rows.length} baris data`
                });
            }
        });

        this.context.data.tables = tableData;
        return tableData;
    }

    /**
     * Collect data dari Chart.js instances
     */
    collectChartData() {
        const charts = [];
        
        // Jika menggunakan Chart.js global
        if (window.Chart && window.Chart.instances) {
            Object.values(window.Chart.instances).forEach((chart, index) => {
                if (chart && chart.data) {
                    charts.push({
                        chartId: chart.canvas.id || `chart-${index}`,
                        type: chart.config.type,
                        labels: chart.data.labels,
                        datasets: chart.data.datasets.map(ds => ({
                            label: ds.label,
                            data: ds.data,
                            summary: `${ds.label}: ${ds.data.join(', ')}`
                        })),
                        summary: `Chart ${chart.config.type} dengan ${chart.data.labels?.length || 0} data points`
                    });
                }
            });
        }

        // Fallback: parse dari canvas elements
        if (charts.length === 0) {
            document.querySelectorAll('canvas[id*="chart"], canvas[class*="chart"]').forEach((canvas, index) => {
                charts.push({
                    chartId: canvas.id || `chart-${index}`,
                    type: 'detected',
                    summary: `Chart terdeteksi di canvas ${canvas.id || index}`
                });
            });
        }

        this.context.data.charts = charts;
        return charts;
    }

    /**
     * Collect filter states (form inputs, dropdowns, date pickers)
     */
    collectFilterStates(containerSelector = 'body') {
        const container = document.querySelector(containerSelector);
        const filters = {};

        // Input text
        container.querySelectorAll('input[type="text"], input[type="search"]').forEach(input => {
            if (input.value && input.id) {
                filters[input.id] = {
                    type: 'text',
                    value: input.value,
                    label: this.getInputLabel(input)
                };
            }
        });

        // Select dropdowns
        container.querySelectorAll('select').forEach(select => {
            if (select.value && select.id) {
                const selectedOption = select.options[select.selectedIndex];
                filters[select.id] = {
                    type: 'select',
                    value: select.value,
                    text: selectedOption?.textContent,
                    label: this.getInputLabel(select)
                };
            }
        });

        // Date inputs
        container.querySelectorAll('input[type="date"]').forEach(input => {
            if (input.value && input.id) {
                filters[input.id] = {
                    type: 'date',
                    value: input.value,
                    label: this.getInputLabel(input)
                };
            }
        });

        // Checkboxes
        container.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
            if (input.id) {
                filters[input.id] = {
                    type: 'checkbox',
                    checked: true,
                    label: this.getInputLabel(input)
                };
            }
        });

        this.context.filters = filters;
        return filters;
    }

    /**
     * Helper: get label untuk input element
     */
    getInputLabel(input) {
        // Cari label tag
        const label = document.querySelector(`label[for="${input.id}"]`);
        if (label) return label.textContent.trim();

        // Fallback ke placeholder atau name
        return input.placeholder || input.name || input.id;
    }

    /**
     * Collect statistics/metrics dari halaman
     */
    collectStatistics(selector = '[data-stat], .stat-card, .metric') {
        const stats = [];
        
        document.querySelectorAll(selector).forEach((el, index) => {
            const label = el.getAttribute('data-stat-label') || 
                         el.querySelector('.stat-label, .metric-label')?.textContent ||
                         'Stat ' + index;
            
            const value = el.getAttribute('data-stat-value') ||
                         el.querySelector('.stat-value, .metric-value')?.textContent ||
                         el.textContent.trim();

            if (value) {
                stats.push({ label, value });
            }
        });

        this.context.data.statistics = stats;
        return stats;
    }

    /**
     * Collect semua context sekaligus
     */
    collectAll() {
        this.collectPageInfo();
        this.collectUserInfo();
        this.collectTableData();
        this.collectChartData();
        this.collectFilterStates();
        this.collectStatistics();
        
        // Trigger callbacks
        this.triggerUpdateCallbacks();
        
        return this.context;
    }

    /**
     * Setup observers untuk reactive updates
     */
    setupObservers() {
        // Observer 1: Filter changes (debounced)
        this.observeFilterChanges();
        
        // Observer 2: DOM mutations (untuk dynamic content)
        this.observeDOMMutations();
        
        // Observer 3: URL changes (SPA navigation)
        this.observeURLChanges();
    }

    /**
     * Observer untuk perubahan filter/form
     */
    observeFilterChanges() {
        const debouncedUpdate = this.debounce(() => {
            console.log('🔄 Filter changed, updating context...');
            this.collectFilterStates();
            this.triggerUpdateCallbacks();
        }, 500);

        // Listen ke semua form inputs
        document.addEventListener('change', (e) => {
            if (e.target.matches('input, select, textarea')) {
                debouncedUpdate();
            }
        });

        // Listen ke input events (untuk realtime search)
        document.addEventListener('input', (e) => {
            if (e.target.matches('input[type="text"], input[type="search"]')) {
                debouncedUpdate();
            }
        });
    }

    /**
     * Observer untuk DOM mutations (table updates, AJAX content)
     */
    observeDOMMutations() {
        const observer = new MutationObserver(this.debounce((mutations) => {
            // Check if mutation affects data elements
            const hasDataChange = mutations.some(mutation => {
                const target = mutation.target;
                return target.matches && (
                    target.matches('table, tbody, [data-stat], canvas') ||
                    target.querySelector('table, tbody, [data-stat], canvas')
                );
            });

            if (hasDataChange) {
                console.log('🔄 DOM updated, refreshing context...');
                this.collectTableData();
                this.collectChartData();
                this.collectStatistics();
                this.triggerUpdateCallbacks();
            }
        }, 1000));

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        this.observers.push(observer);
    }

    /**
     * Observer untuk URL changes (history API)
     */
    observeURLChanges() {
        let lastUrl = window.location.href;
        
        const checkUrlChange = () => {
            const currentUrl = window.location.href;
            if (currentUrl !== lastUrl) {
                console.log('🔄 URL changed, reinitializing context...');
                lastUrl = currentUrl;
                this.collectAll();
            }
        };

        // Override pushState dan replaceState
        const originalPushState = history.pushState;
        const originalReplaceState = history.replaceState;

        history.pushState = function(...args) {
            originalPushState.apply(this, args);
            checkUrlChange();
        };

        history.replaceState = function(...args) {
            originalReplaceState.apply(this, args);
            checkUrlChange();
        };

        // Listen popstate untuk back/forward
        window.addEventListener('popstate', checkUrlChange);
    }

    /**
     * Register callback untuk update events
     */
    onContextUpdate(callback) {
        if (typeof callback === 'function') {
            this.updateCallbacks.push(callback);
        }
    }

    /**
     * Trigger semua update callbacks
     */
    triggerUpdateCallbacks() {
        this.updateCallbacks.forEach(callback => {
            try {
                callback(this.context);
            } catch (e) {
                console.error('Context update callback error:', e);
            }
        });
    }

    /**
     * Get context summary untuk AI (format ringkas)
     */
    getContextSummary() {
        const summary = {
            page: `${this.context.page.module} (${this.context.page.pathname})`,
            user: this.context.user.name || 'Unknown User',
            dataAvailable: []
        };

        if (this.context.data.tables?.length > 0) {
            summary.dataAvailable.push(
                `${this.context.data.tables.length} tabel dengan total ${this.context.data.tables.reduce((sum, t) => sum + t.rowCount, 0)} baris`
            );
            summary.tables = this.context.data.tables.map(t => t.summary);
        }

        if (this.context.data.charts?.length > 0) {
            summary.dataAvailable.push(`${this.context.data.charts.length} chart/grafik`);
            summary.charts = this.context.data.charts.map(c => c.summary);
        }

        if (this.context.data.statistics?.length > 0) {
            summary.dataAvailable.push(`${this.context.data.statistics.length} statistik/metrik`);
            summary.statistics = this.context.data.statistics;
        }

        if (Object.keys(this.context.filters).length > 0) {
            summary.filters = Object.entries(this.context.filters).map(([key, filter]) => {
                return `${filter.label || key}: ${filter.value || filter.text}`;
            });
        }

        return summary;
    }

    /**
     * Get full context (untuk debug atau AI advanced)
     */
    getFullContext() {
        return JSON.parse(JSON.stringify(this.context));
    }

    /**
     * Utility: Debounce function
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * Cleanup observers (saat chatbot di-unmount)
     */
    destroy() {
        this.observers.forEach(observer => observer.disconnect());
        this.observers = [];
        this.updateCallbacks = [];
    }
}

// Export untuk use di chat-icon.blade.php
if (typeof window !== 'undefined') {
    window.ChatPageContext = ChatPageContext;
}
