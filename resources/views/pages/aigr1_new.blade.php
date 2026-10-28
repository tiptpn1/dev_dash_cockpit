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

        /* Sidebar Panel - Modern Minimal - Portrait 768x1152 (2:3 ratio) */
        .sidebar {
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
            .sidebar {
                width: 500px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                overflow-y: auto;
                gap: 10px;
            }

            .sidebar {
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
            .sidebar {
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

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar - Now Video Call Panel -->
        <aside class="sidebar">
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
        let anamClient = null;
        let mediaRecorder = null;
        let audioChunks = [];
        let isVideoCallActive = false;
        let isMicActive = false;
        let isSpeakerActive = true;
        let isVideoActive = true;

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
                const content = msg.querySelector('.message-content').textContent.trim();
                messages.push({ content, isUser });
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
                        <div class="session-title">${session.title}</div>
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
                
                session.messages.forEach(msg => {
                    addMessage(msg.content, msg.isUser);
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
                <div class="message-content">${content}</div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
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
            const typingIndicator = addTypingIndicator();
            
            try {
                const response = await fetch('/ai/response', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        message: message,
                        sessionId: currentSessionId
                    })
                });
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                typingIndicator.remove();
                
                if (data.data && data.data.response) {
                    const cleanResponse = data.data.response
                        .replace(/【\d+:\d+†source】/g, '')
                        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\n/g, '<br>');
                    
                    addMessage(cleanResponse);
                    saveSession();
                }
            } catch (error) {
                console.error('Error:', error);
                typingIndicator.remove();
                addMessage('⚠️ Sorry, there was an error processing your request. Please try again.');
            } finally {
                isProcessing = false;
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
                const anamSdk = await import('https://esm.sh/@anam-ai/js-sdk@latest');
                
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
                
                addMessage('📹 Video call connected! You can now talk with EVO.', false);
                
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
            
            addMessage('📞 Video call ended.', false);
            
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

        // Cleanup on visibility change (tab switch)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && isVideoCallActive) {
                console.log('Tab hidden - maintaining connection');
                // Optional: pause/unpause based on requirements
            }
        });
    </script>
</body>
</html>
