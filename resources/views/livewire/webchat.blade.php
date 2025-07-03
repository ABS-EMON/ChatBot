<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Website with Chatbot</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

  <!-- Website Content -->
  <div class="p-10">
    <h1 class="text-4xl font-bold">Welcome to Emon's Website</h1>
    <p class="mt-4 text-lg">Browse around and let me know if you need help. 😊</p>
  </div>

  <!-- Chat Bubble Icon -->
  <button id="chat-bubble" onclick="toggleChat()"
    class="hidden fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition z-50">
    💬
  </button>

  <!-- Chat Widget -->
  <div id="chat-widget" class="hidden fixed bottom-20 right-6 w-80 bg-white shadow-2xl rounded-lg overflow-hidden z-50">
    <!-- Header -->
    <div class="bg-blue-600 text-white p-3 flex justify-between items-center">
      <span class="font-semibold">🤖 EmonBot</span>
      <button onclick="toggleChat()" class="hover:text-gray-200">✖</button>
    </div>

    <!-- Messages -->
    <div id="chat-box" class="h-64 overflow-y-auto p-4 space-y-2 bg-gray-50 text-sm">
      <div class="flex items-start space-x-2">
        <div class="w-6 h-6 bg-blue-500 rounded-full text-white flex items-center justify-center">🤖</div>
        <div class="bg-gray-200 px-3 py-2 rounded-lg">
          Hello! Need any help?
        </div>
      </div>
    </div>

    <!-- Typing Indicator -->
    <div id="typing" class="hidden px-4 py-1 text-xs text-gray-400">EmonBot is typing...</div>

    <!-- Input -->
    <form id="chat-form" class="flex items-center gap-2 border-t border-gray-200 p-2" onsubmit="sendMessage(event)">
      <input id="user-input" type="text" placeholder="Type a message..." 
             class="flex-1 text-sm px-3 py-2 rounded border focus:outline-none focus:ring focus:ring-blue-300" />
      <button type="submit" class="text-white bg-blue-600 px-3 py-2 rounded hover:bg-blue-700 text-sm">Send</button>
    </form>
  </div>

  <!-- Script -->
  <script>
    // Show chat bubble after 2 seconds
    window.onload = function () {
      setTimeout(() => {
        document.getElementById("chat-bubble").classList.remove("hidden");
      }, 2000);
    };

    // Toggle chat widget
    function toggleChat() {
      const chat = document.getElementById("chat-widget");
      chat.classList.toggle("hidden");
    }

    // Send message function
    function sendMessage(e) {
      e.preventDefault();
      const input = document.getElementById('user-input');
      const message = input.value.trim();
      if (!message) return;

      const chatBox = document.getElementById('chat-box');

      // Add user message
      const userMsg = document.createElement('div');
      userMsg.classList.add('flex', 'justify-end');
      userMsg.innerHTML = `
        <div class="bg-blue-500 text-white px-3 py-2 rounded-lg max-w-[70%]">
          ${message}
        </div>
      `;
      chatBox.appendChild(userMsg);

      input.value = '';
      chatBox.scrollTop = chatBox.scrollHeight;

      // Typing simulation
      const typing = document.getElementById('typing');
      typing.classList.remove('hidden');

      setTimeout(() => {
        typing.classList.add('hidden');

        const botMsg = document.createElement('div');
        botMsg.classList.add('flex', 'items-start', 'space-x-2');
        botMsg.innerHTML = `
          <div class="w-6 h-6 bg-blue-500 rounded-full text-white flex items-center justify-center">🤖</div>
          <div class="bg-gray-200 px-3 py-2 rounded-lg max-w-[70%]">
            You said: "${message}"
          </div>
        `;
        chatBox.appendChild(botMsg);
        chatBox.scrollTop = chatBox.scrollHeight;
      }, 800);
    }
  </script>
</body>
</html>
