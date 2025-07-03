<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>EMON AI Chat</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2B6BE6',
            secondary: '#6B7280',
            darkbg: '#121212',
            darkgray: '#2c2c2c',
            darktext: '#e5e7eb',
          },
          borderRadius: {
            button: '8px',
          },
        },
      },
    };
  </script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
  
  <style>
    /* Your styles remain unchanged */
    body {
    font-family: 'Inter', sans-serif;
    overflow: hidden;
    height: 100vh;
    background-color: white;
    color: #1f2937; /* default dark gray text */
    transition: background-color 0.3s, color 0.3s;
  }
  body.dark {
    background-color: #121212;
    color: #e5e7eb;
  }
  /* Sidebar dark styles */
  #sidebar.dark {
    background-color: #1f1f1f;
    color: #e5e7eb;
    border-color: #444;
  }
  #sidebar.dark .chat-item:hover {
    background-color: #333;
  }
  #sidebar.dark .chat-item {
    color: #e5e7eb;
  }
  #sidebar.dark button,
  #sidebar.dark .text-gray-500 {
    color: #aaa;
  }
  #sidebar.dark button:hover {
    color: #fff;
  }
  /* Scrollbar dark mode */
  body.dark .chat-container::-webkit-scrollbar-thumb,
  body.dark .chat-history::-webkit-scrollbar-thumb {
    background-color: #444;
  }
  /* Message bubbles */
  .message-bubble {
    max-width: 75%;
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    white-space: pre-wrap;
  }
  .message-user {
    background-color: #2b6be6;
    color: white;
    margin-left: auto;
  }
  body.dark .message-user {
    background-color: #3b82f6;
  }
  .message-assistant {
    background-color: #e5e7eb;
    color: #1f2937;
    margin-right: auto;
  }
  body.dark .message-assistant {
    background-color: #333;
    color: #e5e7eb;
  }
  /* Input area */
  #message-input {
    min-height: 44px;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    border: 1px solid #d1d5db;
    background-color: white;
    resize: none;
    outline: none;
    overflow-y: auto;
    flex: 1;
    color: inherit;
  }
  body.dark #message-input {
    background-color: #1f1f1f;
    border-color: #444;
    color: #e5e7eb;
  }
  #message-input:empty:before {
    content: attr(data-placeholder);
    color: #9ca3af;
  }
  body.dark #message-input:empty:before {
    color: #6b7280;
  }
  /* Send button styles */
  #send-button {
    background-color: #2b6be6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
  }
  #send-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  #send-button:hover:not(:disabled) {
    background-color: #1e4db7;
  }
  /* + icon and voice icon container */
  .input-icons {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .icon-button {
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #6b7280;
    transition: background-color 0.2s, color 0.2s;
  }
  .icon-button:hover {
    background-color: #e5e7eb;
    color: #2b6be6;
  }
  body.dark .icon-button:hover {
    background-color: #333;
    color: #3b82f6;
  }
  /* Sidebar user info */
  #user-info {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
  }
  body.dark #user-info {
    border-color: #444;
  }
  #user-initials {
    background-color: #2b6be6;
    color: white;
    font-weight: 700;
    font-size: 1.125rem;
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
  }
  #user-name {
    font-weight: 600;
    font-size: 1rem;
  }
  #user-plan {
    font-size: 0.75rem;
    color: #6b7280;
  }
  body.dark #user-plan {
    color: #9ca3af;
  }

/* Dark mode toggle switch */
.toggle-label {
  position: relative;
  display: inline-block;
  width: 48px;
  height: 24px;
  background-color: #e5e7eb;
  border-radius: 100px;
  transition: background-color 0.3s ease;
  cursor: pointer;
}

.toggle-label::after {
  content: '';
  position: absolute;
  top: 2px;
  left: 2px;
  width: 20px;
  height: 20px;
  background-color: white;
  border-radius: 50%;
  transition: transform 0.3s ease;
}

input#dark-mode-toggle:checked + .toggle-label {
  background-color: #2b6be6;
}

input#dark-mode-toggle:checked + .toggle-label::after {
  transform: translateX(24px); /* slide the circle */
}

 
  /* Hide checkbox */
  input#dark-mode-toggle {
    height: 0;
    width: 0;
    visibility: hidden;
    position: absolute;
  }
  </style>
</head>
<body>
  <!-- Your existing HTML layout remains unchanged -->
     <div class="flex h-screen">
    <!-- Left Sidebar -->
    <aside
  id="sidebar"
  class="w-[280px] h-full flex flex-col justify-between border-r border-gray-200 bg-white transition-all duration-300 ease-in-out"
>
  <!-- Sidebar Header -->
  <div
    class="h-16 px-4 py-3 flex items-center justify-between border-b border-gray-200"
  >
    

    <div class="flex items-center">
    <span class="text-xl font-['Pacifico'] text-primary">🤖</span>
    <span class="ml-2 font-semibold">EMON AI Chat</span>
    </div>

    <button
      id="collapse-sidebar"
      class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 md:hidden"
    >
      <i class="ri-arrow-left-line ri-lg"></i>
    </button>
  </div>

  <!-- New Chat Button -->
  <div class="px-4 py-3">
    <button
      id="new-chat-button"
      class="w-full bg-primary text-white py-2 px-4 flex items-center justify-center gap-2 !rounded-button hover:bg-primary/90 transition-colors whitespace-nowrap"
    >
      <i class="ri-add-line"></i>
      <span>New Chat</span>
    </button>
  </div>

  <!-- Chat History -->
  <div class="flex-1 overflow-y-auto chat-history px-2" id="chat-history">
    <div class="text-xs font-medium text-gray-500 px-2 py-2">RECENT CHATS</div>
    <!-- Chats loaded dynamically here -->
  </div>

  <!-- User Info and Dark Mode (bottom section) -->
  <div id="user-info" class="flex items-center justify-between gap-4 p-4 border-t border-gray-200">
    <div class="flex items-center gap-3">
      <div id="user-initials">EM</div>
      <div>
        <div id="user-name">EMON AI </div>
        <div id="user-plan">Premium Plan</div>
      </div>
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" id="dark-mode-toggle" hidden />
        <label for="dark-mode-toggle" class="toggle-label" title="Toggle Dark Mode"></label>
        <i class="ri-moon-line text-gray-500" title="Dark Mode Icon"></i>
    </div>

  </div>
</aside>


    <!-- Main Chat Area -->
    <main class="flex-1 flex flex-col relative bg-gray-50 transition-colors duration-300" id="main-chat-area">
    
    <!-- Current Chat Title -->
    <div id="chat-title-bar" class="px-6 py-4 border-b border-gray-200 text-xl font-semibold hidden">
    <!-- Will be filled dynamically -->
    </div>

    
    <!-- Welcome Section for New Chat -->
      <div
        id="welcome-section"
        class="flex flex-col items-center justify-center h-full max-w-2xl mx-auto text-center px-4"
      >
        <div
          class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6"
        >
          <i class="ri-robot-line ri-2x text-primary"></i>
        </div>
        <h1 class="text-2xl font-bold mb-2">Welcome to EMON AI Chat</h1>
        
        <p class="text-gray-600 mb-8">
            <span class="text-xl font-['Pacifico'] text-primary">Ask me anything or try one of these examples:</span>
        
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
          <button
            class="example-btn bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap"
          >
            Write a blog post about AI ethics
          </button>
          <button
            class="example-btn bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap"
          >
            Explain quantum computing simply
          </button>
          <button
            class="example-btn bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap"
          >
            Help me plan a 7-day trip to Japan
          </button>
          <button
            class="example-btn bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap"
          >
            Create a workout routine for beginners
          </button>
        </div>
      </div>

      <!-- Chat Messages Container -->
      <div
        id="chat-messages"
        class="flex-1 overflow-y-auto p-6 chat-container hidden max-w-4xl mx-auto"
      >
        <!-- Messages will be dynamically added here -->
      </div>

      <!-- Message Input Area -->
      <div
        id="message-input-area"
        class="flex items-center gap-3 px-6 py-4 border-t border-gray-200 max-w-4xl mx-auto bg-white transition-colors duration-300"
      >
        <div class="input-icons flex gap-2 items-center">
          <button
            id="add-button"
            class="icon-button p-2"
            title="Add image or code"
            aria-label="Add image or code"
            type="button"
          >
            <i class="ri-add-line ri-lg"></i>
          </button>
          <button
            id="voice-button"
            class="icon-button p-2"
            title="Voice input (demo)"
            aria-label="Voice input"
            type="button"
          >
            <i class="ri-mic-line ri-lg"></i>
          </button>
        </div>

        <div
          id="message-input"
          contenteditable="true"
          role="textbox"
          aria-multiline="true"
          data-placeholder="Type your message here..."
          class="message-input flex-1 min-h-[44px]"
        ></div>

        <button
          id="send-button"
          disabled
          class="bg-primary text-white px-4 py-2 rounded-button disabled:opacity-50 disabled:cursor-not-allowed"
          aria-label="Send message"
        >
          Send
        </button>
      </div>
    </main>
  </div>

<script>
const chats = {};
const messageInput = document.getElementById('message-input');
const sendButton = document.getElementById('send-button');
const newChatButton = document.getElementById('new-chat-button');
const chatMessages = document.getElementById('chat-messages');
const welcomeSection = document.getElementById('welcome-section');
const chatHistory = document.getElementById('chat-history');

let currentChatId = null;

async function loadChatsFromDB() {
  const res = await fetch('/chats');
  const data = await res.json();

  data.forEach(chat => {
    chats[chat.id] = {
      id: chat.id,
      title: chat.title,
      messages: chat.messages,
    };
  });

  loadChatsToSidebar();

  // 🔄 Restore last chat
  const savedChatId = localStorage.getItem('currentChatId');
  if (savedChatId && chats[savedChatId]) {
    switchChat(savedChatId);
  }
}


async function startNewChat() {
  const res = await fetch('/chats', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ title: 'New Chat' }),
  });

  const chat = await res.json();
  chat.messages = [];

  chats[chat.id] = chat;

  // Add chat to sidebar
  const newChatItem = createChatSidebarItem(chat);
 const recentLabel = chatHistory.querySelector('div.text-xs');
 chatHistory.insertBefore(newChatItem, recentLabel.nextSibling);


  // ✅ Set currentChatId
  currentChatId = chat.id;
  localStorage.setItem('currentChatId', chat.id);

  // ✅ Reset UI
  welcomeSection.style.display = 'flex'; // Show welcome
  chatMessages.classList.add('hidden');  // Hide old messages
  chatMessages.innerHTML = '';           // Clear previous chat messages
  messageInput.textContent = '';         // Clear input box
  toggleSendButton();

  // 🔻 Hide chat title until user types
document.getElementById('chat-title-bar').classList.add('hidden');
}



async function sendMessage() {
  if (messageInput.textContent.trim() === '') return;

  const userMsg = {
    role: 'user',
    content: messageInput.textContent.trim(),
  };



  if (currentChatId === null) {
  await startNewChat();
}

// Remove welcome screen on first message
welcomeSection.style.display = 'none';
chatMessages.classList.remove('hidden');


 await fetch(`/chats/${currentChatId}/messages`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  body: JSON.stringify(userMsg),
});


  chats[currentChatId].messages.push(userMsg);
  renderMessages(chats[currentChatId].messages);

  messageInput.textContent = '';
  toggleSendButton();
  simulateAssistantResponse();
}

async function deleteChat(chatId, div) {
 await fetch(`/chats/${chatId}`, {
  method: 'DELETE',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
});


  delete chats[chatId];
  div.remove();
  if (currentChatId === chatId) {
  localStorage.removeItem('currentChatId'); // <-- ADD THIS
  currentChatId = null;
  chatMessages.innerHTML = '';
  chatMessages.classList.add('hidden');
  welcomeSection.style.display = 'flex';
// 🔻 Also hide the title bar
  document.getElementById('chat-title-bar').classList.add('hidden');
}

}

function createChatSidebarItem(chat) {
  const div = document.createElement('div');
  div.className = 'chat-item hover:bg-gray-100 rounded p-2 cursor-pointer group flex justify-between items-center';
  div.dataset.chatId = chat.id;
  div.innerHTML = `
    <div class="truncate font-medium">${chat.title}</div>
    <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
      <button class="edit-btn w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700" title="Edit">
        <i class="ri-edit-line"></i>
      </button>
      <button class="delete-btn w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700" title="Delete">
        <i class="ri-delete-bin-line"></i>
      </button>
    </div>
  `;
  div.addEventListener('click', () => switchChat(chat.id));


div.querySelector('.edit-btn').addEventListener('click', async (e) => {
  e.stopPropagation();
  const newTitle = prompt('Enter new chat title:', chat.title);
  if (newTitle) {
    chat.title = newTitle.trim();
    div.querySelector('div').textContent = chat.title;

    // Save to database
    await fetch(`/chats/${chat.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ title: chat.title })
    });
  }
});



  div.querySelector('.delete-btn').addEventListener('click', (e) => {
    e.stopPropagation();
    if (confirm(`Are you sure you want to delete "${chat.title}"?`)) {
      deleteChat(chat.id, div);
    }
  });
  return div;
}



function loadChatsToSidebar() {
  chatHistory.innerHTML = '<div class="text-xs font-medium text-gray-500 px-2 py-2">RECENT CHATS</div>';
  Object.values(chats)
    .sort((a, b) => b.id - a.id) // Sort descending by chat id (newest first)
    .forEach(chat => {
      const item = createChatSidebarItem(chat);
      chatHistory.appendChild(item);
    });
}


function renderMessages(messages) {
  chatMessages.innerHTML = '';

  messages.forEach((msg, index) => {
    const messageDiv = document.createElement('div');
    messageDiv.className = msg.role === 'user' ? 'mb-4 flex flex-col items-end' : 'mb-4 flex flex-col items-start';

    const bubble = document.createElement('div');
    bubble.className = msg.role === 'user' ? 'message-bubble message-user' : 'message-bubble message-assistant';
    bubble.textContent = msg.content;

    messageDiv.appendChild(bubble);

    // --- Add Edit icon under USER message ---
    if (msg.role === 'user') {
      const editBtn = document.createElement('button');
      editBtn.className = 'text-sm text-gray-400 hover:text-blue-500 mt-1 flex items-center gap-1';
      editBtn.innerHTML = `<i class="ri-edit-line"></i> Edit`;
      editBtn.onclick = () => handleEditMessage(index, msg.content);
      messageDiv.appendChild(editBtn);
    }

    // --- Add Copy icon under ASSISTANT message ---
    if (msg.role === 'assistant') {
      const copyBtn = document.createElement('button');
      copyBtn.className = 'text-sm text-gray-400 hover:text-green-500 mt-1 flex items-center gap-1';
      copyBtn.innerHTML = `<i class="ri-file-copy-line"></i> Copy`;
      copyBtn.onclick = () => {
        navigator.clipboard.writeText(msg.content);
        copyBtn.innerHTML = `<i class="ri-check-line text-green-500"></i> Copied`;
        setTimeout(() => {
          copyBtn.innerHTML = `<i class="ri-file-copy-line"></i> Copy`;
        }, 1500);
      };
      messageDiv.appendChild(copyBtn);
    }

    chatMessages.appendChild(messageDiv);
  });

  chatMessages.scrollTop = chatMessages.scrollHeight;
}


// ✅ Add this function just below renderMessages()
function handleEditMessage(index, oldContent) {
  // Put old content back into input box
  messageInput.textContent = oldContent;
  messageInput.focus();

  // 🧠 Remove both the user message and its assistant reply (next one)
  chats[currentChatId].messages.splice(index, 2); // Remove two items

  // 🔄 Re-render messages
  renderMessages(chats[currentChatId].messages);

  // ❌ Optional: also delete from DB both messages
  // You may need to update this part on your backend too to support deleting by index
  fetch(`/chats/${currentChatId}/messages/${index}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }
  });
}



function switchChat(chatId) {
  if (!chats[chatId]) return;
  currentChatId = chatId;
  localStorage.setItem('currentChatId', chatId);

  const chat = chats[chatId];

   // Set chat title
  const chatTitleBar = document.getElementById('chat-title-bar');
  chatTitleBar.textContent = chat.title;
  chatTitleBar.classList.remove('hidden');

  // 🛠 Show welcome if chat is empty
  if (chat.messages.length === 0) {
    welcomeSection.style.display = 'flex';
    chatMessages.classList.add('hidden');
  } else {
    welcomeSection.style.display = 'none';
    chatMessages.classList.remove('hidden');
    renderMessages(chat.messages);
  }

  messageInput.textContent = '';
  toggleSendButton();
}





function toggleSendButton() {
  const content = messageInput.textContent.trim();
  sendButton.disabled = content === '';
}


async function simulateAssistantResponse() {
  if (!currentChatId) return;

  const lastUserMessage = chats[currentChatId].messages
    .filter(msg => msg.role === 'user')
    .slice(-1)[0]?.content.toLowerCase();

  const assistantMsg = {
    role: 'assistant',
    content: 'Typing...'
  };

  chats[currentChatId].messages.push(assistantMsg);
  renderMessages(chats[currentChatId].messages);

  await new Promise(resolve => setTimeout(resolve, 1000));

  chats[currentChatId].messages.pop();

  let reply = "I'm sorry, I don't understand that yet.";

  if (!lastUserMessage) {
    reply = "Can you please repeat that?";
  } else if (lastUserMessage.includes("hello") || lastUserMessage.includes("hi")) {
    reply = "👋 Hello! I am EMON Chatbot. How can I help you?";
  } else if (lastUserMessage.includes("who are you")) {
    reply = "I am Emon Chatbot 🤖, your virtual assistant.";
  } else if (lastUserMessage.includes("how are you")) {
    reply = "I'm just code, but thanks for asking 😊";
  } else if (lastUserMessage.includes("name")) {
    reply = "My name is Emon AI.";
  } else if (lastUserMessage.includes("bye")) {
    reply = "Goodbye! Have a great day! 👋";
  } else if (lastUserMessage.includes("your purpose") || lastUserMessage.includes("what can you do")) {
    reply = "I can help you with general questions, provide explanations, assist with writing, and more!";
  } else if (lastUserMessage.includes("who created you")) {
    reply = "I was created by EMON using Laravel and AI technology.";
  } else if (lastUserMessage.includes("how old are you")) {
    reply = "I don’t age like humans, but I was developed quite recently!";
  } else if (lastUserMessage.includes("what is ai") || lastUserMessage.includes("define ai")) {
    reply = "AI stands for Artificial Intelligence. It refers to the simulation of human intelligence by machines.";
  } else if (lastUserMessage.includes("what is your favorite color")) {
    reply = "As an AI, I don't see or feel, but if I had to choose, I'd say blue 💙 — just like my theme!";
  } else if (lastUserMessage.includes("joke")) {
    reply = "Why don't programmers like nature?😄";
  } else if (lastUserMessage.includes("help")) {
    reply = "Sure! You can ask me questions, request writing help, coding help, or just have a fun conversation.";
  } else if (lastUserMessage.includes("thanks") || lastUserMessage.includes("thank you")) {
    reply = "You're very welcome! 😊 Let me know if you need anything else.";
  } else if (lastUserMessage.includes("god") || lastUserMessage.includes("who is allha")) {
    reply = "Allha is the Arabic word for God, used by Muslims and Arabic-speaking Christians. In Islam, Allah is the one and only God, the creator of the universe, and is central to the faith.";
  } else if (lastUserMessage.includes("explain quantum computing simply")) {
    reply = "Quantum computing is a type of computation that utilizes quantum mechanics principles to solve complex problems that are currently intractable for classical computers.😄";
  } else if (lastUserMessage.includes("workout routine") || lastUserMessage.includes("beginner workout")) {
  reply = `A simple beginner workout routine includes 3–4 days a week of 30-minute sessions:\n\n- Start with a 5-minute warm-up (jumping jacks, arm circles).\n- Do 3 sets of 10–15 reps of bodyweight exercises:\n  • Squats\n  • Push-ups (or knee push-ups)\n  • Lunges\n  • Planks (hold for 20–30 seconds)\n- Add 15–20 minutes of light cardio: brisk walking, cycling, or jogging.\n- Finish with full-body stretching to improve flexibility.\n\nRemember to rest on alternate days for recovery. 🏋️‍♂️`;
}
else if (lastUserMessage.includes("japan trip") || lastUserMessage.includes("7-day trip to japan")) {
  reply = `Here’s a 7-day Japan trip plan:\n\n**Day 1–3: Tokyo**\n• Explore Shibuya, Shinjuku, Asakusa\n• Visit Tokyo Skytree, Senso-ji Temple\n• Try local ramen and sushi\n\n**Day 4: Hakone**\n• Enjoy views of Mt. Fuji\n• Ride the Hakone Ropeway and cruise Lake Ashi\n\n**Day 5: Kyoto**\n• Fushimi Inari Shrine, Gion geisha district\n• Arashiyama Bamboo Grove, Golden Pavilion\n\n**Day 6: Nara & Osaka**\n• See Nara deer park and the Great Buddha\n• Visit Osaka Castle and street food in Dotonbori\n\n**Day 7: Depart**\n• Return to Tokyo or fly from Osaka\n• Final shopping or sightseeing 🗾✈️`;
}

else if (lastUserMessage.includes("who is your creator")) {
  reply = "I was created by ABU BAKKAR SIDDIQUE EMON — a passionate tech enthusiast, app and web developer from Bangladesh. Emon is currently studying IoT and Robotics Engineering at Bangabandhu Sheikh Mujibur Rahman Digital University. He's the developer behind platforms like EMON-LMS and Online Tools BD. He builds apps, online tools, and AI projects with Python, Java, and web technologies. I'm proud to be created by him!";
}

else if (
  lastUserMessage.toLowerCase().includes("emon") ||
  lastUserMessage.toLowerCase().includes("who is emon")
) {
  reply = "Emon is ABU BAKKAR SIDDIQUE EMON — an IoT and Robotics Engineering student from Bangladesh, passionate about app development, space robotics, and AI. He creates Android apps, websites, and online tools like EMON-LMS and Online Tools BD. Emon loves building tech solutions to help others and aims to work with advanced space and drone technologies in the future.";
}




  const assistantReply = {
    role: 'assistant',
    content: reply
  };

  chats[currentChatId].messages.push(assistantReply);
  renderMessages(chats[currentChatId].messages);

  // Save assistant reply to DB
  await fetch(`/chats/${currentChatId}/messages`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(assistantReply),
  });
}



newChatButton.addEventListener('click', startNewChat);
sendButton.addEventListener('click', sendMessage);


messageInput.addEventListener('input', toggleSendButton);
messageInput.addEventListener('keyup', toggleSendButton);
messageInput.addEventListener('paste', toggleSendButton);



messageInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' && !e.shiftKey) {
    e.preventDefault();
    if (!sendButton.disabled) sendMessage();
  }
});

document.querySelectorAll('.example-btn').forEach((btn) => {
  btn.addEventListener('click', () => {
    messageInput.textContent = btn.textContent.trim();
    toggleSendButton();
    messageInput.focus();
  });
});

// Dark Mode Toggle Handler
document.getElementById('dark-mode-toggle').addEventListener('change', function () {
  const isDark = this.checked;
  document.body.classList.toggle('dark', isDark);
  document.getElementById('sidebar').classList.toggle('dark', isDark);
  
  // Optional: save user preference
  localStorage.setItem('darkMode', isDark ? '1' : '0');
});

// Load Dark Mode Preference (if saved)
window.addEventListener('DOMContentLoaded', () => {
  const isDark = localStorage.getItem('darkMode') === '1';
  document.getElementById('dark-mode-toggle').checked = isDark;
  document.body.classList.toggle('dark', isDark);
  document.getElementById('sidebar').classList.toggle('dark', isDark);
});


// Initialize
loadChatsFromDB();
</script>
</body>
</html>
