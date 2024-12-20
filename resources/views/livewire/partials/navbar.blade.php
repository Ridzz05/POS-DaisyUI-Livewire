<div>
    <div class="navbar border-b-2 border-base-300 bg-base-100 print:hidden fixed top-0 left-0 right-0 z-50">
        {{-- humberger menu --}}
        <div class="navbar-start">
            <label for="drawer" class="btn btn-circle btn-ghost">
                <x-tabler-menu class="size-5" />
            </label>
        </div>
        
        {{-- tulisan di tengah navbar --}}
        <div class="navbar-center">
            <a href="{{ route('home') }}" class="btn btn-ghost text-xl" wire:navigate>{{ config('app.name') }}</a>
        </div>
        
        {{-- plus menu --}}
        <div class="navbar-end gap-2">
            {{-- theme toggle --}}
            <label class="grid cursor-pointer place-items-center">
                <input type="checkbox" class="theme-controller toggle col-span-2 col-start-1 row-start-1 bg-base-content"
                    id="theme-toggle" />
                <svg class="col-start-1 row-start-1 fill-base-100 stroke-base-100" xmlns="http://www.w3.org/2000/svg"
                    width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5" />
                    <path
                        d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
                </svg>
                <svg class="col-start-2 row-start-1 fill-base-100 stroke-base-100" xmlns="http://www.w3.org/2000/svg"
                    width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            </label>

            {{-- tombol fullscreen --}}
            <button onclick="toggleFullscreen()" class="btn btn-circle btn-ghost">
                <x-tabler-arrows-diagonal class="size-5" />
            </button>
            
            {{-- button logout --}}
            <button wire:click='logout' class="btn btn-circle btn-ghost">
                <x-tabler-logout class="size-5" />
            </button>
        </div>
    </div>

    {{-- Tambahkan div spacer untuk menghindari konten tertutup navbar --}}
    <div class="h-16"></div>

    <script>
        // toggle theme checkbox
        document.getElementById('theme-toggle').checked = localStorage.getItem('theme') === 'dracula';

        // fungsi toggle theme
        document.getElementById('theme-toggle').addEventListener('change', function(e) {
            let currentTheme = localStorage.getItem('theme');
            const newTheme = currentTheme === 'cmyk' ? 'dracula' : 'cmyk';
            document.body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });

        // Modifikasi fungsi toggleFullscreen
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                document.querySelector('.navbar').classList.add('fixed');
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    </script>
</div>
