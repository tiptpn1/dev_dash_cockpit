<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AIGR1 - Asisten AI PTPN 1</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/aigr1-futuristic.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-cyan: #00d9ff;
            --primary-purple: #b24bf3;
            --dark-bg: #0a0e1a;
            --dark-panel: #0f1420;
            --dark-card: #1a1f2e;
            --accent-green: #00ff88;
            --accent-orange: #ff6b35;
            --text-primary: #ffffff;
            --text-secondary: #8b92a7;
            --glow-cyan: 0 0 20px rgba(0, 217, 255, 0.5);
            --glow-purple: 0 0 20px rgba(178, 75, 243, 0.5);
        }

        body {
            font-family: 'Rajdhani', sans-serif;
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
            background-image: url("{{ asset('images/hud-pattern.svg') }}");
            background-size: cover;
            background-position: center;
            opacity: 0.3;
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

        /* Sidebar Panel - Clean Mobile Style */
        .sidebar {
            width: 380px;
            background: linear-gradient(180deg, #0f1420 0%, #1a1f2e 50%, #0f1420 100%);
            border-right: 1px solid rgba(0, 217, 255, 0.15);
            border-radius: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0;
            box-shadow: 
                2px 0 20px rgba(0, 0, 0, 0.5),
                inset 1px 0 0 rgba(0, 217, 255, 0.1);
            overflow: hidden;
            position: relative;
        }

        /* Logo Section - Clean Mobile Header */
        .logo-section {
            text-align: center;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(0, 217, 255, 0.1);
            position: relative;
            background: rgba(10, 14, 26, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .logo-section .hud-circle {
            display: none;
        }

        .logo-section h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 26px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-cyan), var(--primary-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 4px;
            margin-bottom: 4px;
            position: relative;
        }

        .logo-section p {
            font-size: 10px;
            color: var(--text-secondary);
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.7;
        }

        /* New Chat Button - Clean Mobile Style */
        .new-chat-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00d9ff, #b24bf3);
            border: none;
            border-radius: 0;
            color: var(--text-primary);
            font-family: 'Orbitron', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid rgba(0, 217, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .new-chat-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .new-chat-btn:hover::before {
            left: 100%;
        }

        .new-chat-btn:hover {
            background: linear-gradient(135deg, #b24bf3, #00d9ff);
        }

        .new-chat-btn:active {
            transform: scale(0.98);
        }

        /* Session History - Clean Mobile Style */
        .session-history {
            max-height: 200px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
            padding: 12px;
            background: rgba(10, 14, 26, 0.4);
        }

        .session-history::-webkit-scrollbar {
            width: 4px;
        }

        .session-history::-webkit-scrollbar-track {
            background: rgba(0, 217, 255, 0.05);
            border-radius: 10px;
        }

        .session-history::-webkit-scrollbar-thumb {
            background: rgba(0, 217, 255, 0.3);
            border-radius: 10px;
        }

        .session-history::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 217, 255, 0.5);
        }

        .session-item {
            padding: 10px 12px;
            background: rgba(0, 217, 255, 0.03);
            border: 1px solid rgba(0, 217, 255, 0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .session-item:hover {
            background: rgba(0, 217, 255, 0.08);
            border-color: rgba(0, 217, 255, 0.3);
            transform: translateX(3px);
        }

        .session-item.active {
            background: rgba(178, 75, 243, 0.15);
            border-color: rgba(178, 75, 243, 0.4);
            box-shadow: 0 2px 8px rgba(178, 75, 243, 0.2);
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
            gap: 6px;
        }

        .session-btn {
            width: 26px;
            height: 26px;
            background: rgba(0, 217, 255, 0.1);
            border: 1px solid rgba(0, 217, 255, 0.2);
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .session-btn:hover {
            background: rgba(0, 217, 255, 0.2);
            border-color: var(--primary-cyan);
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

        /* Video Call Panel - Clean Mobile Style */
        .video-panel {
            background: linear-gradient(180deg, rgba(15, 20, 32, 1) 0%, rgba(20, 25, 38, 1) 100%);
            border: none;
            border-bottom: 1px solid rgba(178, 75, 243, 0.15);
            border-radius: 0;
            padding: 15px;
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .video-panel video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        /* Video Container with Rounded Corners */
        .video-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: calc(100% - 50px);
            background: linear-gradient(135deg, rgba(0, 217, 255, 0.03), rgba(178, 75, 243, 0.03));
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
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

        /* Main Call Button - Elegant Mobile Style */
        .main-call-button {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, #00ff88, #00cc70);
            color: white;
            font-size: 32px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 8px 24px rgba(0, 255, 136, 0.35),
                0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .main-call-button::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.3), rgba(0, 204, 112, 0.3));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .main-call-button:hover {
            transform: scale(1.05);
            box-shadow: 
                0 12px 32px rgba(0, 255, 136, 0.45),
                0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .main-call-button:hover::before {
            opacity: 1;
        }

        .main-call-button:active {
            transform: scale(0.95);
        }

        .main-call-button.active {
            background: linear-gradient(135deg, #ff6b35, #ff4422);
            box-shadow: 
                0 8px 24px rgba(255, 107, 53, 0.35),
                0 4px 8px rgba(0, 0, 0, 0.3);
            animation: none;
        }

        .main-call-button.active::before {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.3), rgba(255, 68, 34, 0.3));
        }

        .main-call-button.active:hover {
            box-shadow: 
                0 12px 32px rgba(255, 107, 53, 0.45),
                0 6px 12px rgba(0, 0, 0, 0.4);
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

        .control-btn-small {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1.5px solid rgba(0, 217, 255, 0.3);
            background: rgba(0, 217, 255, 0.05);
            color: var(--primary-cyan);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 18px;
        }

        .control-btn-small:hover {
            border-color: var(--primary-cyan);
            background: rgba(0, 217, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 217, 255, 0.3);
        }

        .control-btn-small:active {
            transform: translateY(0);
        }

        .control-btn-small.active {
            background: rgba(0, 255, 136, 0.2);
            border-color: var(--accent-green);
            color: var(--accent-green);
            box-shadow: 0 0 12px rgba(0, 255, 136, 0.4);
        }

        /* Video Status - Clean Mobile Style */
        .video-status {
            position: absolute;
            top: 25px;
            left: 25px;
            background: rgba(10, 14, 26, 0.95);
            backdrop-filter: blur(20px);
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid rgba(0, 217, 255, 0.2);
            font-size: 11px;
            color: var(--primary-cyan);
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            z-index: 10;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent-green);
            animation: pulse 2s infinite;
            box-shadow: 0 0 8px var(--accent-green);
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

        /* Back Button - Clean Mobile Style */
        .back-btn {
            width: 100%;
            padding: 14px;
            background: rgba(26, 31, 46, 0.8);
            border: none;
            border-top: 1px solid rgba(255, 107, 53, 0.2);
            border-radius: 0;
            color: var(--accent-orange);
            font-family: 'Rajdhani', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: rgba(255, 107, 53, 0.15);
            color: #ff8a5c;
        }

        .back-btn:active {
            transform: scale(0.98);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                width: 340px;
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
                width: 420px;
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
        <aside class="sidebar hud-panel-cut">
            <!-- Corner Brackets -->
            <div class="corner-bracket top-left"></div>
            <div class="corner-bracket top-right"></div>
            <div class="corner-bracket bottom-left"></div>
            <div class="corner-bracket bottom-right"></div>
            
            <!-- Compact Header -->
            <div class="logo-section">
                <h1 class="glitch" data-text="AIGR1">AIGR1</h1>
                <p>PTPN 1 AI ASSISTANT</p>
            </div>

            <!-- Video Call Panel - Portrait Full Height -->
            <div class="video-panel" id="videoPanel">
                <div class="video-status">
                    <div class="status-dot"></div>
                    <span id="videoStatus">READY TO CONNECT</span>
                    <!-- Add HUD elements -->
                    <div style="margin-left: auto; display: flex; gap: 5px;">
                        <div style="width: 6px; height: 6px; background: var(--accent-green); border-radius: 50%; animation: pulse 2s infinite;"></div>
                        <div style="width: 6px; height: 6px; background: var(--primary-cyan); border-radius: 50%; animation: pulse 2s infinite; animation-delay: 0.3s;"></div>
                        <div style="width: 6px; height: 6px; background: var(--primary-purple); border-radius: 50%; animation: pulse 2s infinite; animation-delay: 0.6s;"></div>
                    </div>
                </div>
                
                <!-- Avatar placeholder -->
                <div style="display: flex; align-items: center; justify-content: center; height: calc(100% - 60px); background: linear-gradient(135deg, rgba(0, 217, 255, 0.05), rgba(178, 75, 243, 0.05)); border-radius: 15px; position: relative;">
                    <video id="avatarVideo" autoplay playsinline muted style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px; display: none;"></video>
                    
                    <!-- Placeholder when no call -->
                    <div id="avatarPlaceholder" style="text-align: center;">
                        <div class="hud-circle" style="width: 100px; height: 100px; margin: 0 auto 15px;">
                            <img src="{{ asset('evopng.png') }}" alt="EVO Avatar" style="width: 70px; height: 70px; border-radius: 50%;">
                        </div>
                        <h3 style="font-family: 'Orbitron', sans-serif; color: var(--primary-cyan); margin-bottom: 8px; font-size: 20px;">EVA</h3>
                        <p style="color: var(--text-secondary); font-size: 12px; padding: 0 20px;">Press call button to start video conversation</p>
                    </div>
                </div>
                
                <!-- Main Call Button (Like Mobile) -->
                <div class="call-button-container">
                    <!-- Secondary Controls (shown when call is active) -->
                    <div class="secondary-controls" id="secondaryControls" style="display: none;">
                        <button class="control-btn-small" id="videoToggleSmall" title="Toggle Video" onclick="toggleVideo()">
                            📹
                        </button>
                        <button class="control-btn-small" id="micToggleSmall" title="Toggle Microphone" onclick="toggleMic()">
                            🎤
                        </button>
                        <button class="control-btn-small" id="speakerToggleSmall" title="Toggle Speaker" onclick="toggleSpeaker()">
                            🔊
                        </button>
                    </div>
                    
                    <!-- Main Call/End Button -->
                    <button class="main-call-button" id="mainCallButton" onclick="handleMainCallButton()" title="Start Call">
                        📞
                    </button>
                    
                    <div style="text-align: center;">
                        <p id="callButtonLabel" style="color: var(--accent-green); font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
                            TAP TO CALL
                        </p>
                    </div>
                </div>
            </div>

            <!-- Session History at Bottom -->
            <button class="new-chat-btn" onclick="startNewSession()">
                <span>⚡</span> NEW SESSION
            </button>

            <div class="session-history" id="sessionHistory">
                <!-- Session items will be dynamically added here -->
            </div>

            <a href="{{ route('overview') }}" class="back-btn">
                <span>←</span> BACK TO AGRINAV
            </a>
        </aside>

        <!-- Main Chat Area -->
        <div class="chat-area">
            <!-- Chat Panel -->
            <div class="chat-panel hud-panel-cut">
                <!-- Corner Brackets -->
                <div class="corner-bracket top-left"></div>
                <div class="corner-bracket top-right"></div>
                <div class="corner-bracket bottom-left"></div>
                <div class="corner-bracket bottom-right"></div>
                
                <!-- Energy Bar Header -->
                <div style="margin-bottom: 15px;">
                    <div class="energy-bar"></div>
                </div>
                
                <div class="messages-container" id="messagesContainer">
                    <div class="message assistant">
                        <div class="message-avatar">
                            <img src="{{ asset('evopng.png') }}" alt="EVO">
                        </div>
                        <div class="message-content">
                            👋 Hi! I'm EVO, your AI-powered assistant for AGRINAV. I can help you with text, voice, or video communication. How can I assist you today?
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
                : '<div class="message-avatar"><img src="{{ asset('evopng.png') }}" alt="EVO"></div>';
            
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
                <div class="message-avatar"><img src="{{ asset('evopng.png') }}" alt="EVO"></div>
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
                label.textContent = 'END CALL';
                label.style.color = 'var(--accent-orange)';
                secondaryControls.style.display = 'flex';
                
                await startVideoCall();
            } else {
                // End call
                button.classList.remove('active');
                label.textContent = 'TAP TO CALL';
                label.style.color = 'var(--accent-green)';
                secondaryControls.style.display = 'none';
                
                endVideoCall();
            }
        };

        window.startVideoCall = async function() {
            if (isVideoCallActive) return;
            
            const videoStatus = document.getElementById('videoStatus');
            const placeholder = document.getElementById('avatarPlaceholder');
            const video = document.getElementById('avatarVideo');
            
            videoStatus.textContent = 'CONNECTING...';
            
            try {
                // Get Anam AI session token from backend
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
                
                const tokenData = await tokenResponse.json();
                
                if (!tokenData.success || !tokenData.sessionToken) {
                    throw new Error(tokenData.message || 'Invalid session token');
                }
                
                // Import Anam AI SDK
                const { createClient } = await import('https://esm.sh/@anam-ai/js-sdk@latest');
                
                // Create Anam client
                anamClient = createClient(tokenData.sessionToken);
                
                // Hide placeholder, show video
                placeholder.style.display = 'none';
                video.style.display = 'block';
                
                // Start streaming to video element
                await anamClient.streamToVideoElement('avatarVideo');
                
                isVideoCallActive = true;
                isMicActive = true;
                isSpeakerActive = true;
                isVideoActive = true;
                
                videoStatus.textContent = 'CONNECTED - LIVE';
                
                // Update button states
                updateControlButtons();
                
                addMessage('📹 Video call connected! You can now talk with EVO.', false);
                
            } catch (error) {
                console.error('Video call error:', error);
                videoStatus.textContent = 'CONNECTION FAILED';
                
                // Show placeholder again
                placeholder.style.display = 'block';
                video.style.display = 'none';
                
                // Reset button
                const button = document.getElementById('mainCallButton');
                const label = document.getElementById('callButtonLabel');
                const secondaryControls = document.getElementById('secondaryControls');
                
                button.classList.remove('active');
                label.textContent = 'TAP TO CALL';
                label.style.color = 'var(--accent-green)';
                secondaryControls.style.display = 'none';
                
                addMessage('⚠️ Failed to start video call: ' + error.message + '. Please check your Anam AI configuration.', false);
                
                setTimeout(() => {
                    videoStatus.textContent = 'READY TO CONNECT';
                }, 3000);
            }
        };

        window.endVideoCall = function() {
            if (!isVideoCallActive) return;
            
            if (anamClient) {
                try {
                    anamClient.disconnect();
                } catch (e) {
                    console.error('Error disconnecting:', e);
                }
                anamClient = null;
            }
            
            isVideoCallActive = false;
            isMicActive = false;
            isVideoActive = false;
            
            const videoStatus = document.getElementById('videoStatus');
            const placeholder = document.getElementById('avatarPlaceholder');
            const video = document.getElementById('avatarVideo');
            
            videoStatus.textContent = 'CALL ENDED';
            
            // Hide video, show placeholder
            video.style.display = 'none';
            placeholder.style.display = 'block';
            
            addMessage('📞 Video call ended.', false);
            
            setTimeout(() => {
                videoStatus.textContent = 'READY TO CONNECT';
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
            if (!isVideoCallActive) return;
            
            isMicActive = !isMicActive;
            const btn = document.getElementById('micToggleSmall');
            
            if (btn) {
                if (isMicActive) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            }
            
            // TODO: Implement actual mic toggle with Anam client
            if (anamClient && anamClient.toggleMicrophone) {
                anamClient.toggleMicrophone(isMicActive);
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
    </script>
</body>
</html>
