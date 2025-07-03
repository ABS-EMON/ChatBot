<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EmonBot Pro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class', // enables class-based dark mode
    };
  </script>
</head>
<body id="body" class="bg-gray-100 text-gray-800 transition-colors duration-300">

  <!-- Start Chat Button -->
  <div id="start-screen" class="flex items-center justify-center min-h-screen">
    <button onclick="showChat()"
      class="bg-white text-blue-600 font-semibold px-6 py-3 rounded-full border border-blue-600 hover:bg-blue-600 hover:text-white transition duration-300 text-xl shadow-md">
      🚀 Start Chat
    </button>
  </div>

  <!-- Chatbot Container (Initially Hidden) -->
  <div id="chat-container" class="hidden flex flex-col items-center justify-center min-h-screen p-4">
    <div class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-xl rounded-lg w-full max-w-2xl h-[90vh] flex flex-col animate-fade-in">

      <!-- Header -->
      <div class="bg-blue-600 dark:bg-blue-700 text-white text-xl font-semibold p-4 rounded-t-lg flex justify-between items-center">
        <span>🤖 EmonBot Pro</span>
        <button onclick="toggleDarkMode()" class="text-sm bg-white text-blue-600 px-2 py-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900 dark:text-white">
          Toggle Theme
        </button>
      </div>

      <!-- Chat Box -->
      <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-900">
        <!-- Bot greeting -->
        <div class="flex items-start space-x-2">
          <div class="w-8 h-8 bg-blue-500 rounded-full text-white flex items-center justify-center">🤖</div>
          <div class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg max-w-sm">
            Hello! I’m EmonBot. How can I assist you today?
          </div>
        </div>
      </div>

      <!-- Typing Indicator -->
      <div id="typing" class="hidden px-4 py-2 text-sm text-gray-500 dark:text-gray-400">EmonBot is typing...</div>

      <!-- Input -->
      <form id="chat-form" class="p-4 border-t border-gray-200 dark:border-gray-700 flex gap-2" onsubmit="sendMessage(event)">
        <input
          id="user-input"
          type="text"
          placeholder="Ask me anything..."
          class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-900 text-black dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
        />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Send</button>
      </form>
    </div>
  </div>

  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    .animate-fade-in {
      animation: fade-in 0.5s ease-out;
    }
  </style>

  <script>
    let darkMode = false;

    function toggleDarkMode() {
      darkMode = !darkMode;
      document.documentElement.classList.toggle('dark', darkMode);
    }

    function showChat() {
      document.getElementById('start-screen').classList.add('hidden');
      document.getElementById('chat-container').classList.remove('hidden');
    }

    function sendMessage(e) {
      e.preventDefault();
      const input = document.getElementById('user-input');
      const message = input.value.trim();
      if (!message) return;

      const chatBox = document.getElementById('chat-box');

      // User message
      const userMsg = document.createElement('div');
      userMsg.classList.add('flex', 'justify-end');
      userMsg.innerHTML = `
        <div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-sm">
          ${message}
        </div>
      `;
      chatBox.appendChild(userMsg);

      input.value = '';
      chatBox.scrollTop = chatBox.scrollHeight;

      // Typing...
      const typing = document.getElementById('typing');
      typing.classList.remove('hidden');

      // Bot response after delay
      setTimeout(() => {
        typing.classList.add('hidden');

        const botMsg = document.createElement('div');
        botMsg.classList.add('flex', 'items-start', 'space-x-2');
        botMsg.innerHTML = `
          <div class="w-8 h-8 bg-blue-500 rounded-full text-white flex items-center justify-center">🤖</div>
          <div class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-lg max-w-sm">
            You said: "${message}". How else can I assist?
          </div>
        `;
        chatBox.appendChild(botMsg);
        chatBox.scrollTop = chatBox.scrollHeight;
      }, 800);
    }
  </script>
</body>
</html>
