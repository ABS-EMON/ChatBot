<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EMON AI Chat</title>
<script src="https://cdn.tailwindcss.com/3.4.16"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:'#4F46E5',secondary:'#10B981'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
<style>
:where([class^="ri-"])::before { content: "\f3c2"; }
body {
font-family: 'Inter', sans-serif;
overflow: hidden;
}
.chat-container {
height: calc(100vh - 80px);
overflow-y: auto;
}
.typing-animation span {
animation: blink 1.4s infinite both;
}
.typing-animation span:nth-child(2) {
animation-delay: 0.2s;
}
.typing-animation span:nth-child(3) {
animation-delay: 0.4s;
}
@keyframes blink {
0% { opacity: 0.1; }
20% { opacity: 1; }
100% { opacity: 0.1; }
}
.scrollbar-hide::-webkit-scrollbar {
display: none;
}
.scrollbar-hide {
-ms-overflow-style: none;
scrollbar-width: none;
}
input[type="range"] {
-webkit-appearance: none;
width: 100%;
height: 4px;
background: #e5e7eb;
border-radius: 4px;
outline: none;
}
input[type="range"]::-webkit-slider-thumb {
-webkit-appearance: none;
width: 16px;
height: 16px;
border-radius: 50%;
background: #4F46E5;
cursor: pointer;
}
.custom-switch {
position: relative;
display: inline-block;
width: 44px;
height: 22px;
}
.custom-switch input {
opacity: 0;
width: 0;
height: 0;
}
.switch-slider {
position: absolute;
cursor: pointer;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: #e5e7eb;
transition: .4s;
border-radius: 34px;
}
.switch-slider:before {
position: absolute;
content: "";
height: 18px;
width: 18px;
left: 2px;
bottom: 2px;
background-color: white;
transition: .4s;
border-radius: 50%;
}
input:checked + .switch-slider {
background-color: #4F46E5;
}
input:checked + .switch-slider:before {
transform: translateX(22px);
}
.editable-title {
cursor: pointer;
}
.editable-title-input {
width: 100%;
background: transparent;
border: none;
border-bottom: 1px solid #4F46E5;
font-size: 1rem;
font-weight: 500;
color: #1f2937;
outline: none;
padding: 2px 0;
}
</style>
</head>
<body class="bg-gray-50">
<div id="delete-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 shadow-xl">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Delete Conversation</h3>
    <p class="text-gray-600 mb-6">Are you sure you want to delete this conversation?</p>
    <div class="flex justify-end gap-3">
      <button id="cancel-delete" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 !rounded-button whitespace-nowrap">Cancel</button>
      <button id="confirm-delete" class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 !rounded-button whitespace-nowrap">Delete</button>
    </div>
  </div>
</div>
<div class="flex h-screen">
<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-white border-r border-gray-200 h-full flex flex-col transition-all duration-300 transform translate-x-0 md:relative absolute z-10">
<div class="p-4 border-b border-gray-200 flex justify-between items-center">
<h1 class="text-xl font-['Pacifico'] text-primary">EMON AI Chat</h1>
<button id="close-sidebar" class="md:hidden w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-close-line ri-lg"></i>
</button>
</div>
<div class="p-4">
<button id="new-chat" class="w-full bg-primary text-white py-2 px-4 !rounded-button flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors whitespace-nowrap">
<i class="ri-add-line"></i>
<span>New Chat</span>
</button>
</div>
<div class="flex-1 overflow-y-auto scrollbar-hide">
<div class="p-4 space-y-2">
<div class="chat-item bg-gray-100 p-3 rounded hover:bg-gray-200 cursor-pointer relative group" data-chat-id="chat_1">
<div class="flex justify-between items-start">
<div class="flex items-start gap-3">
<div class="w-5 h-5 flex items-center justify-center mt-1">
<i class="ri-message-3-line text-gray-600"></i>
</div>
<div>
<h3 class="font-medium text-gray-800 editable-title">AI Image Generation</h3>
<p class="text-xs text-gray-500">July 2, 2025</p>
</div>
</div>
<div class="hidden group-hover:flex gap-1">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-btn">
<i class="ri-edit-line ri-sm"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line ri-sm"></i>
</button>
</div>
</div>
</div>
<div class="chat-item p-3 rounded hover:bg-gray-100 cursor-pointer relative group" data-chat-id="chat_2">
<div class="flex justify-between items-start">
<div class="flex items-start gap-3">
<div class="w-5 h-5 flex items-center justify-center mt-1">
<i class="ri-message-3-line text-gray-600"></i>
</div>
<div>
<h3 class="font-medium text-gray-800 editable-title">Code Optimization Help</h3>
<p class="text-xs text-gray-500">July 1, 2025</p>
</div>
</div>
<div class="hidden group-hover:flex gap-1">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-btn">
<i class="ri-edit-line ri-sm"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line ri-sm"></i>
</button>
</div>
</div>
</div>
<div class="chat-item p-3 rounded hover:bg-gray-100 cursor-pointer relative group" data-chat-id="chat_3">
<div class="flex justify-between items-start">
<div class="flex items-start gap-3">
<div class="w-5 h-5 flex items-center justify-center mt-1">
<i class="ri-message-3-line text-gray-600"></i>
</div>
<div>
<h3 class="font-medium text-gray-800 editable-title">Travel Itinerary Planning</h3>
<p class="text-xs text-gray-500">June 28, 2025</p>
</div>
</div>
<div class="hidden group-hover:flex gap-1">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-btn">
<i class="ri-edit-line ri-sm"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line ri-sm"></i>
</button>
</div>
</div>
</div>
<div class="chat-item p-3 rounded hover:bg-gray-100 cursor-pointer relative group" data-chat-id="chat_4">
<div class="flex justify-between items-start">
<div class="flex items-start gap-3">
<div class="w-5 h-5 flex items-center justify-center mt-1">
<i class="ri-message-3-line text-gray-600"></i>
</div>
<div>
<h3 class="font-medium text-gray-800 editable-title">Recipe Recommendations</h3>
<p class="text-xs text-gray-500">June 25, 2025</p>
</div>
</div>
<div class="hidden group-hover:flex gap-1">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-btn">
<i class="ri-edit-line ri-sm"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line ri-sm"></i>
</button>
</div>
</div>
</div>
<div class="chat-item p-3 rounded hover:bg-gray-100 cursor-pointer relative group" data-chat-id="chat_5">
<div class="flex justify-between items-start">
<div class="flex items-start gap-3">
<div class="w-5 h-5 flex items-center justify-center mt-1">
<i class="ri-message-3-line text-gray-600"></i>
</div>
<div>
<h3 class="font-medium text-gray-800 editable-title">Fitness Plan Creation</h3>
<p class="text-xs text-gray-500">June 20, 2025</p>
</div>
</div>
<div class="hidden group-hover:flex gap-1">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-btn">
<i class="ri-edit-line ri-sm"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line ri-sm"></i>
</button>
</div>
</div>
</div>
</div>
</div>
<div class="p-4 border-t border-gray-200">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
<span class="text-sm font-medium">JD</span>
</div>
<span class="text-sm font-medium">John Doe</span>
</div>
<div class="flex items-center">
<label class="custom-switch">
<input type="checkbox" id="theme-toggle">
<span class="switch-slider"></span>
</label>
</div>
</div>
</div>
</div>
<!-- Main Content -->
<div class="flex-1 flex flex-col h-screen relative">
<!-- Header -->
<div class="h-14 border-b border-gray-200 flex items-center px-4 bg-white">
<button id="open-sidebar" class="md:hidden w-10 h-10 flex items-center justify-center text-gray-500 hover:text-gray-700 mr-2">
<i class="ri-menu-line ri-lg"></i>
</button>
<h2 id="chat-title" class="text-lg font-medium text-gray-800">AI Image Generation</h2>
</div>
<!-- Chat Container -->
<div id="chat-container" class="chat-container p-4 flex-1 overflow-y-auto scrollbar-hide bg-white">
<!-- Welcome Message -->
<div class="flex items-start mb-6">
<div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0">
<i class="ri-robot-line"></i>
</div>
<div class="bg-gray-100 rounded-lg p-4 max-w-[80%]">
<p class="text-gray-800">
Hello! I'm EmonBot, your AI assistant. How can I help you today? I can assist with a wide range of tasks including:
</p>
<ul class="list-disc pl-5 mt-2 text-gray-700">
<li>Answering questions and providing information</li>
<li>Generating creative content like stories or ideas</li>
<li>Helping with coding and programming tasks</li>
<li>Assisting with planning and organization</li>
<li>Providing recommendations based on your preferences</li>
</ul>
<p class="mt-2 text-gray-800">
Feel free to ask me anything!
</p>
</div>
</div>
<!-- User Message -->
<div class="flex items-start justify-end mb-6">
<div class="bg-primary text-white rounded-lg p-4 max-w-[80%]">
<p>
Can you help me generate some creative ideas for a digital art project? I'm looking to create something with a cyberpunk theme.
</p>
</div>
<div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 ml-3 flex-shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
</div>
<!-- AI Message -->
<div class="flex items-start mb-6">
<div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0">
<i class="ri-robot-line"></i>
</div>
<div class="bg-gray-100 rounded-lg p-4 max-w-[80%]">
<p class="text-gray-800">
Absolutely! Here are some creative cyberpunk-themed digital art project ideas:
</p>
<ol class="list-decimal pl-5 mt-2 text-gray-700 space-y-2">
<li>
<strong>Neon-Lit Urban Landscape:</strong> Create a futuristic cityscape with towering skyscrapers covered in holographic advertisements, neon signs, and flying vehicles. Include contrasting elements like rain-slicked streets reflecting the vibrant lights above.
</li>
<li>
<strong>Human-Machine Hybrid Portrait:</strong> Design a character that blends human and technological elements - perhaps with cybernetic implants, digital interfaces embedded in skin, or glowing circuit patterns beneath translucent flesh.
</li>
<li>
<strong>Digital Decay:</strong> Explore the concept of technological deterioration by creating glitched, corrupted digital environments or characters. Use techniques like pixel sorting, data moshing, or fragmented elements.
</li>
<li>
<strong>Corporate Dystopia:</strong> Visualize a world dominated by mega-corporations with their logos and branding integrated into every aspect of life - from architecture to clothing to implanted technology.
</li>
<li>
<strong>Underground Resistance:</strong> Depict hackers or rebels operating from hidden locations, surrounded by jury-rigged technology, fighting against corporate or governmental control.
</li>
</ol>
<p class="mt-3 text-gray-800">
Would you like me to elaborate on any of these ideas or suggest some specific visual techniques that would enhance the cyberpunk aesthetic?
</p>
</div>
</div>
<!-- User Message -->
<div class="flex items-start justify-end mb-6">
<div class="bg-primary text-white rounded-lg p-4 max-w-[80%]">
<p>
I really like the neon-lit urban landscape idea. Could you suggest some specific elements I should include to make it more authentic to the cyberpunk genre?
</p>
</div>
<div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 ml-3 flex-shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
</div>
<!-- AI Typing Animation -->
<div class="flex items-start mb-6">
<div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0">
<i class="ri-robot-line"></i>
</div>
<div class="bg-gray-100 rounded-lg p-4 max-w-[80%] flex items-center">
<div class="typing-animation">
<span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-1"></span>
<span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-1"></span>
<span class="inline-block w-2 h-2 bg-gray-500 rounded-full"></span>
</div>
</div>
</div>
</div>
<!-- Input Area -->
<div class="border-t border-gray-200 bg-white p-4">
<div id="tools-tray" class="hidden mb-3 p-2 bg-gray-50 rounded-lg flex flex-wrap gap-2">
<button class="bg-white border border-gray-200 text-gray-700 py-1 px-3 !rounded-button flex items-center gap-1 text-sm hover:bg-gray-50 whitespace-nowrap">
<i class="ri-image-line"></i>
<span>Image</span>
</button>
<button class="bg-white border border-gray-200 text-gray-700 py-1 px-3 !rounded-button flex items-center gap-1 text-sm hover:bg-gray-50 whitespace-nowrap">
<i class="ri-file-line"></i>
<span>File</span>
</button>
<button class="bg-white border border-gray-200 text-gray-700 py-1 px-3 !rounded-button flex items-center gap-1 text-sm hover:bg-gray-50 whitespace-nowrap">
<i class="ri-code-s-slash-line"></i>
<span>Code Block</span>
</button>
<button class="bg-white border border-gray-200 text-gray-700 py-1 px-3 !rounded-button flex items-center gap-1 text-sm hover:bg-gray-50 whitespace-nowrap">
<i class="ri-table-line"></i>
<span>Table</span>
</button>
<button class="bg-white border border-gray-200 text-gray-700 py-1 px-3 !rounded-button flex items-center gap-1 text-sm hover:bg-gray-50 whitespace-nowrap">
<i class="ri-list-check"></i>
<span>List</span>
</button>
</div>
<div class="relative">
<div class="absolute left-3 top-1/2 transform -translate-y-1/2">
<button id="toggle-tools" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-add-line ri-lg"></i>
</button>
</div>
<textarea id="message-input" class="w-full border border-gray-200 rounded-lg py-3 px-12 focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none" rows="1" placeholder="Message EmonBot..."></textarea>
<div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center">
<button id="voice-input" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 mr-1">
<i class="ri-mic-line ri-lg"></i>
</button>
<button id="send-message" class="w-8 h-8 flex items-center justify-center text-primary hover:text-primary/80 disabled:text-gray-300" disabled>
<i class="ri-send-plane-fill ri-lg"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-2 text-center">
EMON AI may produce inaccurate information. Your conversations are used to improve the service.
</div>
</div>
</div>
</div>
<script id="sidebar-toggle-script">
document.addEventListener('DOMContentLoaded', function() {
const sidebar = document.getElementById('sidebar');
const openSidebarBtn = document.getElementById('open-sidebar');
const closeSidebarBtn = document.getElementById('close-sidebar');
function openSidebar() {
sidebar.classList.remove('translate-x-0');
sidebar.classList.remove('-translate-x-full');
sidebar.classList.add('translate-x-0');
}
function closeSidebar() {
sidebar.classList.remove('translate-x-0');
sidebar.classList.add('-translate-x-full');
}
openSidebarBtn.addEventListener('click', openSidebar);
closeSidebarBtn.addEventListener('click', closeSidebar);
// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
const isMobile = window.innerWidth < 768;
const isClickInsideSidebar = sidebar.contains(event.target);
const isClickOnOpenButton = openSidebarBtn.contains(event.target);
if (isMobile && !isClickInsideSidebar && !isClickOnOpenButton && sidebar.classList.contains('translate-x-0')) {
closeSidebar();
}
});
// Handle window resize
window.addEventListener('resize', function() {
if (window.innerWidth >= 768) {
openSidebar();
}
});
});
</script>
<script id="chat-input-script">
document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('message-input');
    const deleteModal = document.getElementById('delete-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const sendButton = document.getElementById('send-message');
    const chatContainer = document.getElementById('chat-container');
    const toolsToggle = document.getElementById('toggle-tools');
    const toolsTray = document.getElementById('tools-tray');
    const newChatButton = document.getElementById('new-chat');
    const chatTitle = document.getElementById('chat-title');
    const chatList = document.querySelector('.p-4.space-y-2');
    
    let currentChatId = 'chat_1';
    let chats = {};
    
    // Initialize chat data
    function initChats() {
        // Sample chats
        chats = {
            'chat_1': {
                title: 'AI Image Generation',
                messages: document.querySelector('#chat-container').innerHTML
            },
            'chat_2': {
                title: 'Code Optimization Help',
                messages: '<div class="flex items-start mb-6"><div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0"><i class="ri-robot-line"></i></div><div class="bg-gray-100 rounded-lg p-4 max-w-[80%]"><p class="text-gray-800">This is the beginning of your "Code Optimization Help" conversation.</p></div></div>'
            },
            'chat_3': {
                title: 'Travel Itinerary Planning',
                messages: '<div class="flex items-start mb-6"><div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0"><i class="ri-robot-line"></i></div><div class="bg-gray-100 rounded-lg p-4 max-w-[80%]"><p class="text-gray-800">This is the beginning of your "Travel Itinerary Planning" conversation.</p></div></div>'
            },
            'chat_4': {
                title: 'Recipe Recommendations',
                messages: '<div class="flex items-start mb-6"><div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0"><i class="ri-robot-line"></i></div><div class="bg-gray-100 rounded-lg p-4 max-w-[80%]"><p class="text-gray-800">This is the beginning of your "Recipe Recommendations" conversation.</p></div></div>'
            },
            'chat_5': {
                title: 'Fitness Plan Creation',
                messages: '<div class="flex items-start mb-6"><div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0"><i class="ri-robot-line"></i></div><div class="bg-gray-100 rounded-lg p-4 max-w-[80%]"><p class="text-gray-800">This is the beginning of your "Fitness Plan Creation" conversation.</p></div></div>'
            }
        };
        
        // Save to localStorage
        localStorage.setItem('emon_chats', JSON.stringify(chats));
    }
    
    // Load chats from localStorage or initialize
    function loadChats() {
        const savedChats = localStorage.getItem('emon_chats');
        if (savedChats) {
            chats = JSON.parse(savedChats);
        } else {
            initChats();
        }
    }
    
    // Save chats to localStorage
    function saveChats() {
        localStorage.setItem('emon_chats', JSON.stringify(chats));
    }
    
    // Switch to a specific chat
    function switchChat(chatId) {
        if (chats[chatId]) {
            currentChatId = chatId;
            chatTitle.textContent = chats[chatId].title;
            chatContainer.innerHTML = chats[chatId].messages;
            
            // Update active state in sidebar
            document.querySelectorAll('.chat-item').forEach(item => {
                if (item.getAttribute('data-chat-id') === chatId) {
                    item.classList.add('bg-gray-100');
                    item.querySelector('h3').textContent = chats[chatId].title;
                } else {
                    item.classList.remove('bg-gray-100');
                }
            });
            
            // Scroll to bottom
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }
    
    // Create a new chat
    function createNewChat() {
        const newChatId = 'chat_' + Date.now();
        const currentDate = new Date();
        const formattedDate = currentDate.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
        
        // Create chat data
        chats[newChatId] = {
            title: 'New Chat',
            messages: '<div class="flex items-start mb-6"><div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0"><i class="ri-robot-line"></i></div><div class="bg-gray-100 rounded-lg p-4 max-w-[80%]"><p class="text-gray-800">This is the beginning of your new conversation.</p></div></div>'
        };
        
        // Create sidebar item
        const newChatItem = document.createElement('div');
        newChatItem.className = 'chat-item bg-gray-100 p-3 rounded hover:bg-gray-200 cursor-pointer relative group';
        newChatItem.setAttribute('data-chat-id', newChatId);
        newChatItem.innerHTML = `
            <div class="flex justify-between items-start">
                <div class="flex items-start gap-3">
                    <div class="w-5 h-5 flex items-center justify-center mt-1">
                        <i class="ri-message-3-line text-gray-600"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800 editable-title">New Chat</h3>
                        <p class="text-xs text-gray-500">${formattedDate}</p>
                    </div>
                </div>
                <div class="hidden group-hover:flex gap-1">
                    <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-btn">
                        <i class="ri-edit-line ri-sm"></i>
                    </button>
                    <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
                        <i class="ri-delete-bin-line ri-sm"></i>
                    </button>
                </div>
            </div>
        `;
        
        // Add to top of sidebar
        chatList.insertBefore(newChatItem, chatList.firstChild);
        
        // Switch to the new chat
        switchChat(newChatId);
        
        // Add event listeners
        addChatEventListeners(newChatItem);
        
        // Save to localStorage
        saveChats();
    }
    
    // Rename a chat
    function renameChat(chatId, newTitle) {
        if (chats[chatId] && newTitle.trim() !== '') {
            chats[chatId].title = newTitle;
            chatTitle.textContent = newTitle;
            
            // Update in sidebar
            document.querySelectorAll(`[data-chat-id="${chatId}"] h3`).forEach(title => {
                title.textContent = newTitle;
            });
            
            saveChats();
        }
    }
    
    // Delete a chat
    function deleteChat(chatId) {
        if (chats[chatId]) {
            delete chats[chatId];
            
            // Remove from sidebar
            document.querySelectorAll(`[data-chat-id="${chatId}"]`).forEach(item => {
                item.remove();
            });
            
            // If we deleted the current chat, create a new one
            if (chatId === currentChatId) {
                createNewChat();
            }
            
            saveChats();
        }
    }
    
    // Add event listeners to a chat item
    function addChatEventListeners(chatItem) {
        const chatId = chatItem.getAttribute('data-chat-id');
        
        // Click to switch chat
        chatItem.addEventListener('click', function(e) {
            if (!e.target.closest('.rename-btn') && !e.target.closest('.ri-delete-bin-line')) {
                switchChat(chatId);
            }
        });
        
        // Rename button
        const renameBtn = chatItem.querySelector('.rename-btn');
        renameBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const titleElement = chatItem.querySelector('h3');
            const currentTitle = titleElement.textContent;
            
            // Create input field
            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentTitle;
            input.className = 'editable-title-input';
            
            // Replace title with input
            titleElement.replaceWith(input);
            input.focus();
            
            // Handle save
            function saveTitle() {
                const newTitle = input.value.trim() || 'New Chat';
                renameChat(chatId, newTitle);
                input.replaceWith(titleElement);
                titleElement.textContent = newTitle;
                document.removeEventListener('click', outsideClick);
            }
            
            // Save on Enter
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    saveTitle();
                }
            });
            
            // Save on blur
            input.addEventListener('blur', saveTitle);
            
            // Click outside to save
            function outsideClick(e) {
                if (!chatItem.contains(e.target)) {
                    saveTitle();
                }
            }
            
            document.addEventListener('click', outsideClick);
        });
        
        // Delete button
        const deleteBtn = chatItem.querySelector('.ri-delete-bin-line')?.parentElement;
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                showDeleteModal(chatId);
            });
        }
    }
    
    // Show delete confirmation modal
    function showDeleteModal(chatId) {
        deleteModal.dataset.chatId = chatId;
        deleteModal.classList.remove('hidden');
    }
    
    // Hide delete modal
    function hideDeleteModal() {
        deleteModal.classList.add('hidden');
    }
    
    // Confirm delete
    function confirmDelete() {
        const chatId = deleteModal.dataset.chatId;
        if (chatId) {
            deleteChat(chatId);
            hideDeleteModal();
        }
    }
    
    // Initialize
    loadChats();
    
    // Add event listeners to all existing chat items
    document.querySelectorAll('.chat-item').forEach(chatItem => {
        addChatEventListeners(chatItem);
    });
    
    // Set first chat as active
    switchChat(currentChatId);
    
    // Event listeners
    newChatButton.addEventListener('click', createNewChat);
    
    cancelDeleteBtn.addEventListener('click', hideDeleteModal);
    confirmDeleteBtn.addEventListener('click', confirmDelete);
    
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            hideDeleteModal();
        }
    });
    
    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        
        // Enable/disable send button
        if (this.value.trim() === '') {
            sendButton.disabled = true;
            sendButton.classList.add('text-gray-300');
            sendButton.classList.remove('text-primary', 'hover:text-primary/80');
        } else {
            sendButton.disabled = false;
            sendButton.classList.remove('text-gray-300');
            sendButton.classList.add('text-primary', 'hover:text-primary/80');
        }
    });
    
    // Toggle tools tray
    toolsToggle.addEventListener('click', function() {
        toolsTray.classList.toggle('hidden');
        // Change icon based on state
        const icon = this.querySelector('i');
        if (toolsTray.classList.contains('hidden')) {
            icon.classList.remove('ri-close-line');
            icon.classList.add('ri-add-line');
        } else {
            icon.classList.remove('ri-add-line');
            icon.classList.add('ri-close-line');
        }
    });
    
    // Send message function
    function sendMessage() {
        const message = messageInput.value.trim();
        if (message === '') return;
        
        // Add user message to chat
        const userMessageHTML = `
            <div class="flex items-start justify-end mb-6">
                <div class="bg-primary text-white rounded-lg p-4 max-w-[80%]">
                    <p>${message}</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 ml-3 flex-shrink-0">
                    <span class="text-sm font-medium">JD</span>
                </div>
            </div>
        `;
        
        // Add to chat container
        chatContainer.insertAdjacentHTML('beforeend', userMessageHTML);
        
        // Add typing animation
        const typingHTML = `
            <div class="flex items-start mb-6 typing-container">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0">
                    <i class="ri-robot-line"></i>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 max-w-[80%] flex items-center">
                    <div class="typing-animation">
                        <span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-1"></span>
                        <span class="inline-block w-2 h-2 bg-gray-500 rounded-full mr-1"></span>
                        <span class="inline-block w-2 h-2 bg-gray-500 rounded-full"></span>
                    </div>
                </div>
            </div>
        `;
        chatContainer.insertAdjacentHTML('beforeend', typingHTML);
        
        // Clear input and reset height
        messageInput.value = '';
        messageInput.style.height = 'auto';
        sendButton.disabled = true;
        sendButton.classList.add('text-gray-300');
        sendButton.classList.remove('text-primary', 'hover:text-primary/80');
        
        // Scroll to bottom
        chatContainer.scrollTop = chatContainer.scrollHeight;
        
        // Simulate AI response after delay
        setTimeout(() => {
            // Remove typing animation
            const typingContainer = document.querySelector('.typing-container');
            if (typingContainer) {
                typingContainer.remove();
            }
            
            // Add AI response
            const aiResponseHTML = `
                <div class="flex items-start mb-6">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 flex-shrink-0">
                        <i class="ri-robot-line"></i>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4 max-w-[80%]">
                        <p class="text-gray-800">
                            For an authentic cyberpunk neon-lit urban landscape, consider including these key elements:
                        </p>
                        <ul class="list-disc pl-5 mt-2 text-gray-700 space-y-1">
                            <li><strong>Architectural Contrasts:</strong> Mix ultra-modern skyscrapers with decaying older structures to show social stratification</li>
                            <li><strong>Holographic Advertisements:</strong> Massive, animated ads featuring AI-generated models or corporate propaganda</li>
                            <li><strong>Weather Effects:</strong> Heavy rain or fog that interacts with the neon lights, creating reflections on wet surfaces</li>
                            <li><strong>Flying Vehicles:</strong> Drone taxis, corporate shuttles, or police surveillance crafts with distinctive lighting patterns</li>
                            <li><strong>Street Level Details:</strong> Food stalls with glowing signs, black market tech shops, street performers with augmented reality gear</li>
                            <li><strong>Cables and Infrastructure:</strong> Visible technology infrastructure like cables, pipes, and antenna arrays connecting buildings</li>
                            <li><strong>Lighting Hierarchy:</strong> Use color to indicate social status - perhaps blue/purple for corporate zones, red/orange for entertainment districts</li>
                        </ul>
                        <p class="mt-3 text-gray-800">
                            For the color palette, consider using:
                        </p>
                        <ul class="list-disc pl-5 mt-1 text-gray-700">
                            <li>Deep blues and purples for the night sky and shadows</li>
                            <li>Bright pinks, cyans, and electric blues for neon signs and holographics</li>
                            <li>Amber and orange for street-level lighting</li>
                            <li>Reflective teals and violets for wet surfaces</li>
                        </ul>
                        <p class="mt-3 text-gray-800">
                            Would you like me to suggest some specific composition ideas or reference artists who excel at cyberpunk cityscapes?
                        </p>
                    </div>
                </div>
            `;
            chatContainer.insertAdjacentHTML('beforeend', aiResponseHTML);
            
            // Save the updated chat
            chats[currentChatId].messages = chatContainer.innerHTML;
            saveChats();
            
            // Scroll to bottom again
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }, 2000);
    }
    
    // Send message on button click
    sendButton.addEventListener('click', sendMessage);
    
    // Send message on Enter key (but allow Shift+Enter for new line)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!sendButton.disabled) {
                sendMessage();
            }
        }
    });
});
</script>
<script id="theme-toggle-script">
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
        themeToggle.checked = true;
    }
    
    // Toggle theme
    themeToggle.addEventListener('change', function() {
        if (this.checked) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    });
});
</script>
</body>
</html>