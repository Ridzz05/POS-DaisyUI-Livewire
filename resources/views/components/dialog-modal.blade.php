<div class="modal {{ $showModal ? 'modal-open' : '' }}">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">{{ $title }}</h3>
        <div class="modal-body">
            {{ $content }}
        </div>
        <div class="modal-action">
            {{ $footer }}
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button wire:click="$set('showModal', false)">close</button>
    </form>
</div>
