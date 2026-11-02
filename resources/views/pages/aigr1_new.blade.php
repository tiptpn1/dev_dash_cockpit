<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AIGR1 - Asisten AI PTPN 1</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Rich chat content (same pipeline as the dashboard chatbot): markdown + sanitizer + shared renderer -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3/dist/purify.min.js"></script>
    <script src="{{ asset('js/chat-content-renderer.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/aigr1-futuristic.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #6366f1;      /* Indigo modern */
            --secondary-color: #8b5cf6;    /* Purple soft */
            --accent-color: #10b981;       /* Emerald green */
            --danger-color: #ef4444;       /* Red modern */
            --dark-bg: #0f172a;            /* Slate 900 */
            --dark-panel: #1e293b;         /* Slate 800 */
            --dark-card: #334155;          /* Slate 700 */
            --text-primary: #f8fafc;       /* Slate 50 */
            --text-secondary: #94a3b8;     /* Slate 400 */
            --border-color: rgba(148, 163, 184, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            overflow: hidden;
            height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 92, 246, 0.08) 0%, transparent 50%);
            z-index: 0;
            pointer-events: none;
        }

        /* Animated Background Grid */
        .grid-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(0, 217, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 217, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
            z-index: 0;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Particle Effects */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--primary-cyan);
            border-radius: 50%;
            animation: float 10s infinite ease-in-out;
            opacity: 0.5;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
            50% { opacity: 1; }
        }

        /* Main Layout */
        .main-container {
            position: relative;
            z-index: 2;
            display: flex;
            height: 100vh;
            overflow: hidden;
            gap: 20px;
            padding: 20px;
        }

        /* AIGR1 Call Panel - Modern Minimal - Portrait 768x1152 (2:3 ratio) */
        .call-panel {
            width: 640px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border-right: 1px solid var(--border-color);
            border-radius: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        /* ───────── AGRINAV navigation drawer (same behaviour as dashboard home) ───────── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 100vh;
            height: 100dvh;
            background-color: #202124;
            overflow-x: hidden;
            overflow-y: auto;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s;
            z-index: 99999;
            visibility: hidden;
            box-sizing: border-box;
            font-family: 'Droid Sans', 'Inter', sans-serif;
        }

        .sidebar.open {
            width: 250px;
            padding: 1rem;
            visibility: visible;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
        }

        .sidebar .sidebar-header {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 12px 10px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(0, 0, 0, 0.15);
            border-radius: 6px;
        }
        .sidebar.open .sidebar-header { display: flex; }

        .sidebar .sidebar-brand { display: flex; align-items: center; gap: 10px; }
        .sidebar .sidebar-title { font-size: 1.35rem; font-weight: 700; letter-spacing: 0.05em; color: #e8eaed; }
        .sidebar .sidebar-logo { height: 32px; width: auto; object-fit: contain; }

        .sidebar .sidebar-close-btn {
            background: none;
            border: none;
            color: #9aa0a6;
            font-size: 1.75rem;
            line-height: 1;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: color 0.2s, background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar .sidebar-close-btn:hover { color: #fff; background-color: rgba(255, 255, 255, 0.1); }

        .sidebar .menu { display: none; padding-top: 12px; }
        .sidebar.open .menu { display: block; }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            text-decoration: none;
            color: #e8e8e8;
            text-align: left;
            transition: background-color 0.3s;
            font-size: 1em;
            min-height: 40px;
        }
        .sidebar a:hover { background-color: #575757; }

        .sidebar .menu-icon { flex-shrink: 0; width: 1.15em; margin-right: 10px; text-align: center; color: #e8e8e8; }
        .sidebar a .toggle-icon { margin-left: auto; flex-shrink: 0; font-size: 0.78em; transition: transform 0.3s; }
        .sidebar a .toggle-icon.open { transform: rotate(90deg); }

        .sidebar .submenu { display: none; background-color: #3c4043; }
        .sidebar .submenu a { padding-left: 36px; }
        .sidebar a.active + .submenu { display: block; }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: #1e1f22; }
        .sidebar::-webkit-scrollbar-thumb { background: #4e5058; border-radius: 3px; }

        /* Hamburger button (top-left, outside the drawer) */
        .icon {
            position: fixed;
            top: 10px;
            left: 10px;
            cursor: pointer;
            z-index: 10002;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.35);
            border-radius: 8px;
            backdrop-filter: blur(4px);
            transition: background-color 0.2s;
        }
        .icon:hover { background: rgba(0, 0, 0, 0.55); }
        .icon img { width: 26px; height: 26px; }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            height: 100dvh;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            z-index: 99998;
        }
        .sidebar-backdrop.active { display: block; }

        @media (max-width: 768px) {
            .sidebar.open { width: 280px; max-width: 82vw; }
            .sidebar a { padding: 12px 14px; font-size: 0.95rem; }
        }

        /* Logo Section - Modern Minimal */
        .logo-section {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            background: rgba(30, 41, 59, 0.5);
        }

        .logo-section .hud-circle {
            display: none;
        }

        .logo-section h1 {
            font-family: 'Inter', sans-serif;
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .logo-section p {
            font-size: 11px;
            color: var(--text-secondary);
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* New Chat Button - Modern Gradient */
        .new-chat-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 0;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: none;
            letter-spacing: 0;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .new-chat-btn:hover {
            opacity: 0.9;
        }

        .new-chat-btn:active {
            transform: scale(0.98);
        }

        /* Session History - Modern Minimal */
        .session-history {
            max-height: 200px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 16px;
            background: rgba(15, 23, 42, 0.3);
        }

        .session-history::-webkit-scrollbar {
            width: 4px;
        }

        .session-history::-webkit-scrollbar-track {
            background: transparent;
        }

        .session-history::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 10px;
        }

        .session-history::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.5);
        }

        .session-item {
            padding: 12px;
            background: rgba(51, 65, 85, 0.3);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .session-item:hover {
            background: rgba(51, 65, 85, 0.5);
            border-color: rgba(148, 163, 184, 0.3);
            transform: translateX(4px);
        }

        .session-item.active {
            background: rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .session-title {
            font-size: 13px;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            font-weight: 500;
        }

        .session-actions {
            display: flex;
            gap: 8px;
        }

        .session-btn {
            width: 28px;
            height: 28px;
            background: rgba(51, 65, 85, 0.5);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
        }

        .session-btn:hover {
            background: rgba(99, 102, 241, 0.2);
            border-color: var(--primary-color);
            transform: scale(1.1);
        }

        .session-btn:active {
            transform: scale(0.95);
        }

        /* Main Chat Area */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 0;
            overflow: hidden;
        }

        /* Video Call Panel - Modern Minimal */
        .video-panel {
            background: #0f172a;
            border: none;
            border-bottom: 1px solid var(--border-color);
            border-radius: 0;
            padding: 0;
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .video-panel video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #000;
        }

        /* Video Container with Modern Corners */
        .video-container {
            flex: 1;
            background: #000;
            position: relative;
            overflow: hidden;
        }
        
        /* Video wrapper to maintain aspect ratio */
        .video-wrapper {
            width: 100%;
            height: 115%;
            position: relative;
        }
        
        .video-wrapper video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Video Call Button (Like Mobile) */
        .call-button-container {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            z-index: 10;
        }

        /* Main Call Button - Modern Style */
        .main-call-button {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: none;
            background: var(--accent-color);
            color: white;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
        }

        .main-call-button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
        }

        .main-call-button:active {
            transform: scale(0.95);
        }

        .main-call-button.active {
            background: var(--danger-color);
            box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
        }

        .main-call-button.active:hover {
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4);
        }

        /* Secondary Controls Row */
        .secondary-controls {
            display: flex;
            gap: 15px;
            background: rgba(10, 14, 26, 0.9);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 50px;
            border: 1px solid rgba(0, 217, 255, 0.3);
        }

        .video-controls {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            background: rgba(10, 14, 26, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: 50px;
            border: 1px solid rgba(0, 217, 255, 0.3);
            display: none; /* Hidden by default, shown when call is active */
        }

        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--primary-cyan);
            background: rgba(0, 217, 255, 0.1);
            color: var(--primary-cyan);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 20px;
        }

        .control-btn:hover {
            background: var(--primary-cyan);
            color: var(--dark-bg);
            box-shadow: var(--glow-cyan);
            transform: scale(1.1);
        }

        .control-btn.active {
            background: var(--accent-green);
            border-color: var(--accent-green);
            color: var(--dark-bg);
        }

        .control-btn.danger {
            border-color: var(--accent-orange);
            color: var(--accent-orange);
        }

        .control-btn.danger:hover {
            background: var(--accent-orange);
            color: var(--text-primary);
        }

        /* Secondary Controls - Modern Minimal */
        .secondary-controls {
            display: flex;
            gap: 12px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(24px);
            padding: 12px 20px;
            border-radius: 100px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        .control-btn-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: rgba(51, 65, 85, 0.5);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 16px;
        }

        .control-btn-small:hover {
            border-color: var(--primary-color);
            background: rgba(99, 102, 241, 0.2);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .control-btn-small:active {
            transform: translateY(0);
        }

        .control-btn-small.active {
            background: rgba(16, 185, 129, 0.2);
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        /* Video Status - Modern Badge */
        .video-status {
            position: absolute;
            top: 32px;
            left: 32px;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(24px);
            padding: 10px 18px;
            border-radius: 100px;
            border: 1px solid var(--border-color);
            font-size: 12px;
            color: var(--text-primary);
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 10;
            font-weight: 600;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-color);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Chat Messages Panel */
        .chat-panel {
            flex: 1;
            min-height: 0;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(15, 20, 32, 0.95) 0%, rgba(26, 31, 46, 0.95) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 217, 255, 0.3);
            border-radius: 0;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 
                var(--glow-cyan),
                inset 0 0 30px rgba(0, 217, 255, 0.05);
            position: relative;
        }

        .messages-container {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-right: 10px;
            padding-bottom: 8px;
        }

        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: rgba(0, 217, 255, 0.1);
            border-radius: 10px;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: var(--primary-cyan);
            border-radius: 10px;
        }

        .message {
            display: flex;
            gap: 15px;
            align-items: flex-start;
            animation: messageSlide 0.3s ease;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .message.user .message-avatar {
            background: linear-gradient(135deg, var(--primary-purple), var(--primary-cyan));
            box-shadow: var(--glow-purple);
        }

        .message.assistant .message-avatar {
            background: linear-gradient(135deg, var(--primary-cyan), var(--accent-green));
            box-shadow: var(--glow-cyan);
        }

        .message-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .message-content {
            max-width: 70%;
            padding: 15px 20px;
            border-radius: 15px;
            line-height: 1.6;
            font-size: 15px;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, rgba(178, 75, 243, 0.3), rgba(178, 75, 243, 0.1));
            border: 1px solid rgba(178, 75, 243, 0.4);
            color: var(--text-primary);
        }

        .message.assistant .message-content {
            background: linear-gradient(135deg, rgba(0, 217, 255, 0.2), rgba(0, 217, 255, 0.05));
            border: 1px solid rgba(0, 217, 255, 0.3);
            color: var(--text-primary);
        }

        /* Rich assistant content: markdown, tables, charts / images */
        .message-content { min-width: 0; overflow-wrap: anywhere; }
        .message.assistant .message-content.has-media { max-width: 88%; }
        .message.assistant .message-content > :first-child { margin-top: 0; }
        .message.assistant .message-content > :last-child { margin-bottom: 0; }
        .message.assistant .message-content p { margin: 0 0 0.65em; }
        .message.assistant .message-content h1,
        .message.assistant .message-content h2,
        .message.assistant .message-content h3,
        .message.assistant .message-content h4 { margin: 0.9em 0 0.4em; font-weight: 700; line-height: 1.3; color: #fff; }
        .message.assistant .message-content h1 { font-size: 1.25em; }
        .message.assistant .message-content h2 { font-size: 1.15em; }
        .message.assistant .message-content h3 { font-size: 1.05em; }
        .message.assistant .message-content h4 { font-size: 1em; }
        .message.assistant .message-content ul,
        .message.assistant .message-content ol { margin: 0.3em 0 0.75em; padding-left: 1.4em; }
        .message.assistant .message-content li { margin: 0.2em 0; }
        .message.assistant .message-content strong { color: #fff; font-weight: 700; }
        .message.assistant .message-content a { color: #67e8f9; text-decoration: underline; }
        .message.assistant .message-content code { background: rgba(15, 23, 42, 0.6); padding: 0.1em 0.4em; border-radius: 4px; font-size: 0.9em; }
        .message.assistant .message-content pre { background: rgba(2, 6, 23, 0.7); padding: 12px; border-radius: 8px; overflow-x: auto; margin: 0.6em 0; }
        .message.assistant .message-content pre code { background: none; padding: 0; }
        .message.assistant .message-content blockquote { margin: 0.6em 0; padding: 0.4em 0.9em; border-left: 3px solid rgba(0, 217, 255, 0.6); background: rgba(0, 217, 255, 0.07); border-radius: 0 8px 8px 0; }
        .message.assistant .message-content hr { border: none; border-top: 1px solid rgba(148, 163, 184, 0.25); margin: 0.9em 0; }
        .message.assistant .message-content .table-wrap { overflow-x: auto; margin: 0.6em 0; border-radius: 8px; border: 1px solid rgba(0, 217, 255, 0.2); }
        .message.assistant .message-content table { border-collapse: collapse; width: 100%; font-size: 0.92em; }
        .message.assistant .message-content th,
        .message.assistant .message-content td { padding: 8px 12px; text-align: left; border-bottom: 1px solid rgba(148, 163, 184, 0.15); }
        .message.assistant .message-content th { background: rgba(0, 217, 255, 0.12); font-weight: 700; }
        .message.assistant .message-content tr:last-child td { border-bottom: none; }
        .message.assistant .message-content .ai-generated-image { margin: 0.75em 0; text-align: center; }
        .message.assistant .message-content img { max-width: 100%; height: auto; border-radius: 10px; background: #fff; border: 1px solid rgba(148, 163, 184, 0.25); cursor: zoom-in; }
        .message.assistant .message-content .chart-caption { font-size: 0.82em; color: var(--text-secondary); margin-top: 6px; }
        .message.assistant .message-content .chart-generating-hint { margin-top: 8px; font-size: 0.85em; opacity: 0.8; animation: hintPulse 1.4s ease-in-out infinite; }
        .thinking-label { opacity: 0.85; font-style: italic; }
        .msg-error { color: #fca5a5; }
        .msg-warn { color: #fcd34d; }
        .img-error { font-size: 0.85em; opacity: 0.7; }
        @keyframes hintPulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 1; } }
        .img-lightbox { position: fixed; inset: 0; z-index: 100000; background: rgba(2, 6, 23, 0.88); display: flex; align-items: center; justify-content: center; padding: 24px; cursor: zoom-out; }
        .img-lightbox img { max-width: 96vw; max-height: 92vh; border-radius: 12px; background: #fff; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6); }

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            gap: 5px;
            padding: 15px 20px;
            background: linear-gradient(135deg, rgba(0, 217, 255, 0.2), rgba(0, 217, 255, 0.05));
            border: 1px solid rgba(0, 217, 255, 0.3);
            border-radius: 15px;
            width: fit-content;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-cyan);
            animation: typingBounce 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }

        /* Input Area */
        .input-area {
            display: flex;
            flex-shrink: 0;
            gap: 15px;
            align-items: center;
            background: rgba(0, 217, 255, 0.05);
            border: 1px solid rgba(0, 217, 255, 0.2);
            border-radius: 15px;
            padding: 15px;
        }

        .input-modes {
            display: flex;
            gap: 10px;
        }

        .mode-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(0, 217, 255, 0.3);
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .mode-btn:hover, .mode-btn.active {
            border-color: var(--primary-cyan);
            color: var(--primary-cyan);
            background: rgba(0, 217, 255, 0.1);
        }

        .message-input {
            flex: 1;
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-family: 'Rajdhani', sans-serif;
            font-size: 16px;
            outline: none;
            resize: none;
            max-height: 100px;
        }

        .message-input::placeholder {
            color: var(--text-secondary);
        }

        .send-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-purple));
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 20px;
            box-shadow: var(--glow-cyan);
        }

        .send-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 30px rgba(0, 217, 255, 0.8);
        }

        .send-btn:active {
            transform: scale(0.95);
        }

        /* Back Button - Modern Minimal */
        .back-btn {
            width: 100%;
            padding: 16px;
            background: rgba(30, 41, 59, 0.5);
            border: none;
            border-top: 1px solid var(--border-color);
            border-radius: 0;
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: none;
            letter-spacing: 0;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: rgba(51, 65, 85, 0.5);
            color: var(--text-primary);
        }

        .back-btn:active {
            transform: scale(0.98);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .call-panel {
                width: 500px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                height: 100vh;
                overflow: hidden;
                gap: 10px;
            }

            .call-panel {
                width: 100%;
                min-height: 350px;
                max-height: 45vh;
                flex-shrink: 0;
            }

            .chat-area {
                flex: 1;
                min-height: 0;
                overflow: hidden;
            }

            .session-history {
                max-height: 150px;
            }
        }
        
        @media (min-width: 1400px) {
            .call-panel {
                width: 720px;
            }
            
            .main-call-button {
                width: 80px;
                height: 80px;
                font-size: 36px;
            }
        }

        /* ── Microphone Check & Test ─────────────────────────────── */
        .mic-test-btn {
            width: 100%;
            padding: 12px 16px;
            background: rgba(99, 102, 241, 0.1);
            border: none;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s ease;
        }
        .mic-test-btn:hover { background: rgba(99, 102, 241, 0.22); }

        .mt-overlay {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(6px);
        }
        .mt-overlay.open { display: flex; }

        .mt-modal {
            width: 100%;
            max-width: 460px;
            max-height: 92vh;
            overflow-y: auto;
            padding: 22px;
            border-radius: 16px;
            background: var(--dark-panel);
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.5);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            animation: mtPop 0.2s ease;
        }
        @keyframes mtPop { from { opacity: 0; transform: translateY(8px) scale(0.98); } to { opacity: 1; transform: none; } }

        .mt-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .mt-header h2 { font-size: 17px; font-weight: 700; margin: 0; }
        .mt-close { background: none; border: none; color: var(--text-secondary); font-size: 26px; line-height: 1; cursor: pointer; }
        .mt-close:hover { color: var(--text-primary); }

        .mt-checks { list-style: none; margin: 0 0 14px; padding: 0; display: flex; flex-direction: column; gap: 8px; }
        .mt-checks li { display: flex; align-items: flex-start; gap: 10px; font-size: 12.5px; line-height: 1.45; color: var(--text-secondary); }
        .mt-dot { flex: 0 0 10px; width: 10px; height: 10px; margin-top: 4px; border-radius: 50%; background: #64748b; }
        .mt-checks li[data-state="ok"] .mt-dot { background: var(--accent-color); box-shadow: 0 0 8px rgba(16, 185, 129, 0.6); }
        .mt-checks li[data-state="warn"] .mt-dot { background: #f59e0b; }
        .mt-checks li[data-state="err"] .mt-dot { background: var(--danger-color); box-shadow: 0 0 8px rgba(239, 68, 68, 0.6); }
        .mt-checks li[data-state="ok"] { color: var(--text-primary); }
        .mt-checks li[data-state="err"] { color: #fca5a5; }

        .mt-label { display: block; margin: 12px 0 6px; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; color: var(--text-secondary); }
        .mt-select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            background: var(--dark-bg);
            border: 1px solid rgba(148, 163, 184, 0.25);
            color: var(--text-primary);
            font-size: 13px;
        }

        .mt-meter { height: 14px; border-radius: 7px; background: var(--dark-bg); overflow: hidden; border: 1px solid rgba(148, 163, 184, 0.2); }
        .mt-meter-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent-color) 0%, #f59e0b 70%, var(--danger-color) 100%);
            background-size: 100% 100%;
            transition: width 0.06s linear;
        }
        .mt-meter-db { margin-top: 4px; font-size: 11px; text-align: right; color: var(--text-secondary); font-variant-numeric: tabular-nums; }

        .mt-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
        .mt-btn {
            flex: 1 1 auto;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid rgba(148, 163, 184, 0.3);
            background: var(--dark-card);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.1s ease;
        }
        .mt-btn:hover:not(:disabled) { opacity: 0.88; }
        .mt-btn:active:not(:disabled) { transform: scale(0.98); }
        .mt-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .mt-btn.primary { background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-color: transparent; }
        .mt-btn.danger { background: var(--danger-color); border-color: transparent; }
        .mt-btn.recording { background: var(--danger-color); border-color: transparent; animation: mtPulse 1s infinite; }
        @keyframes mtPulse { 50% { opacity: 0.65; } }

        .mt-status { margin: 14px 0 0; font-size: 12.5px; color: var(--text-primary); min-height: 18px; }
        .mt-note { margin: 8px 0 0; font-size: 11.5px; color: var(--text-secondary); }

        /* Mic test shortcut on the video panel (always visible, independent of panel height) */
        .mic-test-fab {
            position: absolute;
            top: 32px;
            right: 32px;
            z-index: 11;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 100px;
            border: 1px solid rgba(99, 102, 241, 0.45);
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            transition: background 0.2s ease, transform 0.15s ease;
        }
        .mic-test-fab:hover { background: rgba(99, 102, 241, 0.35); transform: translateY(-1px); }
        .call-panel > .new-chat-btn, .call-panel > .mic-test-btn, .call-panel > .back-btn { flex-shrink: 0; }

        /* Call / control feedback states */
        .main-call-button.connecting { background: #f59e0b; box-shadow: 0 4px 16px rgba(245, 158, 11, 0.35); animation: mtPulse 1.2s infinite; }
        .control-btn-small.off { background: rgba(239, 68, 68, 0.18); border-color: var(--danger-color); color: var(--danger-color); }
        .send-btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none; }
        .send-btn.busy { animation: mtPulse 1.2s infinite; }

        /* Toast notifications */
        .toast-host {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10001;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            pointer-events: none;
        }
        .toast {
            max-width: min(90vw, 440px);
            padding: 10px 16px;
            border-radius: 10px;
            background: var(--dark-panel);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-left: 4px solid var(--primary-color);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
            animation: mtPop 0.2s ease;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .toast.hide { opacity: 0; transform: translateY(6px); }
        .toast-success { border-left-color: var(--accent-color); }
        .toast-warn { border-left-color: #f59e0b; }
        .toast-error { border-left-color: var(--danger-color); }
    </style>
</head>
<body>
    <!-- Advanced HUD Background -->
    <div class="hud-background">
        <!-- Circuit Pattern -->
        <div class="circuit-pattern"></div>
        
        <!-- Hexagon Pattern -->
        <div class="hexagon-pattern"></div>
        
        <!-- Digital Noise -->
        <div class="digital-noise"></div>
        
        <!-- Scanlines -->
        <div class="scanlines"></div>
        
        <!-- Data Streams -->
        <div class="data-stream" style="left: 10%; animation-delay: 0s;"></div>
        <div class="data-stream" style="left: 30%; animation-delay: 1s;"></div>
        <div class="data-stream" style="left: 50%; animation-delay: 2s;"></div>
        <div class="data-stream" style="left: 70%; animation-delay: 0.5s;"></div>
        <div class="data-stream" style="left: 90%; animation-delay: 1.5s;"></div>
    </div>

    <!-- Animated Background Grid -->
    <div class="grid-background"></div>
    <div class="particles" id="particles"></div>

    <!-- AGRINAV menu toggle (hamburger, same as dashboard home) -->
    <div class="icon" id="menuIcon" title="Buka/tutup menu">
        <img src="{{ url('') }}/asset/images/menu.png" alt="Menu Icon">
    </div>

    <!-- Backdrop overlay for the AGRINAV menu -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- AGRINAV navigation drawer (list menu, shared with dashboard) -->
    @include('layouts.sidebar')

    <!-- Main Container -->
    <div class="main-container">
        <!-- Call Panel - Video Call -->
        <aside class="call-panel" id="callPanel">
            <!-- Compact Header -->
            <div class="logo-section">
                <h1 class="glitch" data-text="AIGR1">AIGR1</h1>
                <p>PTPN 1 AI ASSISTANT</p>
            </div>

            <!-- Video Call Panel - Portrait Full Height -->
            <div class="video-panel" id="videoPanel">
                <!-- Video Status Badge -->
                <div class="video-status">
                    <div class="status-dot"></div>
                    <span id="videoStatus" aria-live="polite">Siap</span>
                </div>

                <button class="mic-test-fab" id="openMicTestFab" onclick="openMicTest()" title="Cek & test mikrofon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line></svg>
                    Tes Mikrofon
                </button>
                
                <!-- Video Container -->
                <div class="video-container">
                    <div class="video-wrapper">
                        <!-- Video Element - Fullscreen Portrait -->
                        <video id="avatarVideo" autoplay playsinline style="display: none;"></video>
                    
                        <!-- Placeholder when no call -->
                        <div id="avatarPlaceholder" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 1;">
                            <div style="width: 160px; height: 160px; margin: 0 auto 20px;">
                                <img src="{{ asset('eva-ico.png') }}" alt="EVA Avatar" style="width: 140px; height: 140px; border-radius: 50%; box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);">
                            </div>
                            <h3 style="font-family: 'Inter', sans-serif; color: var(--primary-color); margin-bottom: 8px; font-size: 20px; font-weight: 700;">EVA</h3>
                            <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.6; max-width: 280px;">Tekan tombol untuk memulai video call</p>
                        </div>
                    </div>
                </div>
                
                <!-- Call Controls Overlay -->
                <div class="call-button-container">
                    <!-- Secondary Controls (shown when call is active) -->
                    <div class="secondary-controls" id="secondaryControls" style="display: none;">
                        <button class="control-btn-small" id="videoToggleSmall" title="Tampilkan/sembunyikan avatar" aria-label="Tampilkan atau sembunyikan avatar" onclick="toggleVideo()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                        </button>
                        <button class="control-btn-small" id="micToggleSmall" title="Nyalakan/bisukan mikrofon" aria-label="Nyalakan atau bisukan mikrofon" onclick="toggleMic()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                                <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                <line x1="12" y1="19" x2="12" y2="23"></line>
                                <line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                        </button>
                        <button class="control-btn-small" id="speakerToggleSmall" title="Nyalakan/bisukan suara EVA" aria-label="Nyalakan atau bisukan suara EVA" onclick="toggleSpeaker()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Main Call/End Button -->
                    <button class="main-call-button" id="mainCallButton" onclick="handleMainCallButton()" title="Mulai panggilan" aria-label="Mulai panggilan">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </button>
                    
                    <div style="text-align: center;">
                        <p id="callButtonLabel" style="color: var(--accent-color); font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">
                            Ketuk untuk menelepon
                        </p>
                    </div>
                </div>
            </div>

            <!-- Session History at Bottom -->
            <button class="new-chat-btn" onclick="startNewSession()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Sesi Baru
            </button>

            <button class="mic-test-btn" id="openMicTestBtn" onclick="openMicTest()" title="Cek &amp; test mikrofon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                    <line x1="12" y1="19" x2="12" y2="23"></line>
                    <line x1="8" y1="23" x2="16" y2="23"></line>
                </svg>
                Cek &amp; Test Mikrofon
            </button>

            <div class="session-history" id="sessionHistory">
                <!-- Session items will be dynamically added here -->
            </div>

            <a href="{{ route('overview') }}" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle;">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke AGRINAV
            </a>
        </aside>

        <!-- Main Chat Area -->
        <div class="chat-area">
            <!-- Chat Panel -->
            <div class="chat-panel">
                <!-- Energy Bar Header -->
                <div style="margin-bottom: 15px;">
                    <div class="energy-bar"></div>
                </div>
                
                <div class="messages-container" id="messagesContainer">
                    <div class="message assistant">
                        <div class="message-avatar">
                            <img src="{{ asset('eva-ico.png') }}" alt="EVO">
                        </div>
                        <div class="message-content">
                            👋 Halo! Saya EVA, asisten AI untuk AGRINAV PTPN 1. Saya bisa membantu Anda melalui teks, suara, atau video call. Ada yang bisa saya bantu hari ini?
                        </div>
                    </div>
                </div>

                <div class="input-area">
                    <div class="input-modes">
                        <button class="mode-btn active" id="textMode" title="Mode teks" onclick="setInputMode('text')">
                            💬
                        </button>
                        <button class="mode-btn" id="voiceMode" title="Mode suara (bicara langsung dengan EVA)" onclick="setInputMode('voice')">
                            🎙️
                        </button>
                        <button class="mode-btn" id="videoMode" title="Mode video call" onclick="setInputMode('video')">
                            📹
                        </button>
                    </div>
                    <textarea 
                        class="message-input" 
                        id="messageInput" 
                        placeholder="Ketik pesan Anda di sini..."
                        rows="1"
                        onkeydown="handleKeyPress(event)"
                    ></textarea>
                    <button class="send-btn" id="sendBtn" onclick="sendMessage()" title="Kirim pesan" aria-label="Kirim pesan">
                        ➤
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-host" id="toastHost" aria-live="polite"></div>

    <!-- Microphone Check & Test modal -->
    <div class="mt-overlay" id="micTestModal" role="dialog" aria-modal="true" aria-labelledby="mtTitle">
        <div class="mt-modal">
            <div class="mt-header">
                <h2 id="mtTitle">Cek &amp; Test Mikrofon</h2>
                <button class="mt-close" onclick="closeMicTest()" title="Tutup" aria-label="Tutup">&times;</button>
            </div>

            <ul class="mt-checks">
                <li data-mt-check="secure" data-state="idle"><span class="mt-dot"></span><span class="mt-check-text">Memeriksa...</span></li>
                <li data-mt-check="support" data-state="idle"><span class="mt-dot"></span><span class="mt-check-text">Memeriksa...</span></li>
                <li data-mt-check="perm" data-state="idle"><span class="mt-dot"></span><span class="mt-check-text">Memeriksa...</span></li>
                <li data-mt-check="device" data-state="idle"><span class="mt-dot"></span><span class="mt-check-text">Memeriksa...</span></li>
                <li data-mt-check="signal" data-state="idle"><span class="mt-dot"></span><span class="mt-check-text">Belum diuji</span></li>
            </ul>

            <label class="mt-label" for="mtDevice">Perangkat mikrofon</label>
            <select id="mtDevice" class="mt-select"></select>

            <label class="mt-label">Level suara</label>
            <div class="mt-meter"><div class="mt-meter-fill" id="mtMeterFill"></div></div>
            <div class="mt-meter-db" id="mtMeterDb">-∞ dB</div>

            <div class="mt-actions">
                <button class="mt-btn primary" id="mtStartBtn" onclick="micTestStart()">Mulai Test</button>
                <button class="mt-btn danger" id="mtStopBtn" onclick="micTestStop()" style="display:none;">Stop</button>
                <button class="mt-btn" id="mtRecordBtn" onclick="micTestRecord()" disabled><span>Rekam &amp; Putar Ulang</span></button>
            </div>

            <p class="mt-status" id="mtStatus">Klik "Mulai Test" lalu bicara.</p>
            <p class="mt-note" id="mtCallNote" style="display:none;">Video call sedang aktif. Perangkat yang dipilih akan dipakai pada panggilan berikutnya.</p>
        </div>
    </div>

    <script type="module">
        // Global variables
        let currentSessionId = Date.now();
        let currentInputMode = 'text';
        let isProcessing = false;
        let aiSessionId = '';   // ai-be sessionId (conversation memory) - distinct from the local history id
        let anamClient = null;
        let mediaRecorder = null;
        let audioChunks = [];
        let isVideoCallActive = false;
        let isMicActive = false;
        let isSpeakerActive = true;
        let isVideoActive = true;
        let voiceTurnInFlight = false;   // true while a voice/typed-in-call turn owns isProcessing

        // ai-be voice brain state (Anam = STT + avatar + TTS; answers come from ai-be)
        const ANAM_SDK_URL = 'https://esm.sh/@anam-ai/js-sdk@4.29.1';
        // Cached, retry-safe SDK loader. Warmed up while the page is idle so a call doesn't pay the
        // esm.sh download (often the slowest step on corporate networks) on its critical path.
        let anamSdkPromise = null;
        function loadAnamSdk() {
            if (!anamSdkPromise) {
                anamSdkPromise = import(ANAM_SDK_URL).catch(err => { anamSdkPromise = null; throw err; });
            }
            return anamSdkPromise;
        }
        (window.requestIdleCallback || ((cb) => setTimeout(cb, 1500)))(() => { loadAnamSdk().catch(() => {}); });
        const VOICE_GREETING = 'Halo, saya EVA, asisten AgriNav PTPN 1. Siap membantu. Ada yang ingin Anda tanyakan?';
        const VOICE_FILLER_POOL = [
            'Baik, saya cek datanya dulu ya.',
            'Sebentar ya, saya ambilkan datanya.',
            'Oke, saya carikan datanya dulu.',
            'Baik, mohon tunggu sebentar, saya cek dulu.',
        ];
        const VOICE_STILL_WORKING_POOL = [
            'Datanya masih saya proses, sebentar lagi ya.',
            'Masih saya kumpulkan datanya, mohon tunggu sebentar.',
        ];
        const VOICE_ERROR = 'Maaf, saya sedang mengalami kendala. Silakan coba lagi sebentar lagi.';
        const VOICE_FAREWELL = 'Baik, sampai jumpa lagi!';
        const VOICE_FILLER_AFTER_MS = 1300;   // one natural filler if the answer is not ready yet
        const VOICE_STILL_WORKING_MS = 9000;  // second (last) filler for slow data fetches
        const USER_TURN_DEBOUNCE_MS = 1100;   // trailing-silence before firing ai-be (avoids splitting one sentence)
        const TURN_MERGE_WINDOW_MS  = 3000;   // a follow-up fragment this soon (unanswered) is merged into the previous turn
        // Adaptive status labels cycling through processing stages
        const STATUS_CYCLE = ['Menganalisis...', 'Mengambil data...', 'Menyusun jawaban...'];
        let brainMode = 'anam';
        let voiceTurnTimer = null;
        let voiceAbort = null;
        let voiceTurnSeq = 0;
        let activeTalkStream = null;
        let isEvaSpeaking = false;
        let evaSpeakingTimer = null;
        let currentSpokenText = '';
        let lastTurn = { text: '', at: 0, answered: true };   // used to merge split utterances
        let statusCycleTimer = null;    // cycles HUD labels while processing
        const handledUserMessageIds = new Set();

        function pickRandom(arr) { return arr[Math.floor(Math.random() * arr.length)]; }

        // Cycle through STATUS_CYCLE labels while the AI is working.
        function startStatusCycle(el) {
            stopStatusCycle();
            let idx = 0;
            el.textContent = STATUS_CYCLE[idx];
            statusCycleTimer = setInterval(() => {
                idx = (idx + 1) % STATUS_CYCLE.length;
                el.textContent = STATUS_CYCLE[idx];
            }, 2000);
        }
        function stopStatusCycle() {
            if (statusCycleTimer) { clearInterval(statusCycleTimer); statusCycleTimer = null; }
        }

        // ── AGRINAV menu drawer toggle (same behaviour as dashboard home) ──────────
        (function () {
            const drawer   = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const menuIcon = document.getElementById('menuIcon');
            if (!drawer) return;

            function setDrawer(open) {
                drawer.classList.toggle('open', open);
                backdrop.classList.toggle('active', open);
            }

            menuIcon.addEventListener('click', function (e) {
                e.stopPropagation();
                setDrawer(!drawer.classList.contains('open'));
            });
            const closeBtn = document.getElementById('sidebarCloseBtn');
            if (closeBtn) closeBtn.addEventListener('click', function (e) { e.stopPropagation(); setDrawer(false); });
            backdrop.addEventListener('click', function () { setDrawer(false); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setDrawer(false); });

            // Expandable parent menus (accordion, one open at a time)
            drawer.querySelectorAll('a.parent').forEach(function (parent) {
                parent.addEventListener('click', function (e) {
                    e.preventDefault();
                    const willOpen = !parent.classList.contains('active');
                    drawer.querySelectorAll('a.parent').forEach(function (p) {
                        p.classList.remove('active');
                        const ic = p.querySelector('.toggle-icon');
                        if (ic) ic.classList.remove('open');
                    });
                    if (willOpen) {
                        parent.classList.add('active');
                        const icon = parent.querySelector('.toggle-icon');
                        if (icon) icon.classList.add('open');
                    }
                });
            });
        })();

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            initializeParticles();
            loadSessionHistory();
            setupAutoResize();
            initializeHUDElements();
        });

        // Initialize HUD Elements
        function initializeHUDElements() {
            // Animate progress rings
            animateProgressRings();
            
            // Add random tech line animations
            setInterval(addRandomTechLine, 5000);
            
            // Update energy bar based on activity
            updateEnergyBar();
        }

        function animateProgressRings() {
            const rings = document.querySelectorAll('.progress-ring circle');
            rings.forEach((ring, index) => {
                ring.style.animationDelay = (index * 0.5) + 's';
            });
        }

        function addRandomTechLine() {
            const panel = document.querySelector('.chat-panel');
            if (!panel) return;
            
            const techLine = document.createElement('div');
            techLine.className = 'tech-line horizontal';
            techLine.style.top = Math.random() * 100 + '%';
            techLine.style.opacity = '0.3';
            
            panel.appendChild(techLine);
            
            setTimeout(() => {
                techLine.remove();
            }, 3000);
        }

        function updateEnergyBar() {
            const energyBar = document.querySelector('.energy-bar::before');
            // This will be updated based on AI processing status
            setInterval(() => {
                if (isProcessing) {
                    document.querySelectorAll('.energy-bar').forEach(bar => {
                        bar.style.opacity = '1';
                    });
                } else {
                    document.querySelectorAll('.energy-bar').forEach(bar => {
                        bar.style.opacity = '0.5';
                    });
                }
            }, 100);
        }

        // Create particles animation
        function initializeParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Session Management
        // Switching sessions while an answer streams would write it into the wrong session.
        function guardSessionSwitch() {
            if (isProcessing) {
                showToast('Tunggu sampai EVA selesai menjawab sebelum berpindah sesi.', 'warn');
                return false;
            }
            return true;
        }

        window.startNewSession = function() {
            if (!guardSessionSwitch()) return;
            currentSessionId = Date.now();
            aiSessionId = '';
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = `
                <div class="message assistant">
                    <div class="message-avatar">
                        <img src="{{ asset('eva-ico.png') }}" alt="EVA">
                    </div>
                    <div class="message-content">
                        👋 Halo! Saya EVA, asisten AI untuk AGRINAV PTPN 1. Saya bisa membantu Anda melalui teks, suara, atau video call. Ada yang bisa saya bantu hari ini?
                    </div>
                </div>
            `;
            saveSession();
        };

        function saveSession() {
            const sessions = JSON.parse(localStorage.getItem('aigr1_sessions') || '{}');
            const messages = getSessionMessages();
            
            sessions[currentSessionId] = {
                id: currentSessionId,
                title: messages.length > 1 ? messages[1].content.slice(0, 30) + '...' : 'Sesi Baru',
                messages: messages,
                aiSessionId: aiSessionId,
                timestamp: Date.now()
            };
            
            localStorage.setItem('aigr1_sessions', JSON.stringify(sessions));
            loadSessionHistory();
        }

        function getSessionMessages() {
            const messagesContainer = document.getElementById('messagesContainer');
            const messages = [];
            
            messagesContainer.querySelectorAll('.message:not(.typing-indicator)').forEach(msg => {
                const isUser = msg.classList.contains('user');
                const el = msg.querySelector('.message-content');
                const content = el.textContent.trim();
                // Assistant messages keep their sanitized rich HTML so tables/charts survive a reload
                messages.push(isUser ? { content, isUser } : { content, html: el.innerHTML, isUser });
            });
            
            return messages;
        }

        function loadSessionHistory() {
            const sessions = JSON.parse(localStorage.getItem('aigr1_sessions') || '{}');
            const historyContainer = document.getElementById('sessionHistory');
            
            historyContainer.innerHTML = '';
            
            Object.values(sessions)
                .sort((a, b) => b.timestamp - a.timestamp)
                .forEach(session => {
                    const sessionItem = document.createElement('div');
                    sessionItem.className = 'session-item' + (session.id === currentSessionId ? ' active' : '');
                    sessionItem.innerHTML = `
                        <div class="session-title">${escapeHtml(session.title)}</div>
                        <div class="session-actions">
                            <button class="session-btn" onclick="loadSession(${session.id})" title="Buka sesi" aria-label="Buka sesi">↻</button>
                            <button class="session-btn" onclick="deleteSession(${session.id})" title="Hapus sesi" aria-label="Hapus sesi">🗑</button>
                        </div>
                    `;
                    historyContainer.appendChild(sessionItem);
                });
        }

        window.loadSession = function(sessionId) {
            const sessions = JSON.parse(localStorage.getItem('aigr1_sessions') || '{}');
            const session = sessions[sessionId];
            if (sessionId === currentSessionId) return;
            if (!guardSessionSwitch()) return;
            
            if (session) {
                currentSessionId = sessionId;
                const messagesContainer = document.getElementById('messagesContainer');
                messagesContainer.innerHTML = '';
                
                aiSessionId = session.aiSessionId || '';
                session.messages.forEach(msg => {
                    if (msg.isUser) {
                        addMessage(msg.content, true);
                    } else {
                        const el = addMessage('');
                        const safe = msg.html ? sanitizeHtml(msg.html) : null;
                        setBotHtml(el, safe != null ? safe : formatBotHtml(msg.content));
                    }
                });
                
                loadSessionHistory();
            }
        };

        window.deleteSession = function(sessionId) {
            if (sessionId === currentSessionId && !guardSessionSwitch()) return;
            if (confirm('Hapus sesi ini? Riwayat percakapannya tidak bisa dikembalikan.')) {
                const sessions = JSON.parse(localStorage.getItem('aigr1_sessions') || '{}');
                delete sessions[sessionId];
                localStorage.setItem('aigr1_sessions', JSON.stringify(sessions));
                
                if (sessionId === currentSessionId) {
                    startNewSession();
                }
                
                loadSessionHistory();
            }
        };

        // Input Mode Management
        // Voice and video both use the Anam call (Anam transcribes speech); text mode never ends a live call implicitly.
        window.setInputMode = function(mode) {
            if (mode === 'text') {
                markInputMode('text');
                document.getElementById('messageInput').focus();
                if (callState === 'active') showToast('Video call tetap aktif. Pesan ketikan juga akan dijawab EVA dengan suara.', 'info');
                return;
            }
            if (callState === 'connecting') { showToast('Sedang menghubungkan, mohon tunggu...', 'info'); return; }
            if (callState === 'active') { markInputMode(mode); showToast('Panggilan sudah aktif. Silakan langsung berbicara.', 'info'); return; }
            markInputMode(mode);
            if (mode === 'voice') showToast('Mode suara memakai panggilan EVA. Silakan izinkan mikrofon bila diminta.', 'info');
            startVideoCall();
        };

        // Message Handling
        function addMessage(content, isUser = false) {
            const messagesContainer = document.getElementById('messagesContainer');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message ' + (isUser ? 'user' : 'assistant');
            
            const avatarHtml = isUser 
                ? '<div class="message-avatar">👤</div>'
                : '<div class="message-avatar"><img src="{{ asset('eva-ico.png') }}" alt="EVO"></div>';
            
            messageDiv.innerHTML = `
                ${avatarHtml}
                <div class="message-content">${isUser ? escapeHtml(content).replace(/\n/g, '<br>') : content}</div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            return messageDiv.querySelector('.message-content');
        }

        function addTypingIndicator() {
            const messagesContainer = document.getElementById('messagesContainer');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message assistant typing-indicator';
            typingDiv.innerHTML = `
                <div class="message-avatar"><img src="{{ asset('eva-ico.png') }}" alt="EVO"></div>
                <div class="typing-indicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            `;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            return typingDiv;
        }

        window.sendMessage = async function() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (!message) { messageInput.focus(); return; }
            // During a call a typed message supersedes the running voice turn; otherwise wait for the answer.
            if (isProcessing && callState !== 'active') {
                showToast('EVA masih menyiapkan jawaban sebelumnya, mohon tunggu.', 'info');
                return;
            }

            // Video call active → typed text is a conversational turn for the avatar too.
            const canAnamText = isVideoCallActive && anamClient &&
                (brainMode === 'ai-be' || typeof anamClient.sendUserMessage === 'function');
            if (canAnamText) {
                messageInput.value = '';
                messageInput.style.height = 'auto';
                if (brainMode === 'ai-be') {
                    runVoiceTurn(message);                       // ai-be answers, avatar speaks
                } else {
                    addMessage(message, true);
                    anamClient.sendUserMessage(message);         // Anam's own brain answers
                }
                return;
            }

            setProcessing(true);
            messageInput.value = '';
            messageInput.style.height = 'auto';

            addMessage(message, true);
            const bubble = addMessage('<span class="thinking-label">🧠 Sedang berpikir...</span>');

            let queued = false;      // a render has been scheduled (sync flag)
            let rendered = false;    // a render actually displayed content
            let streamed = '';
            let errorMsg = '';
            let renderChain = Promise.resolve();

            const setStatus = (label) => {
                if (queued) return;   // never overwrite an answer that is already on screen
                bubble.innerHTML = '<span class="thinking-label">' + escapeHtml(label) + '</span>';
                scrollChatToBottom();
            };
            const render = (payload) => {
                queued = true;
                renderChain = renderChain
                    .then(() => renderBotContent(bubble, payload))
                    .then((ok) => { if (ok) rendered = true; })
                    .catch(err => console.error('Render error:', err));
            };

            try {
                // Same SSE contract as the dashboard chatbot: thinking -> skill_called -> token ->
                // partial_response (text ready) -> done (may add charts / contentBlocks).
                await streamAiTurn(message, undefined, false, (event, data) => {
                    switch (event) {
                        case 'thinking':
                            if (data && data.message) setStatus('🧠 ' + data.message);
                            break;

                        case 'skill_called': {
                            const isChart = data.skill === 'generate_chart_image';
                            const label = data.label || (isChart ? 'membuat visualisasi' : 'mengambil data');
                            if (!queued) setStatus((isChart ? '📊 ' : '⚙️ ') + label + '...');
                            else if (isChart) showChartHint(bubble, '📊 ' + label);
                            break;
                        }

                        case 'token':
                            // Plain text preview only; full markdown/chart render happens once on partial/done.
                            streamed += (data && data.token) || '';
                            if (!queued && !looksLikePlanningJson(streamed)) {
                                bubble.textContent = streamed;
                                scrollChatToBottom();
                            }
                            break;

                        case 'partial_response':
                        case 'done': {
                            const r = data && data.response;
                            const content = r && r.message && r.message.content;
                            const blocks = (r && Array.isArray(r.contentBlocks) && r.contentBlocks.length) ? r.contentBlocks : null;
                            const imageUrl = (r && r.images && r.images.output) || null;
                            if (event === 'done' && queued && !blocks && !imageUrl) break;   // nothing new
                            if (content || blocks) render({ text: content, blocks, imageUrl });
                            break;
                        }

                        case 'error':
                            errorMsg = (data && (data.error || data.message)) || 'layanan AI tidak merespons';
                            break;
                    }
                });

                await renderChain;

                if (!rendered) {
                    if (streamed && !looksLikePlanningJson(streamed)) {
                        await renderBotContent(bubble, { text: streamed });
                    } else if (errorMsg) {
                        console.warn('AI error detail:', errorMsg);   // raw backend text stays in the console (often English/technical)
                        bubble.innerHTML = '<span class="msg-error">Maaf, layanan AI sedang mengalami kendala. Silakan coba lagi beberapa saat lagi.</span>';
                    } else {
                        bubble.innerHTML = '<span class="msg-warn">Maaf, saya belum berhasil mengambil datanya untuk pertanyaan itu. Coba ulangi atau perjelas pertanyaannya ya.</span>';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                bubble.innerHTML = '<span class="msg-error">Maaf, terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi.</span>';
            } finally {
                const hint = bubble.querySelector('.chart-generating-hint');
                if (hint) hint.remove();
                setProcessing(false);
                saveSession();
            }
        };

        window.handleKeyPress = function(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        };

        // Auto-resize textarea
        function setupAutoResize() {
            const messageInput = document.getElementById('messageInput');
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 100) + 'px';
            });
        }

        // ── ai-be voice brain helpers ──────────────────────────────────────────────────────
        function escapeHtml(s) {
            return String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        }

        function formatBotHtml(text) {
            return escapeHtml(text)
                .replace(/【\d+:\d+†source】/g, '')
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\n/g, '<br>');
        }

        // ── Rich content pipeline (shared with the dashboard chatbot) ────────────────────────────────
        // Contract from ai-be (see AIResponse): message.content (markdown), optional contentBlocks
        // (ordered text/chart), optional images.output (single chart), metadata.spokenText (voice only).
        const contentRenderer = (typeof window.ChatContentRenderer === 'function') ? new window.ChatContentRenderer() : null;
        const CITATION_RE = /【\d+:\d+†source】/g;

        function scrollChatToBottom() {
            const c = document.getElementById('messagesContainer');
            c.scrollTop = c.scrollHeight;
        }

        function captureAiSessionId(data) {
            const sid = data && (data.sessionId || (data.response && data.response.sessionId));
            if (sid) aiSessionId = String(sid);
        }

        function looksLikePlanningJson(s) {
            const t = String(s || '').trim();
            return t.startsWith('{') && t.includes('"answer"');
        }

        // The model sometimes returns its internal planning JSON ({"dataSourcesToFetch":..,"answer":..}).
        // Never show that raw: take `answer` (also salvaging truncated JSON), or '' when there is none.
        function unwrapPlanningJson(text) {
            if (typeof text !== 'string') return '';
            const t = text.trim();
            if (!looksLikePlanningJson(t)) return text;
            try {
                const obj = JSON.parse(t);
                if (obj && Object.prototype.hasOwnProperty.call(obj, 'answer')) {
                    return (typeof obj.answer === 'string' && obj.answer.trim()) ? obj.answer : '';
                }
                return text;
            } catch (_) {
                if (/"answer"\s*:\s*null/.test(t)) return '';
                const m = t.match(/"answer"\s*:\s*"((?:[^"\\]|\\[\s\S])*)/);
                if (m) {
                    try { return JSON.parse('"' + m[1] + '"'); }
                    catch (_e) { return m[1].replace(/\\n/g, '\n').replace(/\\"/g, '"').replace(/\\\\/g, '\\'); }
                }
                return text;
            }
        }

        // AI/n8n output is untrusted HTML once markdown-parsed -> always sanitize before innerHTML.
        // Returns null when DOMPurify is unavailable so callers fall back to escaped plain text.
        function sanitizeHtml(html) {
            if (!window.DOMPurify) return null;
            return window.DOMPurify.sanitize(html, {
                FORBID_TAGS: ['style', 'iframe', 'form', 'input', 'button', 'textarea', 'select'],
                FORBID_ATTR: ['style']
            });
        }

        function isSafeImageUrl(u) {
            return typeof u === 'string' && /^(https?:\/\/|\/(?!\/))/i.test(u);
        }

        // Post-process a live bubble: links in new tab, tables scrollable, images lazy + safe + error fallback.
        function enhanceRichNode(root) {
            root.querySelectorAll('a[href]').forEach(a => { a.target = '_blank'; a.rel = 'noopener noreferrer'; });
            root.querySelectorAll('table').forEach(t => {
                if (t.parentElement && t.parentElement.classList.contains('table-wrap')) return;
                const w = document.createElement('div');
                w.className = 'table-wrap';
                t.parentNode.insertBefore(w, t);
                w.appendChild(t);
            });
            root.querySelectorAll('img').forEach(img => {
                if (!isSafeImageUrl(img.getAttribute('src'))) { img.remove(); return; }
                img.loading = 'lazy';
                img.referrerPolicy = 'no-referrer';
                img.addEventListener('error', () => {
                    const msg = document.createElement('span');
                    msg.className = 'img-error';
                    msg.textContent = 'Gambar tidak dapat dimuat';
                    img.replaceWith(msg);
                }, { once: true });
                img.addEventListener('load', scrollChatToBottom, { once: true });
            });
            root.classList.toggle('has-media', !!root.querySelector('img'));
        }

        function setBotHtml(el, html) {
            el.innerHTML = html;
            enhanceRichNode(el);
            scrollChatToBottom();
        }

        function blocksFallbackHtml(blocks) {
            return blocks.map(b => {
                if (b.type === 'text') return '<p>' + formatBotHtml(b.text || '') + '</p>';
                if (b.type === 'chart' && isSafeImageUrl(b.imageUrl)) {
                    return '<div class="ai-generated-image"><img src="' + escapeHtml(b.imageUrl) + '" alt="' + escapeHtml(b.caption || 'Chart') + '">' +
                        (b.caption ? '<div class="chart-caption">' + escapeHtml(b.caption) + '</div>' : '') + '</div>';
                }
                return '';
            }).join('');
        }

        /**
         * Render an ai-be answer into a bubble. Preference order (per ai-be contract):
         *  1. contentBlocks  -> ordered text + charts woven together
         *  2. message.content (markdown) + images.output (single chart appended)
         * Returns true when something was displayed.
         */
        async function renderBotContent(el, { text = '', blocks = null, imageUrl = null } = {}) {
            const cleanText = unwrapPlanningJson(String(text || '')).replace(CITATION_RE, '');
            const hasBlocks = Array.isArray(blocks) && blocks.length > 0;
            if (!cleanText.trim() && !hasBlocks) {
                el.innerHTML = '<span class="msg-warn">Maaf, saya belum berhasil mendapatkan jawabannya. Coba ulangi atau perjelas pertanyaannya ya.</span>';
                return false;
            }

            const imgHtml = (!hasBlocks && isSafeImageUrl(imageUrl))
                ? '<div class="ai-generated-image"><img src="' + escapeHtml(imageUrl) + '" alt="Chart/Visualisasi dari AI"></div>' : '';

            let html = null;
            try {
                if (contentRenderer && window.DOMPurify) {
                    const raw = hasBlocks
                        ? await contentRenderer.renderContentBlocks(blocks)
                        : await contentRenderer.renderContent(cleanText) + imgHtml;
                    html = sanitizeHtml(raw);
                }
            } catch (err) {
                console.warn('Rich render failed, using plain fallback:', err);
                html = null;
            }
            if (html == null || !String(html).trim()) {
                html = (hasBlocks ? blocksFallbackHtml(blocks) : formatBotHtml(cleanText)) + imgHtml;
            }
            setBotHtml(el, html);
            return true;
        }

        function showChartHint(el, label) {
            if (el.querySelector('.chart-generating-hint')) return;
            const h = document.createElement('div');
            h.className = 'chart-generating-hint';
            h.textContent = label + '...';
            el.appendChild(h);
            scrollChatToBottom();
        }

        function openLightbox(src, alt) {
            const ov = document.createElement('div');
            ov.className = 'img-lightbox';
            const big = document.createElement('img');
            big.src = src;
            big.alt = alt || '';
            ov.appendChild(big);
            const onKey = (e) => { if (e.key === 'Escape') close(); };
            const close = () => { ov.remove(); document.removeEventListener('keydown', onKey); };
            ov.addEventListener('click', close);
            document.addEventListener('keydown', onKey);
            document.body.appendChild(ov);
        }
        document.getElementById('messagesContainer').addEventListener('click', (e) => {
            const img = e.target.closest && e.target.closest('.message.assistant .message-content img');
            if (img) openLightbox(img.currentSrc || img.src, img.alt);
        });

        // Client-side fallback in case the backend did not send metadata.spokenText.
        function toSpeakable(text) {
            let t = unwrapPlanningJson(String(text || '')).replace(CITATION_RE, '');

            // Drop image markdown (charts are visible on screen, not read)
            t = t.replace(/!\[[^\]]*\]\([^)]*\)/g, ' ');
            // Drop link URLs, keep label
            t = t.replace(/\[([^\]]+)\]\([^)]*\)/g, '$1');
            t = t.replace(/https?:\/\/\S+/gi, ' ');

            // Convert markdown tables into a natural conversational summary notice
            if (/\|[^\n]+\|\s*\n\s*\|[-: |]+\|/m.test(t)) {
                t = t.replace(/(?:^|\n)\|[^\n]+\|(?:\n\|[^\n]+\|)+/g, '\nDetail tabel lengkapnya sudah saya tampilkan di layar chat.\n');
            }

            // Remove code blocks and inline code
            t = t.replace(/```[\s\S]*?```/g, ' ');
            t = t.replace(/`([^`]*)`/g, '$1');

            // Strip headings, bold, italic, strikethrough, blockquotes
            t = t.replace(/^#{1,6}\s*/gm, '');
            t = t.replace(/^>\s*/gm, '');
            t = t.replace(/(\*{1,2}|_{1,2}|~~)/g, '');
            t = t.replace(/[`#~]/g, ' ');

            // Strip emoji / symbols
            t = t.replace(/[\p{Extended_Pictographic}\uFE0F\u200D\u20E3]/gu, '');

            // Bullet & numbered lists flow smoothly as spoken pauses
            t = t.replace(/:\s*\n\s*[-•*]\s+/g, ': ');
            t = t.replace(/\n\s*[-•*]\s+/g, ', ');
            t = t.replace(/^\s*[-•*]\s+/gm, '');
            t = t.replace(/^\s*\d+[.)]\s+/gm, ', ');

            // Normalize linebreaks to sentence pauses
            t = t.replace(/\s*\n+\s*/g, '. ');
            t = t.replace(/\s{2,}/g, ' ');
            t = t.replace(/([.!?,:])\s*[.,]/g, '$1');
            t = t.replace(/^[,.\s]+/, '').trim();

            // Intelligent truncation: cut at a natural sentence boundary (<= 380 chars)
            if (t.length > 380) {
                const cut = t.slice(0, 380);
                const lastDot = Math.max(cut.lastIndexOf('. '), cut.lastIndexOf('! '), cut.lastIndexOf('? '));
                if (lastDot > 90) {
                    t = cut.slice(0, lastDot + 1) + ' Detail lengkapnya sudah saya tampilkan di layar chat.';
                } else {
                    t = cut.replace(/\s+\S*$/, '') + '. Detail selengkapnya dapat Anda lihat di layar chat.';
                }
            }
            return t;
        }

        // TTS reads symbols literally ("Pak/Bu" -> "pak garis miring bu"). Rewrite them into spoken Indonesian.
        // Applied to EVERY utterance, including backend metadata.spokenText.
        function normalizeForSpeech(text) {
            return String(text || '')
                // Sapaan / Panggilan
                .replace(/\b(Bapak|Pak)\s*\/\s*(Ibu|Bu)\b/gi, 'Bapak atau Ibu')
                .replace(/\b(Ibu|Bu)\s*\/\s*(Bapak|Pak)\b/gi, 'Ibu atau Bapak')

                // PTPN & Terminologi Korporat
                .replace(/\bPTPN\s*(1|I)\b/gi, 'PTPN Satu')
                .replace(/\bPTPN\s*(2|II)\b/gi, 'PTPN Dua')
                .replace(/\bPTPN\s*(3|III)\b/gi, 'PTPN Tiga')
                .replace(/\bPTPN\s*(4|IV)\b/gi, 'PTPN Empat')
                .replace(/\bPTPN\s*(5|V)\b/gi, 'PTPN Lima')
                .replace(/\bRKAP\b/gi, 'R-K-A-P')
                .replace(/\bSDM\b/gi, 'S-D-M')
                .replace(/\bHGU\b/gi, 'H-G-U')
                .replace(/\bDRC\b/gi, 'D-R-C')
                .replace(/\bTM\b/g, 'Tanaman Menghasilkan')
                .replace(/\bTBM\b/g, 'Tanaman Belum Menghasilkan')

                // Mata Uang
                .replace(/\bRp\.?\s*([\d.,]+)\s*(T|triliun)\b/gi, '$1 triliun rupiah')
                .replace(/\bRp\.?\s*([\d.,]+)\s*(M|miliar)\b/gi, '$1 miliar rupiah')
                .replace(/\bRp\.?\s*([\d.,]+)\s*(Jt|juta)\b/gi, '$1 juta rupiah')
                .replace(/\bRp\.?\s*([\d.,]+)\s*(Rb|ribu)\b/gi, '$1 ribu rupiah')
                .replace(/\bRp\.?\s*([\d.,]+)/gi, '$1 rupiah')

                // Satuan & Angka
                .replace(/(-?\d[\d.,]*)\s*T\b/g, '$1 triliun')
                .replace(/(-?\d[\d.,]*)\s*M\b/g, '$1 miliar')
                .replace(/(-?\d[\d.,]*)\s*(Jt|jt)\b/g, '$1 juta')
                .replace(/(^|[\s(:])-(\d)/g, '$1minus $2')
                .replace(/(\d+)\s*%/g, '$1 persen')
                .replace(/\s*\/\s*(ha|Ha|HA)\b/g, ' per hektar')
                .replace(/\b(ha|Ha|HA)\b/g, 'hektar')
                .replace(/\bkg\b/gi, 'kilogram')
                .replace(/\bton\b/gi, 'ton')
                .replace(/\s*\/\s*(hari|minggu|bulan|tahun|jam|kg|ton|liter|orang)\b/gi, ' per $1')

                // Perbandingan & Singkatan
                .replace(/\bYoY\b/g, 'dibanding tahun lalu')
                .replace(/\bMoM\b/g, 'dibanding bulan lalu')
                .replace(/\bvs\.?\b/gi, 'dibanding')
                .replace(/\bdll\.?/gi, 'dan lain-lain')
                .replace(/\bdsb\.?/gi, 'dan sebagainya')
                .replace(/\byg\b/gi, 'yang')
                .replace(/\btdk\b/gi, 'tidak')
                .replace(/\bdgn\b/gi, 'dengan')
                .replace(/\bjml\b/gi, 'jumlah')
                .replace(/\bprod\b/gi, 'produksi')
                .replace(/\s*&\s*/g, ' dan ')
                .replace(/([A-Za-z\u00C0-\u024F]+)\s*\/\s*(?=[A-Za-z\u00C0-\u024F])/g, '$1 atau ')

                // Bersihkan karakter teknis
                .replace(/\//g, ' ')
                .replace(/[()\[\]{}"]/g, ' ')
                .replace(/\s+([,.!?])/g, '$1')
                .replace(/\s{2,}/g, ' ')
                .trim();
        }

        // Split into natural phrases WITHOUT breaking decimals ("3,5" / "1.250") or abbreviations,
        // then merge short sentences so the TTS keeps a continuous prosody instead of word-by-word chops.
        function chunkForSpeech(text, minLen = 80) {
            const parts = text.split(/(?<=[.!?])\s+(?=[A-Z\u00C0-\u00DD0-9"'])/);
            const chunks = [];
            let buf = '';
            for (const p of parts) {
                buf = buf ? buf + ' ' + p : p;
                if (buf.length >= minLen) { chunks.push(buf); buf = ''; }
            }
            if (buf) chunks.push(buf);
            return chunks.length ? chunks : [text];
        }

                // Stream text to the avatar in phrase-sized chunks with talk() fallback and smart voice barge-in.
        async function speakViaAnam(text) {
            if (!anamClient || !text) return;
            const spoken = normalizeForSpeech(text);
            if (!spoken || !spoken.trim()) return;

            // Track speech & text for smart barge-in echo filtering (mic stays active so user can interrupt)
            isEvaSpeaking = true;
            currentSpokenText = spoken.toLowerCase();
            stopStatusCycle();
            const videoStatus = document.getElementById('videoStatus');
            if (videoStatus) videoStatus.textContent = 'Berbicara...';

            let spokenOk = false;
            const chunks = chunkForSpeech(spoken);

            // 1. Try streaming chunks via TalkMessageStream
            try {
                const stream = anamClient.createTalkMessageStream();
                activeTalkStream = stream;
                for (let i = 0; i < chunks.length; i++) {
                    if (!isEvaSpeaking) {
                        console.log('[Anam Barge-in] Speech interrupted by user during stream');
                        break;
                    }
                    if (stream.isActive()) {
                        await stream.streamMessageChunk(chunks[i] + ' ', i === chunks.length - 1);
                    }
                }
                spokenOk = true;
                console.log('[Anam] Streamed speech chunks successfully (' + chunks.length + ' chunks)');
            } catch (err) {
                console.warn('[Anam] createTalkMessageStream error, falling back to talk():', err);
            }

            // 2. Fallback to direct talk() if stream failed or was inactive
            if (!spokenOk && isEvaSpeaking && typeof anamClient.talk === 'function') {
                try {
                    await anamClient.talk(spoken);
                    spokenOk = true;
                    console.log('[Anam] Spoke via talk() fallback');
                } catch (talkErr) {
                    console.error('[Anam] talk() fallback also failed:', talkErr);
                }
            }

            // 3. Duration timer: return to "Mendengarkan..." once speech playback completes
            const durationMs = Math.max(2200, Math.min(28000, Math.round((spoken.length / 13) * 1000) + 1000));
            clearTimeout(evaSpeakingTimer);
            evaSpeakingTimer = setTimeout(() => {
                isEvaSpeaking = false;
                currentSpokenText = '';
                if (callState === 'active') {
                    if (videoStatus) videoStatus.textContent = 'Mendengarkan...';
                }
            }, durationMs);
        }

        function handleSseBlock(raw, onEvent) {
            let event = 'message';
            const dataLines = [];
            raw.split(/\r?\n/).forEach(line => {
                if (!line || line.startsWith(':')) return;           // heartbeat / comment
                if (line.startsWith('event:')) event = line.slice(6).trim();
                else if (line.startsWith('data:')) dataLines.push(line.slice(5).trim());
            });
            if (!dataLines.length) return;
            const dataStr = dataLines.join('\n');
            if (dataStr === '[DONE]') return;
            let data;
            try { data = JSON.parse(dataStr); } catch (e) { return; }
            if (event === 'message' && data && data.type) event = data.type;   // Laravel-originated errors
            onEvent(event, data);
        }

        // ── Direct-to-AI-backend (skips the Laravel proxy hop) ─────────────────────
        // Laravel only mints a short-lived JWT (/ai/token); chat + SSE then go straight to ai-be.
        // If the direct path is unreachable (network/CORS), we silently fall back to /ai/response.
        const aiDirectBoot = {!! json_encode($aiDirectBoot ?? null, JSON_UNESCAPED_SLASHES) !!};
        let aiDirect = {
            token: aiDirectBoot ? aiDirectBoot.token : null,
            expiresAt: aiDirectBoot ? aiDirectBoot.expiresAt : 0,
            url: aiDirectBoot ? aiDirectBoot.url : null,
            pending: null,
            disabled: false
        };

        async function getAiDirectToken(force = false) {
            const nowSec = Math.floor(Date.now() / 1000);
            if (!force && aiDirect.token && aiDirect.expiresAt - nowSec > 300) return aiDirect;
            if (aiDirect.pending && !force) return aiDirect.pending;
            aiDirect.pending = (async () => {
                try {
                    const r = await fetch('/ai/token' + (force ? '?refresh=1' : ''), {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    });
                    if (!r.ok) throw new Error('token HTTP ' + r.status);
                    const j = await r.json();
                    if (!j.token || !j.url) throw new Error('token payload invalid');
                    aiDirect.token = j.token;
                    aiDirect.expiresAt = j.expiresAt || (nowSec + 3600);
                    aiDirect.url = j.url;
                    return aiDirect;
                } finally {
                    aiDirect.pending = null;
                }
            })();
            return aiDirect.pending;
        }

        // Pre-warm so the first question doesn't pay the token round-trip (nor the CORS preflight).
        getAiDirectToken().catch(() => { aiDirect.disabled = false; });

        async function openAiStream(text, signal, voice, agentName, sourcePlatform) {
            const viaProxy = () => fetch('/ai/response', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/event-stream'
                },
                body: JSON.stringify({
                    message: text,
                    sessionId: aiSessionId || undefined,
                    stream: true,
                    voice: !!voice,
                    agent: { name: agentName },
                    source: sourcePlatform
                }),
                signal
            });

            if (aiDirect.disabled) return viaProxy();

            const viaDirect = async (force) => {
                const t = await getAiDirectToken(force);
                return fetch(t.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'text/event-stream',
                        'Authorization': 'Bearer ' + t.token
                    },
                    body: JSON.stringify({
                        message: text,
                        sessionId: aiSessionId || undefined,
                        stream: true,
                        agent: { name: agentName },
                        token: t.token,
                        source: sourcePlatform
                    }),
                    signal
                });
            };

            try {
                let res = await viaDirect(false);
                if (res.status === 401 || res.status === 403) res = await viaDirect(true);   // expired token → refresh once
                return res;
            } catch (e) {
                if (e && e.name === 'AbortError') throw e;
                console.warn('Direct AI call failed, falling back to proxy:', e);
                aiDirect.disabled = true;          // don't retry the broken path on every turn
                return viaProxy();
            }
        }

        async function streamAiTurn(text, signal, voice, onEvent) {
            const handle = (event, data) => { captureAiSessionId(data); onEvent(event, data); };
            // Routing eksplisit: mode suara/video → agrinav_voice_agent, mode teks → agrinav_agent
            const agentName  = voice ? 'agrinav_voice_agent' : 'agrinav_agent';
            const sourcePlatform = voice ? 'voice' : 'web';
            const response = await openAiStream(text, signal, voice, agentName, sourcePlatform);

            if (!response.ok || !response.body) throw new Error('HTTP ' + response.status);

            const reader = response.body.getReader();
            const decoder = new TextDecoder();
            let buffer = '';
            while (true) {
                const { value, done } = await reader.read();
                if (done) break;
                buffer += decoder.decode(value, { stream: true });
                let idx;
                while ((idx = buffer.search(/\r?\n\r?\n/)) !== -1) {
                    const block = buffer.slice(0, idx);
                    buffer = buffer.slice(idx).replace(/^\r?\n\r?\n/, '');
                    handleSseBlock(block, handle);
                }
            }
            if (buffer.trim()) handleSseBlock(buffer, handle);
        }

        // One conversational turn: user speech (transcribed by Anam) → ai-be → avatar speech + chat bubble.
        async function runVoiceTurn(text) {
            // Instant barge-in: If avatar is speaking, stop immediately so user feels in full control
            if (isEvaSpeaking || (anamClient && activeTalkStream && activeTalkStream.isActive())) {
                try {
                    if (anamClient) anamClient.interruptPersona();
                } catch (e) { console.warn('interruptPersona failed:', e); }
                clearTimeout(evaSpeakingTimer);
                isEvaSpeaking = false;
                currentSpokenText = '';
            }
            }

            // STT sometimes splits one sentence into two turns ("tampilkan dan analisa" + "data keuangan").
            // If the previous turn is still unanswered and very recent, merge instead of asking twice.
            const now = Date.now();
            if (!lastTurn.answered && now - lastTurn.at < TURN_MERGE_WINDOW_MS && lastTurn.text) {
                text = lastTurn.text + ' ' + text;
                const users = document.querySelectorAll('#messagesContainer .message.user');
                const prev = users[users.length - 1];
                if (prev) prev.remove();
            }
            const turnRef = { text, at: now, answered: false };
            lastTurn = turnRef;

            const seq = ++voiceTurnSeq;
            if (voiceAbort) voiceAbort.abort();            // a newer utterance supersedes the old turn
            voiceAbort = new AbortController();
            const videoStatus = document.getElementById('videoStatus');

            voiceTurnInFlight = true;
            setProcessing(true);
            stopStatusCycle();                             // clear any previous cycle
            document.querySelectorAll('.message.typing-indicator').forEach(el => el.remove());
            addMessage(text, true);
            const typing = addTypingIndicator();

            startStatusCycle(videoStatus);

            let answered = false;
            let chartRendered = false;
            let bubble = null;

            // Natural conversational filler: if data takes >1.3s to fetch from n8n/database,
            // EVA acknowledges warmly with a complete short phrase, keeping flow smooth.
                        const sayFiller = async (pool) => {
                if (answered || !anamClient || seq !== voiceTurnSeq || isEvaSpeaking) return;
                try {
                    const phrase = pickRandom(pool);
                    stopStatusCycle();
                    if (videoStatus) videoStatus.textContent = 'Mengecek data...';
                    const stream = anamClient.createTalkMessageStream();
                    activeTalkStream = stream;
                    isEvaSpeaking = true;
                    currentSpokenText = phrase.toLowerCase();
                    await stream.streamMessageChunk(phrase + ' ', true); // cleanly complete filler
                    clearTimeout(evaSpeakingTimer);
                    evaSpeakingTimer = setTimeout(() => {
                        isEvaSpeaking = false;
                        currentSpokenText = '';
                        if (callState === 'active' && !answered) {
                            startStatusCycle(videoStatus);
                        }
                    }, 2400);
                } catch (e) {
                    console.warn('[Anam] Filler speech failed:', e);
                    isEvaSpeaking = false;
                    currentSpokenText = '';
                }
            };
            const fillerTimer = setTimeout(() => sayFiller(VOICE_FILLER_POOL), VOICE_FILLER_AFTER_MS);
            const stillTimer  = setTimeout(() => sayFiller(VOICE_STILL_WORKING_POOL), VOICE_STILL_WORKING_MS);

            try {
                await streamAiTurn(text, voiceAbort.signal, true, (event, data) => {
                    if (seq !== voiceTurnSeq) return;

                    if (event === 'skill_called') {
                        const isChart = data && data.skill === 'generate_chart_image';
                        stopStatusCycle();
                        videoStatus.textContent = isChart ? 'Membuat grafik...' : 'Mengambil data...';
                    } else if (event === 'partial_response' || event === 'done') {
                        const r = data && data.response;
                        const content = r && r.message && r.message.content;
                        const blocks = (r && Array.isArray(r.contentBlocks) && r.contentBlocks.length) ? r.contentBlocks : null;
                        const imageUrl = (r && r.images && r.images.output) || null;
                        if (!content && !blocks) return;

                        if (!answered) {
                            answered = true;
                            turnRef.answered = true;
                            clearTimeout(fillerTimer);
                            clearTimeout(stillTimer);
                            stopStatusCycle();
                            typing.remove();
                            bubble = addMessage('');
                            chartRendered = !!(blocks || imageUrl);
                            renderBotContent(bubble, { text: content, blocks, imageUrl }).then(saveSession);

                            // Extract spoken text: prioritize backend metadata.spokenText (generated for agrinav_voice_agent),
                            // fallback to client-side toSpeakable(content)
                            const spoken = (r.message && r.message.metadata && r.message.metadata.spokenText) || toSpeakable(content);

                            // Cadence pause: if a filler was actively speaking, wait a moment before delivering the main answer
                            const delay = isEvaSpeaking ? 400 : 0;
                            setTimeout(() => {
                                if (seq === voiceTurnSeq && isVideoCallActive) {
                                    speakViaAnam(spoken).catch(err => console.error('Anam speak error:', err));
                                }
                            }, delay);
                        } else if (!chartRendered && (blocks || imageUrl)) {
                            // Charts arrive with the later `done`: upgrade the same bubble in place.
                            // Never re-speak - the avatar already delivered the spoken answer.
                            chartRendered = true;
                            renderBotContent(bubble, { text: content, blocks, imageUrl }).then(saveSession);
                        }
                    } else if (event === 'error') {
                        throw new Error(data.error || 'layanan AI tidak merespons');
                    }
                });

                if (!answered && seq === voiceTurnSeq) throw new Error('Empty response');
            } catch (error) {
                if (error.name === 'AbortError' || seq !== voiceTurnSeq) return;
                console.error('Voice turn error:', error);
                turnRef.answered = true;
                clearTimeout(fillerTimer);
                clearTimeout(stillTimer);
                stopStatusCycle();
                typing.remove();
                addMessage('⚠️ ' + VOICE_ERROR);
                speakViaAnam(VOICE_ERROR).catch(() => {});
            } finally {
                clearTimeout(fillerTimer);
                clearTimeout(stillTimer);
                stopStatusCycle();
                document.querySelectorAll('.message.typing-indicator').forEach(el => el.remove());
                if (seq === voiceTurnSeq) {
                    voiceTurnInFlight = false;
                    setProcessing(false);
                }
            }
        }

                // Smart Voice Barge-in & Echo Classifier
        function isGenuineUserInterruption(rawTranscript) {
            if (!rawTranscript) return false;
            const text = rawTranscript.trim().toLowerCase();
            if (text.length < 2) return false;

            // Direct interruption keywords & common agricultural query triggers
            const INTERRUPT_KEYWORDS_RE = /\b(stop|tunggu|bentar|sebentar|diam|cukup|batal|interupsi|halo|eva|tanya|mau tanya|ganti|bukan|eh|kenapa|berapa|bagaimana|gimana|apa|apakah|siapa|tolong|coba|tampilkan|lihat|jelaskan|hitung|ptpn|kebun|rkap|drc|sawit|karet|tebu|produksi|biaya|target|realisasi)\b/i;
            if (INTERRUPT_KEYWORDS_RE.test(text)) {
                return true;
            }

            if (!isEvaSpeaking || !currentSpokenText) return true;

            // Echo filter: compare words of incoming transcript against EVA's ongoing speech
            const transcriptWords = text.replace(/[^a-zA-Z0-9\s]/g, '').split(/\s+/).filter(w => w.length > 2);
            if (!transcriptWords.length) return false;

            let matchCount = 0;
            for (const w of transcriptWords) {
                if (currentSpokenText.includes(w)) matchCount++;
            }
            const overlapRatio = matchCount / transcriptWords.length;

            // If words match EVA's speech by >= 65% without command keywords, it's speaker echo
            if (overlapRatio >= 0.65) {
                console.log('[Anam Barge-in] Discarded as speaker echo (overlap ' + Math.round(overlapRatio * 100) + '%):', text);
                return false;
            }

            return true;
        }

        function setupAiBeBrain(anamSdk) {
            // Finished user utterances arrive via history updates
            // ── Trick 6: Smart Voice Barge-in & Echo Classifier ──────────────────────────
            anamClient.addListener(anamSdk.AnamEvent.MESSAGE_HISTORY_UPDATED, (messages) => {
                if (callState !== 'active' || !messages || !messages.length) return;
                const last = messages[messages.length - 1];
                console.log('[Anam] history updated, last:', last.role, JSON.stringify(last.content));
                if (last.role !== 'user' || !last.content || !last.content.trim()) return;
                if (handledUserMessageIds.has(last.id)) return;

                const userText = last.content.trim();

                // Smart Voice Barge-in: If EVA is currently speaking, check if user is interrupting
                if (isEvaSpeaking) {
                    if (!isGenuineUserInterruption(userText)) {
                        handledUserMessageIds.add(last.id);
                        return; // Discard speaker echo
                    }
                    console.log('[Anam Barge-in] Valid user interruption detected:', userText);
                    // Instant interruption: Cut EVA off immediately!
                    try {
                        anamClient.interruptPersona();
                    } catch (e) { console.warn('interruptPersona failed:', e); }
                    clearTimeout(evaSpeakingTimer);
                    isEvaSpeaking = false;
                    currentSpokenText = '';
                    const videoStatus = document.getElementById('videoStatus');
                    if (videoStatus) videoStatus.textContent = 'Mendengarkan...';
                }

                clearTimeout(voiceTurnTimer);
                voiceTurnTimer = setTimeout(() => {
                    if (callState !== 'active' || handledUserMessageIds.has(last.id)) return;
                    handledUserMessageIds.add(last.id);
                    runVoiceTurn(userText);
                }, USER_TURN_DEBOUNCE_MS);
            });

            // Status indicator: reflect user speech in HUD only when EVA is not speaking
            anamClient.addListener(anamSdk.AnamEvent.USER_SPEECH_STARTED, () => {
                if (callState !== 'active' || isEvaSpeaking) return;
                stopStatusCycle();
                document.getElementById('videoStatus').textContent = 'Mendengarkan...';
            });

            anamClient.addListener(anamSdk.AnamEvent.MESSAGE_DELIVERY_FAILED, (failure) => {
                console.warn('Anam message delivery failed:', failure);
            });
        }

        function resetVoiceBrain() {
            clearTimeout(voiceTurnTimer);
            voiceTurnTimer = null;
            clearTimeout(evaSpeakingTimer);
            evaSpeakingTimer = null;
            isEvaSpeaking = false;
            currentSpokenText = '';
            stopStatusCycle();
            voiceTurnSeq++;                                // invalidates any in-flight turn
            if (voiceAbort) { voiceAbort.abort(); voiceAbort = null; }
            activeTalkStream = null;
            lastTurn = { text: '', at: 0, answered: true };
            handledUserMessageIds.clear();
            brainMode = 'anam';
            if (voiceTurnInFlight) { voiceTurnInFlight = false; setProcessing(false); }
        }

        // ── UI feedback helpers ───────────────────────────────────────────────────────────
        function showToast(message, type = 'info', duration = 3200) {
            const host = document.getElementById('toastHost');
            if (!host) return;
            const el = document.createElement('div');
            el.className = 'toast toast-' + type;
            el.textContent = message;
            host.appendChild(el);
            while (host.children.length > 3) host.firstChild.remove();
            setTimeout(() => {
                el.classList.add('hide');
                setTimeout(() => el.remove(), 260);
            }, duration);
        }

        // Single place that flips the busy flag so the send button always reflects it.
        // During a call typed messages are allowed to supersede the running turn, so the button stays enabled.
        function setProcessing(value) {
            isProcessing = value;
            const sendBtn = document.getElementById('sendBtn');
            if (sendBtn) {
                sendBtn.disabled = value && !isVideoCallActive;
                sendBtn.classList.toggle('busy', value);
            }
        }

        // ── Call lifecycle (state machine: idle → connecting → active → idle) ───────────────
        let callState = 'idle';
        let callAttempt = 0;               // bumps on every start/cancel/end so stale async steps can bail out
        let callMediaStream = null;        // microphone stream handed to Anam; must be stopped on teardown
        let visibilityHandler = null;      // registered once per call, removed on teardown

        const ICON_PHONE = '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>';
        const ICON_END = '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

        function withTimeout(promise, ms, message) {
            let timer;
            const timeout = new Promise((_, reject) => {
                timer = setTimeout(() => { const e = new Error(message); e.name = 'TimeoutError'; reject(e); }, ms);
            });
            return Promise.race([promise, timeout]).finally(() => clearTimeout(timer));
        }

        function markInputMode(mode) {
            currentInputMode = mode;
            document.querySelectorAll('.mode-btn').forEach(b => b.classList.toggle('active', b.id === mode + 'Mode'));
        }

        function updateControlButtons() {
            const inCall = callState === 'active';
            [['videoToggleSmall', isVideoActive], ['micToggleSmall', isMicActive], ['speakerToggleSmall', isSpeakerActive]].forEach(([id, on]) => {
                const b = document.getElementById(id);
                if (!b) return;
                b.classList.toggle('active', !!on);
                b.classList.toggle('off', inCall && !on);
                b.setAttribute('aria-pressed', on ? 'true' : 'false');
            });
        }

        function renderCallUi() {
            const button = document.getElementById('mainCallButton');
            const label = document.getElementById('callButtonLabel');
            const secondary = document.getElementById('secondaryControls');
            const ui = {
                idle:       { text: 'Ketuk untuk menelepon',                 title: 'Mulai panggilan',       color: 'var(--accent-color)' },
                connecting: { text: 'Menghubungkan... ketuk untuk batal',    title: 'Batalkan panggilan',    color: '#f59e0b' },
                active:     { text: 'Akhiri panggilan',                      title: 'Akhiri panggilan',      color: 'var(--danger-color)' }
            }[callState];
            button.innerHTML = callState === 'idle' ? ICON_PHONE : ICON_END;
            button.classList.toggle('active', callState !== 'idle');
            button.classList.toggle('connecting', callState === 'connecting');
            button.title = ui.title;
            button.setAttribute('aria-label', ui.title);
            label.textContent = ui.text;
            label.style.color = ui.color;
            secondary.style.display = callState === 'active' ? 'flex' : 'none';
            updateControlButtons();
            setProcessing(isProcessing);                    // refresh send button for the new mode
        }

        // Stops everything a call owns. Safe to call repeatedly and from any state.
        function releaseCallResources() {
            if (visibilityHandler) {
                document.removeEventListener('visibilitychange', visibilityHandler);
                visibilityHandler = null;
            }
            const client = anamClient;
            anamClient = null;                              // null first so CONNECTION_CLOSED from our own disconnect is ignored
            if (client) {
                try { Promise.resolve(client.stopStreaming()).catch(() => {}); } catch (e) { console.warn('stopStreaming failed:', e); }
                try { Promise.resolve(client.disconnect()).catch(() => {}); } catch (e) { console.warn('disconnect failed:', e); }
            }
            if (callMediaStream) {
                callMediaStream.getTracks().forEach(t => t.stop());   // releases the mic (browser indicator turns off)
                callMediaStream = null;
            }
            const video = document.getElementById('avatarVideo');
            const placeholder = document.getElementById('avatarPlaceholder');
            if (video) {
                video.pause();
                video.srcObject = null;
                video.style.display = 'none';
                video.style.visibility = 'visible';
            }
            if (placeholder) placeholder.style.display = 'block';
            isMicActive = false;
            isVideoActive = false;
            isSpeakerActive = false;
        }

        function describeCallError(error) {
            const name = error && error.name;
            if (name === 'NotAllowedError' || name === 'SecurityError') {
                return {
                    status: 'Akses mikrofon ditolak',
                    text: window.isSecureContext
                        ? 'Akses mikrofon ditolak. Klik ikon gembok di address bar → Mikrofon → Izinkan, lalu muat ulang halaman. Anda juga bisa memakai tombol "Cek & Test Mikrofon".'
                        : 'Browser memblokir mikrofon di HTTP biasa. Buka halaman lewat HTTPS atau http://localhost.'
                };
            }
            if (name === 'NotFoundError') {
                return { status: 'Mikrofon tidak ditemukan', text: 'Mikrofon tidak terdeteksi. Hubungkan mikrofon lalu coba lagi, atau gunakan tombol "Cek & Test Mikrofon".' };
            }
            if (name === 'NotReadableError') {
                return { status: 'Mikrofon sedang dipakai', text: 'Mikrofon sedang dipakai aplikasi lain atau diblokir sistem. Tutup aplikasi lain lalu coba lagi.' };
            }
            if (name === 'TimeoutError') {
                const msg = (error && error.message) || '';
                if (/SDK/i.test(msg)) {
                    return { status: 'Gagal memuat SDK', text: 'Library video call (esm.sh) tidak bisa dimuat. Periksa apakah jaringan/firewall memblokir esm.sh, lalu coba lagi.' };
                }
                if (/Streaming/i.test(msg)) {
                    return { status: 'Koneksi video lambat', text: 'Sambungan video ke Anam AI terlalu lama (WebRTC). Jaringan atau firewall mungkin memblokir koneksi real-time (UDP), coba jaringan lain lalu ulangi.' };
                }
                if (/Token/i.test(msg)) {
                    return { status: 'Server lambat', text: 'Server terlalu lama membuat sesi video call. Coba lagi sebentar lagi.' };
                }
                return { status: 'Waktu habis', text: 'Menghubungkan terlalu lama. Periksa koneksi internet Anda lalu coba lagi.' };
            }
            return { status: 'Gagal terhubung', text: 'Video call gagal dimulai. Periksa koneksi internet atau pengaturan Anam AI, lalu coba lagi.' };
        }

        // Video Call Functions (Anam AI Integration)
        window.handleMainCallButton = async function() {
            if (callState === 'idle') {
                markInputMode('video');
                await startVideoCall();
            } else if (callState === 'connecting') {
                cancelConnecting();
            } else {
                endVideoCall();
            }
        };

        function cancelConnecting() {
            callAttempt++;                                  // invalidates the pending startVideoCall
            resetVoiceBrain();
            releaseCallResources();
            callState = 'idle';
            renderCallUi();
            markInputMode('text');
            document.getElementById('videoStatus').textContent = 'Panggilan dibatalkan';
            showToast('Panggilan dibatalkan.', 'info');
            setTimeout(() => { if (callState === 'idle') document.getElementById('videoStatus').textContent = 'Siap'; }, 2000);
        }

        // Anam session token: ai-be first (no PHP in the path), Laravel only as a fallback.
        let anamDirectDisabled = false;     // set when ai-be answers 404 (endpoint not deployed) or is unreachable
        async function fetchAnamSessionToken() {
            if (!anamDirectDisabled && !aiDirect.disabled) {
                const ctrl = new AbortController();
                const abortTimer = setTimeout(() => ctrl.abort(), 12000);   // don't burn the whole budget on a dead path
                try {
                    const post = async (force) => {
                        const t = await getAiDirectToken(force);
                        const base = String(t.url).replace(/\/api\/ai\/chat\/?$/, '');
                        return fetch(base + '/api/anam/session-token', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + t.token },
                            signal: ctrl.signal
                        });
                    };
                    let r = await post(false);
                    if (r.status === 401 || r.status === 403) r = await post(true);   // expired token → refresh once
                    if (r.ok) {
                        const d = await r.json();
                        if (d && d.success && d.sessionToken) { console.log('[Anam] session token via ai-be'); return d; }
                    } else if (r.status === 404 || r.status === 500 || r.status === 502) {
                        anamDirectDisabled = true;      // old ai-be without the endpoint — stop trying this page load
                    }
                    console.warn('[Anam] ai-be token unavailable (HTTP ' + r.status + '), using Laravel fallback');
                } catch (e) {
                    console.warn('[Anam] ai-be token failed, using Laravel fallback:', e && e.message);
                    if (!(e && e.name === 'AbortError')) anamDirectDisabled = true;
                } finally {
                    clearTimeout(abortTimer);
                }
            }

            const tokenResponse = await fetch('/aigri/anam-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            if (!tokenResponse.ok) {
                throw new Error('Failed to get Anam session token (HTTP ' + tokenResponse.status + ')');
            }
            console.log('[Anam] session token via Laravel');
            return tokenResponse.json();
        }

        window.startVideoCall = async function() {
            if (callState !== 'idle') return;                // blocks double-clicks / duplicate sessions

            callState = 'connecting';
            const attempt = ++callAttempt;
            const isStale = () => attempt !== callAttempt;

            const videoStatus = document.getElementById('videoStatus');
            const placeholder = document.getElementById('avatarPlaceholder');
            const video = document.getElementById('avatarVideo');

            renderCallUi();
            videoStatus.textContent = 'Menghubungkan...';

            let stream = null;
            try {
                // Start loading the SDK right away (usually already cached by the idle warm-up),
                // in parallel with the session-token request, instead of one after the other.
                const t0 = performance.now();
                const sdkPromise = withTimeout(loadAnamSdk(), 45000, 'SDK load timeout');
                sdkPromise.catch(() => {});                // surfaced below; avoid an unhandled rejection if the token step fails first

                // Get session token (ai-be directly; Laravel only as fallback)
                const data = await withTimeout(fetchAnamSessionToken(), 30000, 'Token session timeout');
                if (isStale()) return;

                if (!data.success || !data.sessionToken) {
                    throw new Error(data.message || 'Invalid session token');
                }

                // Import Anam AI SDK (already loading / loaded)
                const anamSdk = await sdkPromise;
                console.log('[Anam] token + SDK ready in ' + Math.round(performance.now() - t0) + 'ms');
                if (isStale()) return;

                // Mic API only exists in secure contexts (HTTPS or localhost/127.0.0.1).
                // Accessing via http://<IP-LAN> makes navigator.mediaDevices undefined → browser never prompts.
                if (!window.isSecureContext || !navigator.mediaDevices?.getUserMedia) {
                    const err = new Error('Microphone unavailable in insecure context: ' + location.origin);
                    err.name = 'NotAllowedError';
                    throw err;
                }

                // Request microphone permission explicitly first
                videoStatus.textContent = 'Meminta akses mikrofon...';
                stream = await navigator.mediaDevices.getUserMedia({
                    audio: window.getPreferredMicConstraints(),   // device chosen in Mic Check & Test
                    video: false
                });
                if (isStale()) { stream.getTracks().forEach(t => t.stop()); return; }
                callMediaStream = stream;

                videoStatus.textContent = 'Menyiapkan EVA...';

                // Create Anam client with session token and custom audio stream
                const client = anamSdk.createClient(data.sessionToken, {
                    disableInputAudio: false, // Enable audio input
                });
                anamClient = client;

                // Listen for connection events
                client.addListener(anamSdk.AnamEvent.CONNECTION_ESTABLISHED, () => {
                    console.log('Anam connection established');
                    if (anamClient === client) videoStatus.textContent = 'Terhubung';
                });

                client.addListener(anamSdk.AnamEvent.CONNECTION_CLOSED, (code) => {
                    console.log('Anam connection closed:', code);
                    // Remote drop while the call is live → tear down cleanly instead of leaving a frozen avatar.
                    if (anamClient === client && callState === 'active') {
                        endVideoCall('📞 Koneksi video call terputus.');
                        showToast('Koneksi terputus. Ketuk tombol telepon untuk menyambung lagi.', 'error', 4500);
                    }
                });

                // ai-be brain: Anam only transcribes + renders; answers come from agrinav_voice_agent
                brainMode = data.brainMode || 'anam';
                if (brainMode === 'ai-be') {
                    setupAiBeBrain(anamSdk);
                }

                // Hide placeholder, show video
                placeholder.style.display = 'none';
                video.style.display = 'block';

                // Start streaming with custom media stream to video element
                const tStream = performance.now();
                await withTimeout(client.streamToVideoElement('avatarVideo', stream), 60000, 'Streaming timeout');
                console.log('[Anam] video stream ready in ' + Math.round(performance.now() - tStream) + 'ms');
                if (isStale()) return;

                // Ensure video is unmuted and playing
                video.muted = false;
                video.volume = 1.0;
                await video.play().catch(e => console.log('Video autoplay:', e));

                // Get and display audio state
                const audioState = client.getInputAudioState();
                console.log('Audio state:', audioState);

                if (audioState.permissionState === 'denied') {
                    const err = new Error('Microphone permission denied');
                    err.name = 'NotAllowedError';
                    throw err;
                }

                callState = 'active';
                isVideoCallActive = true;
                isMicActive = true;
                isSpeakerActive = true;
                isVideoActive = true;

                // Browsers pause media in background tabs; resume when the user comes back (registered once per call).
                visibilityHandler = () => {
                    if (!document.hidden && callState === 'active') {
                        const vid = document.getElementById('avatarVideo');
                        if (vid && vid.paused) vid.play().catch(() => {});
                    }
                };
                document.addEventListener('visibilitychange', visibilityHandler);

                videoStatus.textContent = 'Terhubung';
                renderCallUi();

                addMessage('📹 Video call terhubung! Silakan berbicara dengan EVA.', false);
                showToast('Terhubung. Silakan langsung berbicara, tidak perlu mengetik.', 'success');

                if (brainMode === 'ai-be') {
                    // ── Trick 9: Greeting with Listening state ───────────────────────
                    videoStatus.textContent = 'Mendengarkan...';
                    speakViaAnam(VOICE_GREETING)
                        .then(() => { if (callState === 'active') videoStatus.textContent = 'Mendengarkan...'; })
                        .catch(err => console.warn('Greeting failed:', err));
                }

            } catch (error) {
                if (isStale()) return;                       // user cancelled; cancelConnecting already cleaned up
                console.error('Video call error:', error);

                callAttempt++;
                resetVoiceBrain();
                releaseCallResources();                      // also stops the mic stream if it was already opened
                if (stream) stream.getTracks().forEach(t => t.stop());
                callState = 'idle';
                isVideoCallActive = false;
                renderCallUi();
                markInputMode('text');

                const info = describeCallError(error);
                videoStatus.textContent = info.status;
                addMessage('⚠️ ' + info.text, false);
                showToast(info.status, 'error');

                setTimeout(() => {
                    if (callState === 'idle') videoStatus.textContent = 'Siap';
                }, 3000);
            }
        };

        window.endVideoCall = function(message) {
            if (callState !== 'active') return;

            callAttempt++;
            resetVoiceBrain();
            releaseCallResources();
            callState = 'idle';
            isVideoCallActive = false;
            renderCallUi();
            markInputMode('text');

            const videoStatus = document.getElementById('videoStatus');
            videoStatus.textContent = 'Panggilan berakhir';

            // ── Trick 10: Farewell before disconnect ─────────────────────────────
            // A brief goodbye makes the end-of-call feel deliberate, not abrupt.
            // Note: anamClient is already set to null at this point by the caller path,
            // so we only speak if the client reference was captured before the call.
            addMessage(typeof message === 'string' ? message : '📞 Video call berakhir.', false);

            setTimeout(() => {
                if (callState === 'idle') videoStatus.textContent = 'Siap';
            }, 2000);
        };

        // Camera button: the avatar's picture can be hidden while the voice conversation continues.
        window.toggleVideo = function() {
            if (callState !== 'active') { showToast('Mulai panggilan terlebih dahulu.', 'info'); return; }

            isVideoActive = !isVideoActive;
            const video = document.getElementById('avatarVideo');
            if (video) video.style.visibility = isVideoActive ? 'visible' : 'hidden';
            updateControlButtons();
            showToast(isVideoActive ? 'Tampilan avatar diaktifkan.' : 'Tampilan avatar disembunyikan. Suara tetap berjalan.', 'info');
        };

        window.toggleMic = function() {
            if (callState !== 'active' || !anamClient) { showToast('Mulai panggilan terlebih dahulu.', 'info'); return; }

            const next = !isMicActive;
            try {
                // Use Anam API to mute/unmute
                if (next) anamClient.unmuteInputAudio();
                else anamClient.muteInputAudio();
            } catch (e) {
                console.error('Toggle mic failed:', e);
                showToast('Gagal mengubah status mikrofon. Coba lagi.', 'error');
                return;
            }
            isMicActive = next;
            updateControlButtons();
            document.getElementById('videoStatus').textContent = next ? 'Mendengarkan...' : 'Mikrofon dibisukan';
            showToast(next ? 'Mikrofon diaktifkan. EVA mendengarkan Anda.' : 'Mikrofon dibisukan. EVA tidak akan mendengar Anda.', next ? 'success' : 'warn');
        };

        window.toggleSpeaker = function() {
            if (callState !== 'active') { showToast('Mulai panggilan terlebih dahulu.', 'info'); return; }

            isSpeakerActive = !isSpeakerActive;
            const videoElement = document.getElementById('avatarVideo');
            if (videoElement) {
                videoElement.muted = !isSpeakerActive;
                videoElement.volume = isSpeakerActive ? 1.0 : 0;
            }
            updateControlButtons();
            showToast(isSpeakerActive ? 'Suara EVA diaktifkan.' : 'Suara EVA dibisukan. Jawaban tetap tampil di chat.', isSpeakerActive ? 'success' : 'warn');
        };

        // ══════════════════════════════════════════════════════════════════════
        // Microphone Check & Test
        // Diagnoses secure-context / permission / device problems, shows a live
        // input level meter and lets the user record + play back a short sample.
        // The device chosen here is also used by the video call.
        // ══════════════════════════════════════════════════════════════════════
        const MIC_PREF_KEY = 'aigr1_mic_device';
        const MIC_RECORD_MS = 4000;
        const micTest = { stream: null, ctx: null, analyser: null, raf: 0, started: 0, peak: 0, recorder: null, recTimer: 0, audioUrl: null, player: null, permStatus: null };

        window.getPreferredMicConstraints = function() {
            const id = localStorage.getItem(MIC_PREF_KEY);
            const baseConstraints = {
                echoCancellation: { ideal: true },
                noiseSuppression: { ideal: true },
                autoGainControl: { ideal: true }
            };
            return id ? { ...baseConstraints, deviceId: { ideal: id } } : baseConstraints;
        };

        function mtSetCheck(key, state, text) {
            const row = document.querySelector('[data-mt-check="' + key + '"]');
            if (!row) return;
            row.dataset.state = state;                       // idle | ok | warn | err
            row.querySelector('.mt-check-text').textContent = text;
        }

        function mtSetStatus(text) {
            document.getElementById('mtStatus').textContent = text;
        }

        function mtRunStaticChecks() {
            mtSetCheck('secure',
                window.isSecureContext ? 'ok' : 'err',
                window.isSecureContext
                    ? 'Koneksi aman (' + location.origin + ')'
                    : 'Halaman tidak aman (' + location.origin + '). Buka via HTTPS atau http://localhost');
            const supported = !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
            mtSetCheck('support', supported ? 'ok' : 'err',
                supported ? 'Browser mendukung akses mikrofon' : 'Browser/konteks ini tidak menyediakan akses mikrofon');
            return window.isSecureContext && supported;
        }

        async function mtWatchPermission() {
            if (!navigator.permissions || !navigator.permissions.query) {
                mtSetCheck('perm', 'idle', 'Status izin tidak bisa dibaca di browser ini');
                return;
            }
            try {
                const ps = await navigator.permissions.query({ name: 'microphone' });
                micTest.permStatus = ps;
                const render = () => {
                    const map = {
                        granted: ['ok', 'Izin mikrofon diberikan'],
                        prompt: ['warn', 'Izin belum diminta. Klik "Mulai Test" lalu pilih Allow'],
                        denied: ['err', 'Izin DITOLAK. Klik ikon gembok di address bar → Microphone → Allow, lalu reload']
                    };
                    const m = map[ps.state] || ['idle', 'Status: ' + ps.state];
                    mtSetCheck('perm', m[0], m[1]);
                };
                ps.onchange = render;
                render();
            } catch (e) {
                mtSetCheck('perm', 'idle', 'Status izin tidak bisa dibaca di browser ini');
            }
        }

        async function mtRefreshDevices() {
            const select = document.getElementById('mtDevice');
            if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) return;
            const devices = (await navigator.mediaDevices.enumerateDevices()).filter(d => d.kind === 'audioinput');
            const saved = localStorage.getItem(MIC_PREF_KEY);
            select.innerHTML = '';
            if (!devices.length) {
                select.innerHTML = '<option value="">Tidak ada mikrofon terdeteksi</option>';
                mtSetCheck('device', 'err', 'Tidak ada perangkat mikrofon. Pastikan mic terpasang & tidak dinonaktifkan di Windows');
                return;
            }
            devices.forEach((d, i) => {
                const opt = document.createElement('option');
                opt.value = d.deviceId;
                opt.textContent = d.label || ('Microphone ' + (i + 1));
                select.appendChild(opt);
            });
            if (saved && devices.some(d => d.deviceId === saved)) select.value = saved;
            mtSetCheck('device', 'ok', devices.length + ' mikrofon terdeteksi');
        }

        function mtStopStream() {
            cancelAnimationFrame(micTest.raf);
            micTest.raf = 0;
            if (micTest.stream) micTest.stream.getTracks().forEach(t => t.stop());
            micTest.stream = null;
            if (micTest.ctx) micTest.ctx.close().catch(() => {});
            micTest.ctx = null;
            micTest.analyser = null;
        }

        function mtDrawMeter() {
            const a = micTest.analyser;
            if (!a) return;
            const buf = new Float32Array(a.fftSize);
            a.getFloatTimeDomainData(buf);
            let sum = 0;
            for (let i = 0; i < buf.length; i++) sum += buf[i] * buf[i];
            const rms = Math.sqrt(sum / buf.length);
            const db = rms > 0 ? 20 * Math.log10(rms) : -100;
            const pct = Math.max(0, Math.min(1, (db + 60) / 60));
            micTest.peak = Math.max(micTest.peak, rms);

            document.getElementById('mtMeterFill').style.width = (pct * 100).toFixed(1) + '%';
            document.getElementById('mtMeterDb').textContent = (db > -99 ? db.toFixed(0) : '-∞') + ' dB';

            // After 3s with no signal, tell the user instead of leaving them guessing.
            if (Date.now() - micTest.started > 3000) {
                if (micTest.peak < 0.01) {
                    mtSetCheck('signal', 'warn', 'Belum ada suara terdeteksi. Coba bicara, atau cek mute fisik / pilihan perangkat');
                } else {
                    mtSetCheck('signal', 'ok', 'Suara terdeteksi. Mikrofon berfungsi');
                }
            }
            micTest.raf = requestAnimationFrame(mtDrawMeter);
        }

        window.micTestStart = async function() {
            if (!mtRunStaticChecks()) {
                mtSetStatus('Perbaiki masalah di checklist terlebih dahulu.');
                return;
            }
            mtStopStream();
            const select = document.getElementById('mtDevice');
            const id = select.value;
            mtSetStatus('Meminta akses mikrofon...');
            try {
                micTest.stream = await navigator.mediaDevices.getUserMedia({
                    audio: id ? { deviceId: { exact: id } } : true,
                    video: false
                });
            } catch (err) {
                console.error('Mic test error:', err);
                const reasons = {
                    NotAllowedError: 'Izin mikrofon ditolak. Izinkan lewat ikon gembok di address bar, lalu reload.',
                    NotFoundError: 'Mikrofon tidak ditemukan.',
                    NotReadableError: 'Mikrofon sedang dipakai aplikasi lain atau diblokir oleh sistem (Windows Settings → Privacy → Microphone).',
                    OverconstrainedError: 'Perangkat yang dipilih tidak tersedia. Pilih perangkat lain.',
                    SecurityError: 'Diblokir kebijakan keamanan browser.'
                };
                mtSetCheck('perm', err.name === 'NotAllowedError' ? 'err' : 'warn', reasons[err.name] || ('Gagal: ' + err.name));
                mtSetStatus(reasons[err.name] || ('Gagal mengakses mikrofon: ' + err.message));
                return;
            }
            // Labels only become available after permission is granted.
            await mtRefreshDevices();
            const track = micTest.stream.getAudioTracks()[0];
            if (track) {
                const settings = track.getSettings();
                if (settings.deviceId) select.value = settings.deviceId;
            }
            mtSetCheck('perm', 'ok', 'Izin mikrofon diberikan');
            mtSetCheck('signal', 'idle', 'Silakan bicara untuk menguji level suara...');

            const AC = window.AudioContext || window.webkitAudioContext;
            micTest.ctx = new AC();
            const src = micTest.ctx.createMediaStreamSource(micTest.stream);
            micTest.analyser = micTest.ctx.createAnalyser();
            micTest.analyser.fftSize = 1024;
            src.connect(micTest.analyser);
            micTest.started = Date.now();
            micTest.peak = 0;
            micTest.raf = requestAnimationFrame(mtDrawMeter);

            document.getElementById('mtStartBtn').style.display = 'none';
            document.getElementById('mtStopBtn').style.display = '';
            document.getElementById('mtRecordBtn').disabled = false;
            mtSetStatus('Mikrofon aktif. Coba bicara, bar level harus bergerak.');
        };

        window.micTestStop = function() {
            mtStopStream();
            clearTimeout(micTest.recTimer);
            if (micTest.recorder && micTest.recorder.state === 'recording') micTest.recorder.stop();
            document.getElementById('mtMeterFill').style.width = '0%';
            document.getElementById('mtMeterDb').textContent = '-∞ dB';
            document.getElementById('mtStartBtn').style.display = '';
            document.getElementById('mtStopBtn').style.display = 'none';
            document.getElementById('mtRecordBtn').disabled = true;
            mtSetStatus('Test dihentikan.');
        };

        window.micTestRecord = function() {
            if (!micTest.stream || typeof MediaRecorder === 'undefined') {
                mtSetStatus('Rekam tidak tersedia. Mulai test mikrofon dulu.');
                return;
            }
            if (micTest.recorder && micTest.recorder.state === 'recording') return;
            if (micTest.player) { micTest.player.pause(); micTest.player = null; }
            if (micTest.audioUrl) { URL.revokeObjectURL(micTest.audioUrl); micTest.audioUrl = null; }

            const chunks = [];
            const rec = new MediaRecorder(micTest.stream);
            micTest.recorder = rec;
            rec.ondataavailable = e => { if (e.data.size) chunks.push(e.data); };
            rec.onstop = () => {
                const btn = document.getElementById('mtRecordBtn');
                btn.classList.remove('recording');
                btn.querySelector('span').textContent = 'Rekam & Putar Ulang';
                if (!chunks.length) return;
                micTest.audioUrl = URL.createObjectURL(new Blob(chunks, { type: rec.mimeType || 'audio/webm' }));
                micTest.player = new Audio(micTest.audioUrl);
                mtSetStatus('Memutar rekaman... Jika suara Anda terdengar jelas, mikrofon siap dipakai.');
                micTest.player.onended = () => mtSetStatus('Selesai. Jika suara terdengar jelas, mikrofon siap dipakai.');
                micTest.player.play().catch(e => mtSetStatus('Gagal memutar: ' + e.message));
            };
            rec.start();

            const btn = document.getElementById('mtRecordBtn');
            btn.classList.add('recording');
            let left = Math.round(MIC_RECORD_MS / 1000);
            const tick = () => {
                btn.querySelector('span').textContent = 'Merekam... ' + left + 's';
                mtSetStatus('Merekam ' + left + ' detik. Silakan bicara.');
                if (left-- > 0) micTest.recTimer = setTimeout(tick, 1000);
                else if (rec.state === 'recording') rec.stop();
            };
            tick();
        };

        window.openMicTest = async function() {
            const modal = document.getElementById('micTestModal');
            modal.classList.add('open');
            mtSetCheck('signal', 'idle', 'Belum diuji');
            mtSetStatus('Klik "Mulai Test" lalu bicara.');
            document.getElementById('mtCallNote').style.display = isVideoCallActive ? '' : 'none';
            if (mtRunStaticChecks()) {
                await mtWatchPermission();
                await mtRefreshDevices();
            }
        };

        window.closeMicTest = function() {
            window.micTestStop();
            if (micTest.player) { micTest.player.pause(); micTest.player = null; }
            if (micTest.audioUrl) { URL.revokeObjectURL(micTest.audioUrl); micTest.audioUrl = null; }
            if (micTest.permStatus) micTest.permStatus.onchange = null;
            document.getElementById('micTestModal').classList.remove('open');
        };

        document.getElementById('mtDevice').addEventListener('change', (e) => {
            localStorage.setItem(MIC_PREF_KEY, e.target.value);
            if (micTest.stream) window.micTestStart();       // switch live to the new device
        });
        document.getElementById('micTestModal').addEventListener('click', (e) => {
            if (e.target.id === 'micTestModal') window.closeMicTest();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && document.getElementById('micTestModal').classList.contains('open')) window.closeMicTest();
        });
        if (navigator.mediaDevices && navigator.mediaDevices.addEventListener) {
            navigator.mediaDevices.addEventListener('devicechange', () => {
                if (document.getElementById('micTestModal').classList.contains('open')) mtRefreshDevices();
            });
        }

        // Initialize session on load
        if (!localStorage.getItem('aigr1_sessions')) {
            startNewSession();
        }

        // Cleanup on page unload - ensure Anam AI disconnects properly
        window.addEventListener('beforeunload', function(e) {
            if (isVideoCallActive && anamClient) {
                try {
                    anamClient.stopStreaming();
                    anamClient.disconnect();
                } catch (error) {
                    console.error('Cleanup error:', error);
                }
            }
        });

        // Note: visibilitychange for reconnect is handled inside setupAiBeBrain.
    </script>
</body>
</html>
