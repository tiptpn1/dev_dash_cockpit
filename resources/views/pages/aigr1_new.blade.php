<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AIGR1 - Futuristic AI Assistant</title>
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
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding-right: 10px;
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
                overflow-y: auto;
                gap: 10px;
            }

            .call-panel {
                width: 100%;
                min-height: 500px;
                max-height: 600px;
            }

            .chat-area {
                flex: 1;
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
    <div class="icon" id="menuIcon" title="Toggle Menu">
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
                    <span id="videoStatus">Ready</span>
                </div>
                
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
                        <button class="control-btn-small" id="videoToggleSmall" title="Toggle Video" onclick="toggleVideo()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                        </button>
                        <button class="control-btn-small" id="micToggleSmall" title="Toggle Microphone" onclick="toggleMic()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                                <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                <line x1="12" y1="19" x2="12" y2="23"></line>
                                <line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                        </button>
                        <button class="control-btn-small" id="speakerToggleSmall" title="Toggle Speaker" onclick="toggleSpeaker()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Main Call/End Button -->
                    <button class="main-call-button" id="mainCallButton" onclick="handleMainCallButton()" title="Start Call">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </button>
                    
                    <div style="text-align: center;">
                        <p id="callButtonLabel" style="color: var(--accent-color); font-size: 11px; font-weight: 600; letter-spacing: 0.5px;">
                            Tap to call
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
                New Session
            </button>

            <div class="session-history" id="sessionHistory">
                <!-- Session items will be dynamically added here -->
            </div>

            <a href="{{ route('overview') }}" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle;">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to AGRINAV
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
                        <button class="mode-btn active" id="textMode" title="Text Mode" onclick="setInputMode('text')">
                            💬
                        </button>
                        <button class="mode-btn" id="voiceMode" title="Voice Mode" onclick="setInputMode('voice')">
                            🎙️
                        </button>
                        <button class="mode-btn" id="videoMode" title="Video Call Mode" onclick="setInputMode('video')">
                            📹
                        </button>
                    </div>
                    <textarea 
                        class="message-input" 
                        id="messageInput" 
                        placeholder="Type your message here..."
                        rows="1"
                        onkeypress="handleKeyPress(event)"
                    ></textarea>
                    <button class="send-btn" onclick="sendMessage()">
                        ➤
                    </button>
                </div>
            </div>
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

        // ai-be voice brain state (Anam = STT + avatar + TTS; answers come from ai-be)
        const ANAM_SDK_URL = 'https://esm.sh/@anam-ai/js-sdk@4.29.1';
        const VOICE_GREETING = 'Halo, saya EVA, asisten AgriNav PTPN 1. Siap membantu. Ada yang ingin Anda tanyakan?';
        const VOICE_FILLER_POOL = [
            'Baik, saya cek datanya dulu ya.',
            'Sebentar, saya ambilkan informasinya.',
            'Oke, saya proses pertanyaan Anda.',
            'Satu momen, saya sedang mencari datanya.',
        ];
        const VOICE_ACK_POOL = [
            'Oke.',
            'Baik.',
            'Ya.',
            'Siap.',
        ];
        const VOICE_ERROR = 'Maaf, saya sedang mengalami kendala. Silakan coba lagi sebentar lagi.';
        const VOICE_FAREWELL = 'Baik, sampai jumpa lagi!';
        const VOICE_FILLER_AFTER_MS = 2800;   // say a short filler if the answer takes longer than this
        const USER_TURN_DEBOUNCE_MS = 750;    // wait for trailing-silence before firing ai-be request
        const BARGE_IN_COOLDOWN_MS  = 800;    // ignore barge-in events this soon after interrupting
        // Adaptive status labels cycling through processing stages
        const STATUS_CYCLE = ['Menganalisis...', 'Mengambil data...', 'Menyusun jawaban...'];
        let brainMode = 'anam';
        let voiceTurnTimer = null;
        let voiceAbort = null;
        let voiceTurnSeq = 0;
        let activeTalkStream = null;
        let lastBargeInAt = 0;          // timestamp of last barge-in interrupt
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
        window.startNewSession = function() {
            currentSessionId = Date.now();
            aiSessionId = '';
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = `
                <div class="message assistant">
                    <div class="message-avatar">
                        <img src="{{ asset('evopng.png') }}" alt="EVO">
                    </div>
                    <div class="message-content">
                        👋 Hi! I'm EVO, your AI-powered assistant for AGRINAV. I can help you with text, voice, or video communication. How can I assist you today?
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
                title: messages.length > 1 ? messages[1].content.slice(0, 30) + '...' : 'New Session',
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
                            <button class="session-btn" onclick="loadSession(${session.id})">↻</button>
                            <button class="session-btn" onclick="deleteSession(${session.id})">🗑</button>
                        </div>
                    `;
                    historyContainer.appendChild(sessionItem);
                });
        }

        window.loadSession = function(sessionId) {
            const sessions = JSON.parse(localStorage.getItem('aigr1_sessions') || '{}');
            const session = sessions[sessionId];
            
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
            if (confirm('Delete this session?')) {
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
        window.setInputMode = function(mode) {
            currentInputMode = mode;
            
            // Update active state
            document.querySelectorAll('.mode-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById(mode + 'Mode').classList.add('active');
            
            if (mode === 'video') {
                startVideoCall();
            } else if (mode === 'voice') {
                startVoiceRecording();
            }
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
            if (isProcessing) return;

            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (!message) return;

            isProcessing = true;
            messageInput.value = '';
            messageInput.style.height = 'auto';

            addMessage(message, true);
            const bubble = addMessage('<span class="thinking-label">🧠 Thinking...</span>');

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
                            errorMsg = (data && (data.error || data.message)) || 'AI backend error';
                            break;
                    }
                });

                await renderChain;

                if (!rendered) {
                    if (streamed && !looksLikePlanningJson(streamed)) {
                        await renderBotContent(bubble, { text: streamed });
                    } else if (errorMsg) {
                        bubble.innerHTML = '<span class="msg-error">Maaf, terjadi kesalahan: ' + escapeHtml(errorMsg) + '</span>';
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
                isProcessing = false;
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
            let t = unwrapPlanningJson(String(text || '')).replace(CITATION_RE, '')
                .replace(/!\[[^\]]*\]\([^)]*\)/g, ' ')
                .replace(/\[([^\]]+)\]\([^)]*\)/g, '$1')
                .replace(/https?:\/\/\S+/g, ' ')
                .replace(/^\s*[-•*]\s+/gm, '')
                .replace(/[`*_#>|~]/g, ' ')
                .replace(/[\p{Extended_Pictographic}\uFE0F\u200D]/gu, '')
                .replace(/\s*\n+\s*/g, '. ')
                .replace(/\s{2,}/g, ' ')
                .replace(/\.\s*\./g, '.')
                .trim();
            if (t.length > 500) {
                const cut = t.slice(0, 500);
                t = cut.slice(0, Math.max(cut.lastIndexOf('. '), cut.lastIndexOf('! '), cut.lastIndexOf('? '), 120) + 1) + ' Detail lengkapnya saya tampilkan di layar chat.';
            }
            return t;
        }

        // Stream text to the avatar sentence-by-sentence (faster time-to-first-audio).
        async function speakViaAnam(text, existingStream = null) {
            if (!anamClient || !text) return;
            const sentences = text.match(/[^.!?]+[.!?]*\s*/g) || [text];
            let stream = existingStream && existingStream.isActive() ? existingStream : anamClient.createTalkMessageStream();
            activeTalkStream = stream;
            for (let i = 0; i < sentences.length; i++) {
                await stream.streamMessageChunk(sentences[i], i === sentences.length - 1);
            }
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

        async function streamAiTurn(text, signal, voice, onEvent) {
            const handle = (event, data) => { captureAiSessionId(data); onEvent(event, data); };
            const response = await fetch('/ai/response', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'text/event-stream'
                },
                body: JSON.stringify({ message: text, sessionId: aiSessionId || undefined, stream: true, voice: !!voice }),
                signal
            });
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
            const seq = ++voiceTurnSeq;
            if (voiceAbort) voiceAbort.abort();            // a newer utterance supersedes the old turn
            voiceAbort = new AbortController();
            const videoStatus = document.getElementById('videoStatus');

            isProcessing = true;
            stopStatusCycle();                             // clear any previous cycle
            addMessage(text, true);
            const typing = addTypingIndicator();

            // ── Trick 1: Immediate micro-acknowledgement (< 150ms latency perception) ────
            // Speak a one-word acknowledgement right away so the user knows EVA heard them.
            // This stream stays open; the filler (if needed) appends to the same channel.
            let ackStream = null;
            try {
                if (anamClient) {
                    ackStream = anamClient.createTalkMessageStream();
                    activeTalkStream = ackStream;
                    await ackStream.streamMessageChunk(pickRandom(VOICE_ACK_POOL) + ' ', false);
                }
            } catch (e) { ackStream = null; }

            // ── Trick 2: Adaptive status labels cycle so the HUD feels alive ─────────────
            startStatusCycle(videoStatus);

            let answered = false;
            let chartRendered = false;
            let bubble = null;
            let fillerStream = null;
            const fillerTimer = setTimeout(async () => {
                if (answered || !anamClient || seq !== voiceTurnSeq) return;
                try {
                    // Reuse ackStream if still open, otherwise open a new one
                    const fs = (ackStream && ackStream.isActive()) ? ackStream : anamClient.createTalkMessageStream();
                    fillerStream = fs;
                    activeTalkStream = fs;
                    await fs.streamMessageChunk(pickRandom(VOICE_FILLER_POOL) + ' ', false);
                } catch (e) { fillerStream = null; }
            }, VOICE_FILLER_AFTER_MS);

            // Voice best practice: the avatar only speaks the short spokenText; the full markdown answer,
            // tables and charts are shown in the chat bubble (charts arrive with a later `done` event).
            try {
                await streamAiTurn(text, voiceAbort.signal, true, (event, data) => {
                    if (seq !== voiceTurnSeq) return;

                    if (event === 'skill_called') {
                        // ── Trick 3: Skill-specific status labels ─────────────────────────
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
                            clearTimeout(fillerTimer);
                            stopStatusCycle();
                            typing.remove();
                            bubble = addMessage('');
                            chartRendered = !!(blocks || imageUrl);
                            renderBotContent(bubble, { text: content, blocks, imageUrl }).then(saveSession);
                            videoStatus.textContent = 'Berbicara...';
                            const spoken = (r.message && r.message.metadata && r.message.metadata.spokenText) || toSpeakable(content);
                            // ── Trick 4: Brief lead-in pause before main answer ───────────
                            // A 200ms gap separates the ack/filler from the substantive reply,
                            // making the speech feel structured rather than rushed.
                            const answerDelay = (ackStream || fillerStream) ? 200 : 0;
                            setTimeout(() => {
                                speakViaAnam(spoken, fillerStream || ackStream)
                                    .then(() => {
                                        // ── Trick 5: Return to Listening after speaking ──────
                                        if (seq === voiceTurnSeq && isVideoCallActive) {
                                            videoStatus.textContent = 'Mendengarkan...';
                                        }
                                    })
                                    .catch(err => console.error('Anam speak error:', err));
                            }, answerDelay);
                        } else if (!chartRendered && (blocks || imageUrl)) {
                            // Charts arrive with the later `done`: upgrade the same bubble in place.
                            // Never re-speak - the avatar already delivered the answer.
                            chartRendered = true;
                            renderBotContent(bubble, { text: content, blocks, imageUrl }).then(saveSession);
                        }
                    } else if (event === 'error') {
                        throw new Error(data.error || 'AI backend error');
                    }
                });

                if (!answered && seq === voiceTurnSeq) throw new Error('Empty response');
            } catch (error) {
                if (error.name === 'AbortError' || seq !== voiceTurnSeq) return;   // superseded or call ended
                console.error('Voice turn error:', error);
                clearTimeout(fillerTimer);
                stopStatusCycle();
                typing.remove();
                addMessage('⚠️ ' + VOICE_ERROR);
                speakViaAnam(VOICE_ERROR, fillerStream || ackStream).catch(() => {});
            } finally {
                clearTimeout(fillerTimer);
                stopStatusCycle();
                // Remove any leftover typing indicator (double-safe)
                document.querySelectorAll('.message.typing-indicator').forEach(el => el.remove());
                if (seq === voiceTurnSeq) {
                    isProcessing = false;
                    // Status restored to Listening after speak (Trick 5), but fall-back after 6s
                    setTimeout(() => {
                        if (isVideoCallActive && seq === voiceTurnSeq) videoStatus.textContent = 'Mendengarkan...';
                    }, 6000);
                }
            }
        }

        function setupAiBeBrain(anamSdk) {
            // Finished user utterances arrive via history updates; debounce to use the final transcript.
            // ── Trick 6: Trailing-silence guard ──────────────────────────────────────────
            // Reset the debounce timer on every update so partial mid-sentence transcripts
            // don't fire ai-be prematurely. Only the stable final text triggers the turn.
            anamClient.addListener(anamSdk.AnamEvent.MESSAGE_HISTORY_UPDATED, (messages) => {
                if (!messages || !messages.length) return;
                const last = messages[messages.length - 1];
                if (last.role !== 'user' || !last.content || !last.content.trim()) return;
                if (handledUserMessageIds.has(last.id)) return;

                clearTimeout(voiceTurnTimer);
                voiceTurnTimer = setTimeout(() => {
                    if (handledUserMessageIds.has(last.id)) return;
                    handledUserMessageIds.add(last.id);
                    runVoiceTurn(last.content.trim());
                }, USER_TURN_DEBOUNCE_MS);
            });

            // ── Trick 7: Barge-in with cooldown ──────────────────────────────────────────
            // Stop the avatar immediately when the user starts speaking, but apply a
            // short cooldown so an echo of the avatar's own voice doesn't self-interrupt.
            anamClient.addListener(anamSdk.AnamEvent.USER_SPEECH_STARTED, () => {
                const now = Date.now();
                if (now - lastBargeInAt < BARGE_IN_COOLDOWN_MS) return;   // skip echo
                lastBargeInAt = now;
                try {
                    if (activeTalkStream && activeTalkStream.isActive()) anamClient.interruptPersona();
                    stopStatusCycle();
                } catch (e) { console.warn('interruptPersona failed:', e); }
            });

            anamClient.addListener(anamSdk.AnamEvent.MESSAGE_DELIVERY_FAILED, (failure) => {
                console.warn('Anam message delivery failed:', failure);
            });

            // ── Trick 8: Tab-focus reconnect health check ─────────────────────────────
            // If the user switches away and comes back, a stale connection may not
            // recover on its own. Ping the video element; if it stopped, notify.
            document.addEventListener('visibilitychange', () => {
                if (!document.hidden && isVideoCallActive) {
                    const vid = document.getElementById('avatarVideo');
                    if (vid && vid.paused) {
                        vid.play().catch(() => {});
                    }
                }
            });
        }

        function resetVoiceBrain() {
            clearTimeout(voiceTurnTimer);
            voiceTurnTimer = null;
            stopStatusCycle();
            voiceTurnSeq++;                                // invalidates any in-flight turn
            if (voiceAbort) { voiceAbort.abort(); voiceAbort = null; }
            activeTalkStream = null;
            lastBargeInAt = 0;
            handledUserMessageIds.clear();
            brainMode = 'anam';
            isProcessing = false;
        }

        // Video Call Functions (Anam AI Integration)
        window.handleMainCallButton = async function() {
            const button = document.getElementById('mainCallButton');
            const label = document.getElementById('callButtonLabel');
            const secondaryControls = document.getElementById('secondaryControls');
            const placeholder = document.getElementById('avatarPlaceholder');
            const video = document.getElementById('avatarVideo');
            
            if (!isVideoCallActive) {
                // Start call
                button.classList.add('active');
                button.innerHTML = `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>`;
                label.textContent = 'End call';
                label.style.color = 'var(--danger-color)';
                secondaryControls.style.display = 'flex';
                
                await startVideoCall();
            } else {
                // End call
                button.classList.remove('active');
                button.innerHTML = `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>`;
                label.textContent = 'Tap to call';
                label.style.color = 'var(--accent-color)';
                secondaryControls.style.display = 'none';
                
                endVideoCall();
            }
        };

        window.startVideoCall = async function() {
            if (isVideoCallActive) return;
            
            const videoStatus = document.getElementById('videoStatus');
            const placeholder = document.getElementById('avatarPlaceholder');
            const video = document.getElementById('avatarVideo');
            
            videoStatus.textContent = 'Connecting...';
            
            try {
                // Get session token from backend
                const tokenResponse = await fetch('/aigri/anam-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (!tokenResponse.ok) {
                    throw new Error('Failed to get Anam session token');
                }
                
                const data = await tokenResponse.json();
                
                if (!data.success || !data.sessionToken) {
                    throw new Error(data.message || 'Invalid session token');
                }
                
                // Import Anam AI SDK
                const anamSdk = await import(ANAM_SDK_URL);
                
                // Request microphone permission explicitly first
                videoStatus.textContent = 'Requesting microphone access...';
                const mediaStream = await navigator.mediaDevices.getUserMedia({
                    audio: true,
                    video: false
                });
                
                videoStatus.textContent = 'Initializing AI...';
                
                // Create Anam client with session token and custom audio stream
                anamClient = anamSdk.createClient(data.sessionToken, {
                    disableInputAudio: false, // Enable audio input
                });
                
                // Listen for connection events
                anamClient.addListener(anamSdk.AnamEvent.CONNECTION_ESTABLISHED, () => {
                    console.log('Anam connection established');
                    videoStatus.textContent = 'Connected';
                });
                
                anamClient.addListener(anamSdk.AnamEvent.CONNECTION_CLOSED, (code) => {
                    console.log('Anam connection closed:', code);
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
                await anamClient.streamToVideoElement('avatarVideo', mediaStream);
                
                // Ensure video is unmuted and playing
                video.muted = false;
                video.volume = 1.0;
                await video.play().catch(e => console.log('Video autoplay:', e));
                
                // Get and display audio state
                const audioState = anamClient.getInputAudioState();
                console.log('Audio state:', audioState);
                
                if (audioState.permissionState === 'denied') {
                    throw new Error('Microphone permission denied');
                }
                
                isVideoCallActive = true;
                isMicActive = true;
                isSpeakerActive = true;
                isVideoActive = true;
                
                videoStatus.textContent = 'Connected';
                
                // Update button states
                updateControlButtons();

                addMessage('📹 Video call terhubung! Silakan berbicara dengan EVA.', false);

                if (brainMode === 'ai-be') {
                    // ── Trick 9: Greeting with Listening state ───────────────────────
                    const videoStatus = document.getElementById('videoStatus');
                    videoStatus.textContent = 'Mendengarkan...';
                    speakViaAnam(VOICE_GREETING)
                        .then(() => { if (isVideoCallActive) videoStatus.textContent = 'Mendengarkan...'; })
                        .catch(err => console.warn('Greeting failed:', err));
                }
                
            } catch (error) {
                console.error('Video call error:', error);
                
                if (error.name === 'NotAllowedError' || error.message.includes('permission')) {
                    videoStatus.textContent = 'Microphone access denied';
                    addMessage('⚠️ Microphone access denied. Please allow microphone permission in your browser settings.', false);
                } else {
                    videoStatus.textContent = 'Connection failed';
                    addMessage('⚠️ Failed to start video call: ' + error.message, false);
                }
                
                // Show placeholder again
                placeholder.style.display = 'block';
                video.style.display = 'none';
                
                // Reset button
                const button = document.getElementById('mainCallButton');
                const label = document.getElementById('callButtonLabel');
                const secondaryControls = document.getElementById('secondaryControls');
                
                button.classList.remove('active');
                label.textContent = 'Tap to call';
                label.style.color = 'var(--accent-green)';
                secondaryControls.style.display = 'none';
                
                addMessage('⚠️ Failed to start video call: ' + error.message + '. Please check your Anam AI configuration.', false);
                
                setTimeout(() => {
                    videoStatus.textContent = 'Ready';
                }, 3000);
            }
        };

        window.endVideoCall = function() {
            if (!isVideoCallActive) return;
            
            resetVoiceBrain();

            if (anamClient) {
                try {
                    // Stop streaming and disconnect properly
                    anamClient.stopStreaming();
                    anamClient.disconnect();
                } catch (e) {
                    console.error('Error disconnecting:', e);
                }
                anamClient = null;
            }
            
            isVideoCallActive = false;
            isMicActive = false;
            isVideoActive = false;
            isSpeakerActive = false;
            
            const videoStatus = document.getElementById('videoStatus');
            const placeholder = document.getElementById('avatarPlaceholder');
            const video = document.getElementById('avatarVideo');
            
            videoStatus.textContent = 'Call ended';
            
            // Stop and clear video element
            if (video) {
                video.pause();
                video.srcObject = null;
                video.style.display = 'none';
            }
            
            // Show placeholder
            placeholder.style.display = 'block';
            
            // ── Trick 10: Farewell before disconnect ─────────────────────────────
            // A brief goodbye makes the end-of-call feel deliberate, not abrupt.
            // Note: anamClient is already set to null at this point by the caller path,
            // so we only speak if the client reference was captured before the call.
            addMessage('📞 Video call berakhir.', false);

            setTimeout(() => {
                videoStatus.textContent = 'Ready';
            }, 2000);
        };

        function updateControlButtons() {
            // Update small control buttons
            const videoBtn = document.getElementById('videoToggleSmall');
            const micBtn = document.getElementById('micToggleSmall');
            const speakerBtn = document.getElementById('speakerToggleSmall');
            
            if (videoBtn) {
                if (isVideoActive) {
                    videoBtn.classList.add('active');
                } else {
                    videoBtn.classList.remove('active');
                }
            }
            
            if (micBtn) {
                if (isMicActive) {
                    micBtn.classList.add('active');
                } else {
                    micBtn.classList.remove('active');
                }
            }
            
            if (speakerBtn) {
                if (isSpeakerActive) {
                    speakerBtn.classList.add('active');
                } else {
                    speakerBtn.classList.remove('active');
                }
            }
        }

        window.toggleVideo = function() {
            if (!isVideoCallActive) return;
            
            isVideoActive = !isVideoActive;
            const btn = document.getElementById('videoToggleSmall');
            
            if (btn) {
                if (isVideoActive) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
            
            // TODO: Implement actual video toggle with Anam client
            if (anamClient && anamClient.toggleVideo) {
                anamClient.toggleVideo(isVideoActive);
            }
            
            addMessage(isVideoActive ? '📹 Camera enabled' : '📹 Camera disabled', false);
        };

        window.toggleMic = function() {
            if (!isVideoCallActive || !anamClient) return;
            
            isMicActive = !isMicActive;
            const btn = document.getElementById('micToggleSmall');
            
            if (btn) {
                if (isMicActive) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
            
            // Use Anam API to mute/unmute
            if (isMicActive) {
                anamClient.unmuteInputAudio();
            } else {
                anamClient.muteInputAudio();
            }
            
            addMessage(isMicActive ? '🎤 Microphone enabled' : '🎤 Microphone muted', false);
        };

        window.toggleSpeaker = function() {
            if (!isVideoCallActive) return;
            
            isSpeakerActive = !isSpeakerActive;
            const btn = document.getElementById('speakerToggleSmall');
            
            if (btn) {
                if (isSpeakerActive) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
            
            const videoElement = document.getElementById('avatarVideo');
            if (videoElement) {
                videoElement.muted = !isSpeakerActive;
                videoElement.volume = isSpeakerActive ? 1.0 : 0;
            }
            
            addMessage(isSpeakerActive ? '🔊 Speaker enabled' : '🔇 Speaker muted', false);
        };

        // Voice Recording Functions
        window.startVoiceRecording = async function() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                
                mediaRecorder.ondataavailable = (event) => {
                    audioChunks.push(event.data);
                };
                
                mediaRecorder.onstop = async () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    // TODO: Send audio to backend for speech-to-text processing
                    addMessage('🎙️ Voice message recorded (speech-to-text processing coming soon)', true);
                    
                    // Stop all tracks
                    stream.getTracks().forEach(track => track.stop());
                };
                
                mediaRecorder.start();
                addMessage('🎙️ Recording voice message... Click send when done.', false);
                
            } catch (error) {
                console.error('Voice recording error:', error);
                addMessage('⚠️ Failed to access microphone. Please check permissions.', false);
            }
        };

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
