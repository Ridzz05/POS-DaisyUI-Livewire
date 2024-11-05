<ul class="menu min-h-full w-80 space-y-4 border-r-2 border-base-300 bg-base-100 p-4 text-base-content">
    <style>
        .menu-title {
            transition: color 0.3s ease;
        }

        .collapse ul {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .collapse[open] ul {
            max-height: 200px; /* Atur sesuai kebutuhan */
        }

        /* Kelas untuk tautan aktif */
        .active {
            font-weight: bold;
            color: #4a90e2; /* Atur warna sesuai tema Anda */
        }
    </style>

    <!-- Dashboard Dropdown -->
    <li>
        <details class="collapse">
            <summary class="menu-title flex items-center cursor-pointer">
                <x-tabler-layout-dashboard class="size-5 mr-2" />
                <span>Dashboard</span>
            </summary>
            <ul class="space-y-2 pl-4">
                <li>
                    <a href="{{ route('home') }}" @class(['active' => $activeRoute === 'home']) wire:navigate>
                        <x-tabler-device-desktop-analytics class="size-5" />
                        <span>Data Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transaksi.create') }}" @class(['active' => $activeRoute === 'transaksi.create']) wire:navigate>
                        <x-tabler-shopping-cart class="size-5" />
                        <span>Mulai Jual</span>
                    </a>
                </li>
            </ul>
        </details>
    </li>

    <!-- Data Master Dropdown -->
    <li>
        <details class="collapse">
            <summary class="menu-title flex items-center cursor-pointer">
                <x-tabler-box-multiple class="size-5 mr-2" />
                <span>Transaksi & Produk</span>
            </summary>
            <ul class="space-y-2 pl-4">
                <li>
                    <a href="{{ route('menu.index') }}" @class(['active' => $activeRoute === 'menu.index']) wire:navigate>
                        <x-tabler-clipboard class="size-5" />
                        <span>Tambah Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}" @class(['active' => $activeRoute === 'customer.index']) wire:navigate>
                        <x-tabler-users class="size-5" />
                        <span>Data Customer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transaksi.index') }}" @class(['active' => in_array($activeRoute, ['transaksi.index', 'transaksi.export'])]) wire:navigate>
                        <x-tabler-license class="size-5" />
                        <span>Riwayat Transaksi</span>
                    </a>
                </li>
            </ul>
        </details>
    </li>

    <!-- Data Gudang Dropdown -->
    <li>
        <details class="collapse">
            <summary class="menu-title flex items-center cursor-pointer">
                <x-tabler-package class="size-5 mr-2" />
                <span>Data Gudang</span>
            </summary>
            <ul class="space-y-2 pl-4">
                <li>
                    <a href="{{ route('stok.index') }}" @class(['active' => $activeRoute === 'stok.index']) wire:navigate>
                        <x-tabler-file-stack class="size-5" />
                        <span>Data Stok</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supplier.index') }}" @class(['active' => $activeRoute === 'supplier.index']) wire:navigate>
                        <x-tabler-truck-delivery class="size-5" />
                        <span>Data Supplier</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('barang-masuk.index') }}" @class(['active' => $activeRoute === 'barang-masuk.index']) wire:navigate>
                        <x-tabler-package-import class="size-5" />
                        <span>Data Barang Masuk</span>
                    </a>
                </li>
            </ul>
        </details>
    </li>

    <!-- Cetak Dokumen Dropdown -->
    <li>
        <details class="collapse">
            <summary class="menu-title flex items-center cursor-pointer">
                <x-tabler-printer class="size-5 mr-2" />
                <span>Cetak Dokumen</span>
            </summary>
            <ul class="space-y-2 pl-4">
                <li>
                    <a href="{{ route('suratjalan.index') }}" @class(['active' => $activeRoute === 'suratjalan.index']) wire:navigate>
                        <x-tabler-notes class="size-5 mr-2" />
                        <span>Cetak Surat Jalan</span>
                    </a>
                </li>
            </ul>
        </details>
    </li>    

    <!-- Account Dropdown -->
    <li>
        <details class="collapse">
            <summary class="menu-title flex items-center cursor-pointer">
                <x-tabler-user class="size-5 mr-2" />
                <span>Account</span>
            </summary>
            <ul class="space-y-2 pl-4">
                <li>
                    <a href="{{ route('profile') }}" @class(['active' => $activeRoute === 'profile']) wire:navigate>
                        <x-tabler-user class="size-5 mr-2" />
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li>
                    <button wire:click='logout' class="flex items-center">
                        <x-tabler-logout class="size-5 mr-2" />
                        <span>Logout</span>
                    </button>
                </li>
            </ul>
        </details>
    </li>
</ul>

<script>
    window.addEventListener('logout-success', event => {
        window.location.href = "{{ route('login') }}"; // Arahkan ke halaman login setelah logout
    });
</script>
