@extends('layouts.app')

@section('content')
<div class="d-flex flex-column align-items-center">
        <div id="imagePopup" class="popup">
            <img src="{{ asset('halo_evo.gif') }}" alt="Hello" class="popup-image">
            <div id="typing-text" class="typing"></div>
            <button id="playButton" class="btn btn-light mt-3" style="display: none;">Play Greeting</button>
        </div>
        <audio id="greeting">
            <source src="{{ asset('greeting.mp3') }}" type="audio/mpeg">
        </audio>
    </div>
    <div class="iframe-container main-content">
        <!-- <iframe src="https://lookerstudio.google.com/embed/reporting/f0f0edeb-4e91-4306-910e-64389351f433/page/p_cwa6g3oxmd" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe> -->
        <iframe src="https://lookerstudio.google.com/embed/reporting/190d6c37-36b6-4450-b69b-2a54a697e38a/page/oyNLE" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
    </div>

<style>
.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    animation: fadeIn 0.5s;
    background: radial-gradient(circle, 
        rgba(30, 58, 138, 0.95) 0%, 
        rgba(30, 58, 138, 0.85) 45%, 
        rgba(30, 58, 138, 0.6) 70%,
        rgba(30, 58, 138, 0) 100%
    );
    padding: 50px;
    border-radius: 50%;
    box-shadow: 
        0 0 40px rgba(30, 58, 138, 0.4),
        inset 0 0 25px rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.popup-image {
    width: 220px;
    height: auto;
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    transition: transform 0.3s ease;
    margin-bottom: 25px;
}

.popup-image:hover {
    transform: scale(1.05);
}

.typing {
    color: #ffffff;
    font-size: 20px;
    font-weight: 600;
    text-align: center;
    min-height: 28px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    font-family: 'Arial', sans-serif;
    width: 100%;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.8);
        filter: blur(10px);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
        filter: blur(0);
    }
}

@keyframes typing {
    from { width: 0 }
    to { width: 100% }
}

@keyframes blink {
    50% { border-color: transparent }
}

.typing-animation {
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
    border-right: 3px solid #ffffff;
    animation: 
        typing 3.5s steps(40, end),
        blink .75s step-end infinite;
    padding: 12px 25px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('greeting');
    const playButton = document.getElementById('playButton');

    // Automatically trigger click after a short delay
    setTimeout(function() {
        playButton.click();
    }, 1000);

    playButton.addEventListener('click', function() {
        audio.play().catch(function(error) {
            console.log("Audio playback failed:", error);
        });
    });

    // Typing effect
    const text = "Hallo, Selamat datang di AGRINAV PTPN I. Saya EVO siap membantu Anda!";
    const typingElement = document.getElementById('typing-text');
    typingElement.innerHTML = `<span class="typing-animation">${text}</span>`;

    // Hide popup after delay
    setTimeout(function() {
        document.getElementById('imagePopup').style.display = 'none';
    }, 6000);
});
</script>

@endsection