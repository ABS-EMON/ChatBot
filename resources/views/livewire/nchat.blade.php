<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EMON AI Chat</title>
<script src="https://cdn.tailwindcss.com/3.4.16"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:'#2B6BE6',secondary:'#6B7280'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
<style>
:where([class^="ri-"])::before { content: "\f3c2"; }
body {
font-family: 'Inter', sans-serif;
overflow: hidden;
height: 100vh;
}
.typing-indicator {
display: inline-flex;
align-items: center;
}
.typing-indicator span {
width: 6px;
height: 6px;
margin: 0 1px;
background-color: #6B7280;
border-radius: 50%;
opacity: 0.6;
}
.typing-indicator span:nth-child(1) {
animation: typing 1.4s infinite 0s;
}
.typing-indicator span:nth-child(2) {
animation: typing 1.4s infinite 0.2s;
}
.typing-indicator span:nth-child(3) {
animation: typing 1.4s infinite 0.4s;
}
@keyframes typing {
0% { transform: scale(1); opacity: 0.6; }
50% { transform: scale(1.2); opacity: 1; }
100% { transform: scale(1); opacity: 0.6; }
}
.chat-container {
scrollbar-width: thin;
scrollbar-color: #E5E7EB transparent;
}
.chat-container::-webkit-scrollbar {
width: 6px;
}
.chat-container::-webkit-scrollbar-track {
background: transparent;
}
.chat-container::-webkit-scrollbar-thumb {
background-color: #E5E7EB;
border-radius: 20px;
}
.chat-history {
scrollbar-width: thin;
scrollbar-color: #E5E7EB transparent;
}
.chat-history::-webkit-scrollbar {
width: 4px;
}
.chat-history::-webkit-scrollbar-track {
background: transparent;
}
.chat-history::-webkit-scrollbar-thumb {
background-color: #E5E7EB;
border-radius: 20px;
}
input[type="checkbox"].toggle {
height: 0;
width: 0;
visibility: hidden;
position: absolute;
}
.toggle-label {
cursor: pointer;
width: 48px;
height: 24px;
background: #E5E7EB;
display: block;
border-radius: 100px;
position: relative;
transition: 0.3s;
}
.toggle-label:after {
content: '';
position: absolute;
top: 2px;
left: 2px;
width: 20px;
height: 20px;
background: #fff;
border-radius: 90px;
transition: 0.3s;
}
input:checked + .toggle-label {
background: #2B6BE6;
}
input:checked + .toggle-label:after {
left: calc(100% - 2px);
transform: translateX(-100%);
}
.message-input:focus {
outline: none;
}
.message-input:empty:before {
content: attr(data-placeholder);
color: #9CA3AF;
}
</style>
</head>
<body class="bg-white text-gray-800">
<div class="flex h-screen">
<!-- Left Sidebar -->
<aside id="sidebar" class="w-[280px] h-full flex flex-col border-r border-gray-200 bg-white transition-all duration-300 ease-in-out">
<!-- Sidebar Header -->
<div class="h-16 px-4 py-3 flex items-center justify-between border-b border-gray-200">
<div class="flex items-center">
<span class="text-xl font-['Pacifico'] text-primary">logo</span>
<span class="ml-2 font-semibold">AI Chat</span>
</div>
<button id="collapse-sidebar" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 md:hidden">
<i class="ri-arrow-left-line ri-lg"></i>
</button>
</div>
<!-- New Chat Button -->
<div class="px-4 py-3">
<button id="new-chat-button" class="w-full bg-primary text-white py-2 px-4 flex items-center justify-center gap-2 !rounded-button hover:bg-primary/90 transition-colors whitespace-nowrap">
<i class="ri-add-line"></i>
<span>New Chat</span>
</button>
</div>
<!-- Chat History -->
<div class="flex-1 overflow-y-auto chat-history px-2">
<div class="text-xs font-medium text-gray-500 px-2 py-2">RECENT CHATS</div>
<div class="chat-item hover:bg-gray-100 rounded p-2 cursor-pointer" id="project-analysis-chat">
<div class="flex justify-between items-start">
<div class="truncate font-medium">Project Analysis with AI</div>
<div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-edit-line"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-1">July 2, 2025</div>
</div>
<div class="chat-item hover:bg-gray-100 rounded p-2 cursor-pointer">
<div class="flex justify-between items-start">
<div class="truncate font-medium">Marketing Strategy Ideas</div>
<div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-edit-line"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-1">July 1, 2025</div>
</div>
<div class="chat-item hover:bg-gray-100 rounded p-2 cursor-pointer">
<div class="flex justify-between items-start">
<div class="truncate font-medium">Code Review Assistance</div>
<div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-edit-line"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-1">June 30, 2025</div>
</div>
<div id="product-design-chat" class="chat-item hover:bg-gray-100 rounded p-2 cursor-pointer">
<div class="flex justify-between items-start">
<div class="truncate font-medium">Product Design Feedback</div>
<div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-edit-line"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-1">June 28, 2025</div>
</div>
<div class="chat-item hover:bg-gray-100 rounded p-2 cursor-pointer">
<div class="flex justify-between items-start">
<div class="truncate font-medium">Research on Renewable Energy</div>
<div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-edit-line"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-1">June 25, 2025</div>
</div>
</div>
<!-- Sidebar Footer -->
<div class="p-4 border-t border-gray-200">
<div class="flex items-center justify-between mb-3">
<span class="text-sm font-medium">Dark Mode</span>
<div>
<input type="checkbox" id="theme-toggle" class="toggle">
<label for="theme-toggle" class="toggle-label"></label>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center">
<div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
<span class="text-sm font-medium">JD</span>
</div>
<div class="ml-2">
<div class="text-sm font-medium">John Doe</div>
<div class="text-xs text-gray-500">Premium Plan</div>
</div>
</div>
<button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700">
<i class="ri-settings-3-line ri-lg"></i>
</button>
</div>
</div>
</aside>
<!-- Main Content -->
<main class="flex-1 flex flex-col h-full relative">
<!-- Chat Container -->
<div class="flex-1 overflow-y-auto p-4 chat-container">
<!-- Welcome Message -->
<div class="flex flex-col items-center justify-center h-full max-w-2xl mx-auto text-center px-4">
<div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
<i class="ri-robot-line ri-2x text-primary"></i>
</div>
<h1 class="text-2xl font-bold mb-2">Welcome to EMON AI Chat</h1>
<p class="text-gray-600 mb-8">Ask me anything or try one of these examples:</p>
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
<button class="bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap">
Write a blog post about AI ethics
</button>
<button class="bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap">
Explain quantum computing simply
</button>
<button class="bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap">
Help me plan a 7-day trip to Japan
</button>
<button class="bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap">
Create a workout routine for beginners
</button>
</div>
</div>
<!-- Chat Messages (initially hidden) -->
<div id="chat-messages" class="max-w-3xl mx-auto w-full hidden">
<!-- AI Message -->
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>Hello! I'm EMON AI, your personal assistant. How can I help you today?</p>
</div>
<div class="text-xs text-gray-500 mt-1">10:30 AM</div>
</div>
</div>
<!-- User Message -->
<div class="flex flex-row-reverse mb-6">
<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
<div class="mr-3 max-w-[80%]">
<div class="bg-primary text-white p-3 rounded-lg">
<p>Can you help me create a marketing strategy for a new mobile app targeting young professionals?</p>
</div>
<div class="text-xs text-gray-500 mt-1 text-right">10:32 AM</div>
</div>
</div>
<!-- AI Message with Typing Indicator -->
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>Absolutely! I'd be happy to help you create a marketing strategy for your new mobile app targeting young professionals. Here's a comprehensive approach:</p>
<br>
<p><strong>1. Market Research & Target Audience Analysis</strong></p>
<ul class="list-disc pl-5 space-y-1">
<li>Define your specific demographic (age 25-40, urban, income level)</li>
<li>Research pain points and needs of young professionals</li>
<li>Analyze competitors and identify market gaps</li>
</ul>
<br>
<p><strong>2. Value Proposition & Messaging</strong></p>
<ul class="list-disc pl-5 space-y-1">
<li>Develop clear, concise messaging highlighting time-saving benefits</li>
<li>Focus on productivity, career advancement, or work-life balance</li>
<li>Create a compelling brand story that resonates with ambitious professionals</li>
</ul>
</div>
<div class="text-xs text-gray-500 mt-1">10:34 AM</div>
</div>
</div>
<!-- Typing Indicator -->
<div class="flex mb-6" id="typing-indicator">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3">
<div class="bg-gray-100 py-3 px-4 rounded-lg inline-block">
<div class="typing-indicator">
<span></span>
<span></span>
<span></span>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Input Section -->
<div class="border-t border-gray-200 bg-white p-4 w-full">
<div class="max-w-3xl mx-auto">
<div class="relative">
<!-- Tools Tray (initially hidden) -->
<div id="tools-tray" class="absolute bottom-full left-0 right-0 bg-white border border-gray-200 rounded-t-lg shadow-lg p-3 hidden">
<div class="flex space-x-2">
<button class="flex items-center justify-center gap-2 py-2 px-3 bg-gray-100 hover:bg-gray-200 rounded !rounded-button whitespace-nowrap">
<i class="ri-image-line"></i>
<span>Image</span>
</button>
<button class="flex items-center justify-center gap-2 py-2 px-3 bg-gray-100 hover:bg-gray-200 rounded !rounded-button whitespace-nowrap">
<i class="ri-file-line"></i>
<span>File</span>
</button>
<button class="flex items-center justify-center gap-2 py-2 px-3 bg-gray-100 hover:bg-gray-200 rounded !rounded-button whitespace-nowrap">
<i class="ri-code-box-line"></i>
<span>Code</span>
</button>
</div>
</div>
<!-- Input Field -->
<div class="flex items-end border border-gray-300 rounded p-3 bg-white">
<button id="tools-button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 mr-2">
<i class="ri-add-line ri-lg"></i>
</button>
<div class="flex-1 min-h-[24px] max-h-[120px] overflow-y-auto message-input" contenteditable="true" data-placeholder="Type your message..."></div>
<div class="flex items-center">
<button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 mr-1">
<i class="ri-mic-line ri-lg"></i>
</button>
<button id="send-button" class="w-8 h-8 flex items-center justify-center text-primary hover:text-primary/90 disabled:opacity-50 disabled:cursor-not-allowed">
<i class="ri-send-plane-fill ri-lg"></i>
</button>
</div>
</div>
</div>
<div class="text-xs text-gray-500 text-center mt-2">
EMON AI may produce inaccurate information. Your conversations are private.
</div>
</div>
</div>
</main>
<!-- Mobile Sidebar Toggle Button (visible only on mobile) -->
<button id="show-sidebar" class="fixed left-4 top-4 w-10 h-10 bg-white shadow rounded-full flex items-center justify-center z-50 md:hidden hidden">
<i class="ri-menu-line ri-lg"></i>
</button>
</div>
<script id="sidebar-toggle-script">
document.addEventListener('DOMContentLoaded', function() {
const sidebar = document.getElementById('sidebar');
const collapseSidebar = document.getElementById('collapse-sidebar');
const showSidebar = document.getElementById('show-sidebar');
collapseSidebar.addEventListener('click', function() {
sidebar.classList.add('-translate-x-full');
showSidebar.classList.remove('hidden');
});
showSidebar.addEventListener('click', function() {
sidebar.classList.remove('-translate-x-full');
showSidebar.classList.add('hidden');
});
// Handle responsive behavior
function handleResize() {
if (window.innerWidth < 768) {
sidebar.classList.add('-translate-x-full');
showSidebar.classList.remove('hidden');
} else {
sidebar.classList.remove('-translate-x-full');
showSidebar.classList.add('hidden');
}
}
window.addEventListener('resize', handleResize);
handleResize();
});
</script>
<script id="chat-interaction-script">
document.addEventListener('DOMContentLoaded', function() {
const messageInput = document.querySelector('.message-input');
const sendButton = document.getElementById('send-button');
const chatMessages = document.getElementById('chat-messages');
const welcomeScreen = document.querySelector('.chat-container > div:first-child');
const typingIndicator = document.getElementById('typing-indicator');
const projectAnalysisChat = document.getElementById('project-analysis-chat');
const newChatButton = document.getElementById('new-chat-button');
const chatHistory = document.querySelector('.chat-history');
let currentChatId = null;
let chatData = {};
let chatCounter = 1;
function createMessageElement(type, content, time) {
const div = document.createElement('div');
div.className = 'flex mb-6' + (type === 'user' ? ' flex-row-reverse' : '');
if (type === 'user') {
div.innerHTML = `
<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
<div class="mr-3 max-w-[80%]">
<div class="bg-primary text-white p-3 rounded-lg">
<p>${content}</p>
</div>
<div class="text-xs text-gray-500 mt-1 text-right">${time}</div>
</div>
`;
} else {
div.innerHTML = `
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>${content}</p>
</div>
<div class="text-xs text-gray-500 mt-1">${time}</div>
</div>
`;
}
return div;
}
function createInitialMessage(chatName) {
return createMessageElement('ai', `Welcome to ${chatName}! How can I assist you today?`,
new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' }));
}
function createChatItem(chatId, chatName) {
const chatItem = document.createElement('div');
chatItem.className = 'chat-item hover:bg-gray-100 rounded p-2 cursor-pointer transition-colors';
chatItem.dataset.chatId = chatId;
const now = new Date();
const dateString = now.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
chatItem.innerHTML = `
<div class="flex justify-between items-start">
<div class="truncate font-medium">${chatName}</div>
<div class="flex space-x-1">
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 rename-chat">
<i class="ri-edit-line"></i>
</button>
<button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700 delete-chat">
<i class="ri-delete-bin-line"></i>
</button>
</div>
</div>
<div class="text-xs text-gray-500 mt-1">${dateString}</div>
`;
chatItem.querySelector('.rename-chat').addEventListener('click', (e) => {
e.stopPropagation();
const newName = prompt('Enter new chat name:', chatName);
if (newName && newName.trim()) {
chatItem.querySelector('.truncate').textContent = newName.trim();
chatData[chatId].name = newName.trim();
}
});
chatItem.querySelector('.delete-chat').addEventListener('click', (e) => {
e.stopPropagation();
if (confirm('Are you sure you want to delete this chat?')) {
chatItem.remove();
delete chatData[chatId];
if (currentChatId === chatId) {
currentChatId = null;
welcomeScreen.classList.remove('hidden');
chatMessages.classList.add('hidden');
}
}
});
chatItem.addEventListener('click', () => switchChat(chatId));
return chatItem;
}
function switchChat(chatId) {
currentChatId = chatId;
// Update UI elements visibility
welcomeScreen.classList.add('hidden');
chatMessages.classList.remove('hidden');
// Update sidebar selection
document.querySelectorAll('.chat-item').forEach(item => {
item.classList.remove('bg-gray-100');
});
const selectedChat = document.querySelector(`.chat-item[data-chat-id="${chatId}"]`);
if (selectedChat) {
selectedChat.classList.add('bg-gray-100');
}
// Clear current messages
while (chatMessages.firstChild) {
if (chatMessages.lastChild === typingIndicator) break;
chatMessages.removeChild(chatMessages.firstChild);
}
// Load chat messages
if (chatData[chatId]) {
if (!chatData[chatId].messages.length) {
const initialMessage = createInitialMessage(chatData[chatId].name);
chatData[chatId].messages.push(initialMessage);
}
chatData[chatId].messages.forEach(msg => {
chatMessages.insertBefore(msg.cloneNode(true), typingIndicator);
});
}
// Scroll to bottom
const chatContainer = document.querySelector('.chat-container');
chatContainer.scrollTop = chatContainer.scrollHeight;
}
function startNewChat() {
const chatId = `chat-${Date.now()}`;
const chatName = `New Chat ${chatCounter++}`;
// Create new chat data
chatData[chatId] = {
name: chatName,
messages: []
};
// Create chat item in sidebar
const chatItem = createChatItem(chatId, chatName);
chatHistory.insertBefore(chatItem, chatHistory.firstChild.nextSibling);
// Clear input and update UI
messageInput.textContent = '';
toggleSendButton();
// Create initial message
const initialMessage = createInitialMessage(chatName);
chatData[chatId].messages.push(initialMessage);
// Switch to new chat
switchChat(chatId);
}
newChatButton.addEventListener('click', startNewChat);
const productDesignChat = document.getElementById('product-design-chat');

projectAnalysisChat.addEventListener('click', function() {
const chatId = 'project-analysis';
if (!chatData[chatId]) {
chatData[chatId] = {
name: 'Project Analysis with AI',
messages: []
};
}

productDesignChat.addEventListener('click', function() {
const chatId = 'product-design';
if (!chatData[chatId]) {
chatData[chatId] = {
name: 'Product Design Feedback',
messages: []
};
}
currentChatId = chatId;
welcomeScreen.classList.add('hidden');
chatMessages.classList.remove('hidden');

document.querySelectorAll('.chat-item').forEach(item => {
item.classList.remove('bg-gray-100');
});
productDesignChat.classList.add('bg-gray-100');

while (chatMessages.firstChild) {
if (chatMessages.lastChild === typingIndicator) break;
chatMessages.removeChild(chatMessages.firstChild);
}

chatMessages.innerHTML = `
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>Welcome to the Product Design Feedback session! I'm here to help you improve your product design. What specific aspects would you like to discuss?</p>
</div>
<div class="text-xs text-gray-500 mt-1">2:30 PM</div>
</div>
</div>
<div class="flex flex-row-reverse mb-6">
<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
<div class="mr-3 max-w-[80%]">
<div class="bg-primary text-white p-3 rounded-lg">
<p>I need feedback on our new mobile app's user interface. Users are reporting that the navigation is not intuitive enough.</p>
</div>
<div class="text-xs text-gray-500 mt-1 text-right">2:32 PM</div>
</div>
</div>
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>I understand your concern about the navigation. Let's analyze the current UI:</p>
<br>
<p><strong>1. Navigation Issues</strong></p>
<ul class="list-disc pl-5 space-y-1">
<li>Menu structure complexity</li>
<li>Button placement and visibility</li>
<li>User flow optimization needed</li>
</ul>
<br>
<p><strong>2. Recommended Improvements</strong></p>
<ul class="list-disc pl-5 space-y-1">
<li>Implement bottom navigation bar</li>
<li>Add clear visual hierarchies</li>
<li>Include gesture-based navigation</li>
</ul>
</div>
<div class="text-xs text-gray-500 mt-1">2:35 PM</div>
</div>
</div>
`;

chatMessages.appendChild(typingIndicator);
const chatContainer = document.querySelector('.chat-container');
chatContainer.scrollTop = chatContainer.scrollHeight;
});
currentChatId = chatId;
welcomeScreen.classList.add('hidden');
chatMessages.classList.remove('hidden');
document.querySelectorAll('.chat-item').forEach(item => {
item.classList.remove('bg-gray-100');
});
projectAnalysisChat.classList.add('bg-gray-100');
while (chatMessages.firstChild) {
if (chatMessages.lastChild === typingIndicator) break;
chatMessages.removeChild(chatMessages.firstChild);
}
chatMessages.innerHTML = `
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>Let's analyze your project. What aspects would you like to focus on?</p>
</div>
<div class="text-xs text-gray-500 mt-1">9:30 AM</div>
</div>
</div>
<div class="flex flex-row-reverse mb-6">
<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
<div class="mr-3 max-w-[80%]">
<div class="bg-primary text-white p-3 rounded-lg">
<p>I need help analyzing the feasibility of implementing AI in our customer service department.</p>
</div>
<div class="text-xs text-gray-500 mt-1 text-right">9:32 AM</div>
</div>
</div>
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>I'll help you evaluate the AI implementation for customer service. Here's a structured analysis:</p>
<br>
<p><strong>1. Current System Assessment</strong></p>
<ul class="list-disc pl-5 space-y-1">
<li>Average response time: 15 minutes</li>
<li>Customer satisfaction rate: 85%</li>
<li>Current handling capacity: 1000 tickets/day</li>
</ul>
<br>
<p><strong>2. AI Implementation Benefits</strong></p>
<ul class="list-disc pl-5 space-y-1">
<li>24/7 instant responses</li>
<li>Automated handling of routine queries</li>
<li>Scalable solution for peak times</li>
</ul>
</div>
<div class="text-xs text-gray-500 mt-1">9:35 AM</div>
</div>
</div>
`;
chatMessages.appendChild(typingIndicator);
const chatContainer = document.querySelector('.chat-container');
chatContainer.scrollTop = chatContainer.scrollHeight;
});
// Example buttons
const exampleButtons = document.querySelectorAll('.grid button');
function toggleSendButton() {
if (messageInput.textContent.trim() === '') {
sendButton.disabled = true;
sendButton.classList.add('opacity-50');
} else {
sendButton.disabled = false;
sendButton.classList.remove('opacity-50');
}
}
messageInput.addEventListener('input', toggleSendButton);
toggleSendButton();
function sendMessage() {
const message = messageInput.textContent.trim();
if (message === '') return;
if (!currentChatId) {
startNewChat();
}
// Hide welcome screen, show chat
welcomeScreen.classList.add('hidden');
chatMessages.classList.remove('hidden');
// Add user message
const now = new Date();
const timeString = now.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
const userMessageHTML = `
<div class="flex flex-row-reverse mb-6">
<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center shrink-0">
<span class="text-sm font-medium">JD</span>
</div>
<div class="mr-3 max-w-[80%]">
<div class="bg-primary text-white p-3 rounded-lg">
<p>${message}</p>
</div>
<div class="text-xs text-gray-500 mt-1 text-right">${timeString}</div>
</div>
</div>
`;
// Create message element
const tempDiv = document.createElement('div');
tempDiv.innerHTML = userMessageHTML;
const messageElement = tempDiv.firstElementChild;
// Insert before typing indicator
typingIndicator.insertAdjacentElement('beforebegin', messageElement);
// Store message in chat data
if (!chatData[currentChatId].messages) {
chatData[currentChatId].messages = [];
}
chatData[currentChatId].messages.push(messageElement);
// Show typing indicator
typingIndicator.classList.remove('hidden');
// Clear input
messageInput.textContent = '';
toggleSendButton();
// Scroll to bottom
const chatContainer = document.querySelector('.chat-container');
chatContainer.scrollTop = chatContainer.scrollHeight;
// Simulate AI response after delay
setTimeout(() => {
typingIndicator.classList.add('hidden');
const aiResponseHTML = `
<div class="flex mb-6">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<i class="ri-robot-line text-primary"></i>
</div>
<div class="ml-3 max-w-[80%]">
<div class="bg-gray-100 p-3 rounded-lg">
<p>Thank you for your message! I'm processing your request about "${message}". How else can I assist you today?</p>
</div>
<div class="text-xs text-gray-500 mt-1">${timeString}</div>
</div>
</div>
`;
// Create AI message element
const tempDivAI = document.createElement('div');
tempDivAI.innerHTML = aiResponseHTML;
const aiMessageElement = tempDivAI.firstElementChild;
// Insert before typing indicator
typingIndicator.insertAdjacentElement('beforebegin', aiMessageElement);
// Store AI message in chat data
chatData[currentChatId].messages.push(aiMessageElement);
chatContainer.scrollTop = chatContainer.scrollHeight;
}, 1500);
}
sendButton.addEventListener('click', sendMessage);
messageInput.addEventListener('keydown', function(e) {
if (e.key === 'Enter' && !e.shiftKey) {
e.preventDefault();
sendMessage();
}
});
// Handle example buttons
exampleButtons.forEach(button => {
button.addEventListener('click', function() {
messageInput.textContent = this.textContent.trim();
toggleSendButton();
sendMessage();
});
});
});
</script>
<script id="tools-tray-script">
document.addEventListener('DOMContentLoaded', function() {
const toolsButton = document.getElementById('tools-button');
const toolsTray = document.getElementById('tools-tray');
toolsButton.addEventListener('click', function() {
toolsTray.classList.toggle('hidden');
});
// Close tray when clicking outside
document.addEventListener('click', function(event) {
if (!toolsButton.contains(event.target) && !toolsTray.contains(event.target)) {
toolsTray.classList.add('hidden');
}
});
});
</script>
</body>
</html>