<div class="card">
    {{-- card milik daisy ui --}}
    {{-- gunakan wire:submit ketika melakukan submit pada form dan akan diarahkan ke Login livewire function login --}}
    <form class="card-body" wire:submit="login">
        <h3 class="card-title mx-auto">Selamat datang</h3>


        <div class="space-y-2 py-4">
            <!-- Pesan error -->
            @if ($errorMessage)
                <div class="text-sm text-red-600">
                    {{ $errorMessage }}
                </div>
            @endif
            <label @class([
                'input input-bordered flex items-center gap-2',
                'input-error' => $errors->first('email') || $errorMessage,
            ])>
                <x-tabler-at class="size-5" />
                <input type="text" class="grow" placeholder="Email" wire:model="email" />
            </label>
            <label @class([
                'input input-bordered flex items-center gap-2',
                'input-error' => $errors->first('password') || $errorMessage,
            ])>
                <x-tabler-key class="size-5" />
                <input type="password" class="grow" placeholder="Password" wire:model="password" />
            </label>
        </div>
        <div class="card-actions">
            <button class="btn btn-primary w-full">
                <x-tabler-login class="size-5" />
                <span>Login</span>
            </button>
        </div>
    </form>
</div>
