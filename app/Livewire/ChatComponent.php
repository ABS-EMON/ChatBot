<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    public $message = '';
    public $chats = [];
    public $currentChat = null;
    public $messages = [];
    public $isTyping = false;
    public $showWelcome = true;
    public $examplePrompts = [
        'Write a blog post about AI ethics',
        'Explain quantum computing simply',
        'Help me plan a 7-day trip to Japan',
        'Create a workout routine for beginners'
    ];

    protected $listeners = ['switchChat', 'deleteChat', 'renameChat'];

    public function mount()
    {
        $this->loadChats();
        
        // Load from localStorage if available
        if (auth()->check()) {
            $chatState = request()->session()->get('chat_state');
            if ($chatState) {
                $data = json_decode($chatState, true);
                $this->currentChat = $data['currentChat'] ?? null;
                $this->showWelcome = $data['showWelcome'] ?? true;
            }
        }

        // If there are existing chats but none selected, load the first one
        if (count($this->chats) > 0 && !$this->currentChat) {
            $this->switchChat($this->chats[0]['id']);
        }
    }

    public function loadChats()
    {
        $this->chats = Chat::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toArray();
    }

    public function startNewChat()
    {
        $chat = Chat::create([
            'name' => 'New Chat ' . (count($this->chats) + 1),
            'user_id' => Auth::id()
        ]);

        $this->loadChats();
        $this->switchChat($chat->id);
        $this->showWelcome = false;
        
        // Add welcome message
        $this->addMessage($chat->id, 'assistant', 'Hello! I\'m your AI assistant. How can I help you today?');
    }

    public function switchChat($chatId)
    {
        $this->currentChat = $chatId;
        $this->messages = Message::where('chat_id', $chatId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
        
        $this->showWelcome = false;
        $this->dispatch('chat-switched');
    }

    public function deleteChat($chatId)
    {
        Chat::where('id', $chatId)->delete();
        $this->loadChats();
        
        if ($this->currentChat == $chatId) {
            $this->currentChat = null;
            $this->messages = [];
            $this->showWelcome = true;
        }
    }

    public function renameChat($chatId, $newName)
    {
        Chat::where('id', $chatId)->update(['name' => $newName]);
        $this->loadChats();
    }

    public function sendMessage()
    {
        $this->validate(['message' => 'required|string']);
        
        if (!$this->currentChat) {
            $this->startNewChat();
        }

        // Add user message
        $this->addMessage($this->currentChat, 'user', $this->message);
        
        // Show typing indicator
        $this->isTyping = true;
        $this->message = '';
        
        // Simulate AI response after delay
        $this->dispatch('simulate-typing', 
            chatId: $this->currentChat,
            userMessage: $this->message
        );
    }

    public function useExamplePrompt($prompt)
    {
        $this->message = $prompt;
        $this->sendMessage();
    }

    protected function addMessage($chatId, $role, $content)
    {
        $message = Message::create([
            'chat_id' => $chatId,
            'role' => $role,
            'content' => $content
        ]);
        
        // Update chat's timestamp
        Chat::where('id', $chatId)->touch();
        
        if ($this->currentChat == $chatId) {
            $this->messages[] = $message->toArray();
        }
        
        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        // Save state to session
        if (auth()->check()) {
            request()->session()->put('chat_state', json_encode([
                'currentChat' => $this->currentChat,
                'showWelcome' => $this->showWelcome
            ]));
        }

        return view('livewire.chat-component');
    }
}