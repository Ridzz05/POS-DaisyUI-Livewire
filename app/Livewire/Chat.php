<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class Chat extends Component
{
    public $message;
    public $messages;
    public $isOpen = false;

    protected $listeners = [
        'messageReceived' => 'addMessage',
        'toggleChat' => 'toggleChat'
    ];

    public function mount()
    {
        // Load the latest 50 messages
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse();
    }

    public function sendMessage()
    {
        $this->validate(['message' => 'required|string|max:255']);

        $newMessage = Message::create([
            'user_id' => Auth::id(),
            'message' => $this->message,
        ]);

        // Load user relationship
        $newMessage->load('user');

        // Tambahkan pesan baru ke koleksi messages
        $this->messages->push($newMessage);

        $this->message = '';

        // Broadcast the message to others
        broadcast(new MessageSent($newMessage))->toOthers();

        // Scroll ke bawah setelah mengirim pesan
        $this->dispatch('scrollToBottom');
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->loadMessages();
        }
    }

    public function addMessage($message)
    {
        $newMessage = Message::with('user')->find($message['id']);
        if ($newMessage) {
            $this->messages->push($newMessage);
            $this->dispatch('scrollToBottom');
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}