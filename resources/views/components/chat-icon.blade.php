<div class="chat-icon-container">
    <img src="{{ asset('logo_aigri.png') }}" alt="Chat Icon" class="chat-icon" id="chatIcon">
</div>

<style>
.chat-icon-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    cursor: pointer;
}

.chat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.chat-icon:hover {
    transform: scale(1.1);
}
</style>

<script>
document.getElementById('chatIcon').addEventListener('click', function() {
    // Add your chatbot trigger logic here
    console.log('Chat icon clicked');
});
</script> 