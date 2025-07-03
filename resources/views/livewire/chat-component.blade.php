<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMON AI Chat</title>
    @livewireStyles
    <!-- Your existing styles and scripts -->
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
                <button wire:click="startNewChat" class="w-full bg-primary text-white py-2 px-4 flex items-center justify-center gap-2 !rounded-button hover:bg-primary/90 transition-colors whitespace-nowrap">
                    <i class="ri-add-line"></i>
                    <span>New Chat</span>
                </button>
            </div>
            
            <!-- Chat History -->
            <div class="flex-1 overflow-y-auto chat-history px-2">
                <div class="text-xs font-medium text-gray-500 px-2 py-2">RECENT CHATS</div>
                @foreach($chats as $chat)
                    <div class="chat-item hover:bg-gray-100 rounded p-2 cursor-pointer transition-colors {{ $currentChat == $chat['id'] ? 'bg-gray-100' : '' }}"
                         wire:key="chat-{{ $chat['id'] }}"
                         onclick="Livewire.emit('switchChat', {{ $chat['id'] }})">
                        <div class="flex justify-between items-start">
                            <div class="truncate font-medium">{{ $chat['name'] }}</div>
                            <div class="flex space-x-1">
                                <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700"
                                        onclick="event.stopPropagation(); renameChat({{ $chat['id'] }}, '{{ $chat['name'] }}')">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-gray-700"
                                        onclick="event.stopPropagation(); Livewire.emit('deleteChat', {{ $chat['id'] }})">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ $chat['updated_at']->format('F j, Y') }}</div>
                    </div>
                @endforeach
            </div>
            
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-200">
                <!-- Your existing footer content -->
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full relative">
            <!-- Chat Container -->
            <div class="flex-1 overflow-y-auto p-4 chat-container" id="chat-container">
                @if($showWelcome)
                    <!-- Welcome Message -->
                    <div class="flex flex-col items-center justify-center h-full max-w-2xl mx-auto text-center px-4">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-6">
                            <i class="ri-robot-line ri-2x text-primary"></i>
                        </div>
                        <h1 class="text-2xl font-bold mb-2">Welcome to EMON AI Chat</h1>
                        <p class="text-gray-600 mb-8">Ask me anything or try one of these examples:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 w-full">
                            @foreach($examplePrompts as $prompt)
                                <button wire:click="useExamplePrompt('{{ $prompt }}')" 
                                        class="bg-gray-100 hover:bg-gray-200 p-3 rounded text-left text-sm !rounded-button whitespace-nowrap">
                                    {{ $prompt }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Chat Messages -->
                    <div class="max-w-3xl mx-auto w-full">
                        @foreach($messages as $message)
                            <div class="flex mb-6 {{ $message['role'] === 'user' ? 'flex-row-reverse' : '' }}" wire:key="message-{{ $message['id'] }}">
                                @if($message['role'] === 'user')
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center shrink-0">
                                        <span class="text-sm font-medium">JD</span>
                                    </div>
                                    <div class="mr-3 max-w-[80%]">
                                        <div class="bg-primary text-white p-3 rounded-lg">
                                            <p>{{ $message['content'] }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 text-right">
                                            {{ $message['created_at']->format('h:i A') }}
                                        </div>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                                        <i class="ri-robot-line text-primary"></i>
                                    </div>
                                    <div class="ml-3 max-w-[80%]">
                                        <div class="bg-gray-100 p-3 rounded-lg">
                                            <p>{{ $message['content'] }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $message['created_at']->format('h:i A') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        
                        <!-- Typing Indicator -->
                        @if($isTyping)
                            <div class="flex mb-6">
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
                        @endif
                    </div>
                @endif
            </div>
            
            <!-- Input Section -->
            <div class="border-t border-gray-200 bg-white p-4 w-full">
                <div class="max-w-3xl mx-auto">
                    <div class="relative">
                        <!-- Tools Tray -->
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
                            <input type="text" 
                                   wire:model="message" 
                                   wire:keydown.enter="sendMessage"
                                   placeholder="Type your message..." 
                                   class="flex-1 min-h-[24px] max-h-[120px] message-input outline-none">
                            <div class="flex items-center">
                                <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700 mr-1">
                                    <i class="ri-mic-line ri-lg"></i>
                                </button>
                                <button wire:click="sendMessage" 
                                        class="w-8 h-8 flex items-center justify-center text-primary hover:text-primary/90 disabled:opacity-50 disabled:cursor-not-allowed"
                                        {{ !$message ? 'disabled' : '' }}>
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
    </div>

    @livewireScripts
    <script>
        // Sidebar toggle script (same as before)
        
        // Chat functionality
        document.addEventListener('livewire:load', function() {
            // Scroll to bottom when new messages arrive
            Livewire.on('scroll-to-bottom', () => {
                const container = document.getElementById('chat-container');
                container.scrollTop = container.scrollHeight;
            });
            
            // Simulate AI typing and response
            Livewire.on('simulate-typing', (data) => {
                setTimeout(() => {
                    @this.call('addMessage', data.chatId, 'assistant', data.response);
                    @this.set('isTyping', false);
                }, 1500);
            });
            
            // Handle chat switching
            Livewire.on('chat-switched', () => {
                const container = document.getElementById('chat-container');
                container.scrollTop = container.scrollHeight;
            });
        });
        
        function renameChat(chatId, currentName) {
            const newName = prompt('Enter new chat name:', currentName);
            if (newName && newName.trim()) {
                Livewire.emit('renameChat', chatId, newName.trim());
            }
        }
        
        // Tools tray script (same as before)
    </script>
</body>
</html>