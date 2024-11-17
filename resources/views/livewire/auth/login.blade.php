<body class="bg-base-200 min-h-screen flex items-center justify-center">
    <div class="card lg:card-side bg-base-100 shadow-xl max-w-4xl w-full">
        <figure class="lg:w-1/2">
            <img src="https://picsum.photos/seed/login/800/600" alt="Random image" class="object-cover w-full h-full" />
        </figure>
        <div class="card-body lg:w-1/2 p-8">
            <h2 class="card-title text-2xl font-bold mb-6">Selamat datang</h2>
            <form wire:submit.prevent="login">
                <div class="space-y-4 py-4">
                    @if ($errorMessage)
                        <div class="text-sm text-red-600">
                            {{ $errorMessage }}
                        </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1">
                            <input type="text" class="input input-bordered w-full @error('email') input-error @enderror" placeholder="Email" wire:model="email" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input type="password" class="input input-bordered w-full @error('password') input-error @enderror" placeholder="Password" wire:model="password" />
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" class="checkbox" wire:model="remember" />
                        <label class="ml-2 block text-sm text-gray-900">Remember Me</label>
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button class="btn btn-primary w-full">
                        <x-tabler-login class="size-5" />
                        <span>Login</span>
                    </button>
                </div>
            </form>
            <div class="divider">OR</div>
            <div class="text-center">
                <p>Don't have an account?</p>
                <a href="#" class="link link-primary">Sign up now</a>
            </div>
        </div>
    </div>
</body>
