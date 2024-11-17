<div class="fixed top-0 right-0 mt-16 mr-4 z-50">
    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Chat</h2>
            <div class="chat-box h-64 overflow-y-auto mb-4">
                @foreach($messages as $message)
                    <div class="chat {{ $message->user_id === auth()->id() ? 'chat-end' : 'chat-start' }}">
                        <div class="chat-bubble {{ $message->user_id === auth()->id() ? 'chat-bubble-primary' : 'chat-bubble-secondary' }}">
                            <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
                        </div>
                    </div>
                @endforeach
            </div>
            <form wire:submit.prevent="sendMessage" class="flex">
                <input type="text" wire:model="message" placeholder="Type your message here..." class="input input-bordered w-full" />
                <button type="submit" class="btn btn-primary ml-2">Send</button>
            </form>
        </div>
    </div>
</div>