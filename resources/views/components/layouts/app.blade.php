<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    {{-- tailwindcss with vite --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles
</head>

<body class="min-h-screen bg-base-200" data-theme="">
    {{-- auth --}}
    @auth
        {{-- jika layar lg maka otomatis drawer open -> daisy ui --}}
        <div class="drawer lg:drawer-open">
            <input id="drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <!-- Page content navbar -->
                @livewire('partials.navbar')
                {{-- slot mengarah ke masing masing blade --}}
                {{ $slot }}
            </div>
            <div class="drawer-side">
                <label for="drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                {{-- masukkan sidebar dari livewire --}}
                @livewire('partials.sidebar')
            </div>
        </div>
    @endauth

    {{-- guest --}}
    @guest
        <div class="flex h-screen flex-col items-center justify-center gap-8">
            <h1 class="text-center text-4xl font-bold">{{ config('app.name') }}</h1>
            {{ $slot }}
        </div>
    @endguest
    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') ?? 'bumblebee');
            // document.getElementById('html').setAttribute('data-theme', localStorage.getItem('theme') ?? 'bumblebee');
            localStorage.setItem('theme', localStorage.getItem('theme') ?? 'bumblebee');
            document.body.setAttribute('data-theme', localStorage.getItem('theme') ?? 'bumblebee');
        })
    </script>
</body>

</html>
