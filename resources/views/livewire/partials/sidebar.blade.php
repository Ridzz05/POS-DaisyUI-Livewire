<ul class="menu min-h-full w-80 space-y-4 border-r-2 border-base-30 bg-base-100 p-4 pt-20 text-base-content">
    <!-- Dashboard Section -->
    <li>
        <h2 class="menu-title">Dashboard</h2>
        <ul>
            <li>
                <a href="{{ route('home') }}" @class(['active' => Route::is('home')]) wire:navigate>
                    <x-tabler-notebook class="size-5" />
                    <span>Pendapatan</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Menu Khusus untuk Kasir dan Admin -->
    @if (Auth::user()->hasRole('Kasir') || Auth::user()->hasRole('Admin'))
        <!-- Mulai Penjualan Section -->
        <li>
            <h2 class="menu-title">Transaksi</h2>
            <ul>
                <li>
                    <a href="{{ route('transaksi.create') }}" @class(['active' => Route::is('transaksi.create')]) wire:navigate>
                        <x-tabler-businessplan class="size-5" />
                        <span>Kasir</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transaksi.index') }}" @class(['active' => Route::is('transaksi.index')]) wire:navigate>
                        <x-tabler-report class="size-5" />
                        <span>Riwayat Transaksi</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    <!-- Menu Khusus untuk Admin -->
    @if (Auth::user()->hasRole('Admin'))
        <!-- Data Master Section -->
        <li>
            <h2 class="menu-title">Data & Stok</h2>
            <ul>
                <li>
                    <a href="{{ route('menu.index') }}" @class(['active' => Route::is('menu.index')]) wire:navigate>
                        <x-tabler-layout-grid-add class="size-5" />
                        <span>Stok & Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}" @class(['active' => Route::is('customer.index')]) wire:navigate>
                        <x-tabler-users class="size-5" />
                        <span>Data Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('supplier.index') }}" @class(['active' => Route::is('supplier.index')]) wire:navigate>
                        <x-tabler-truck-delivery class="size-5" />
                        <span>Data Pemasok</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('barang-masuk.index') }}" @class(['active' => Route::is('barang-masuk.index')]) wire:navigate>
                        <x-tabler-package-import class="size-5" />
                        <span>Data Barang Masuk</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Cetak Dokumen Section -->
        <li>
            <h2 class="menu-title">Cetak Dokumen</h2>
            <ul>
                <li>
                    <a href="{{ route('suratjalan.index') }}" @class(['active' => Route::is('suratjalan.index')]) wire:navigate>
                        <x-tabler-notes class="size-5" />
                        <span>Cetak Surat Jalan</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    <!-- Account Section (Semua Role bisa akses) -->
    <li>
        <h2 class="menu-title">Menu Akun</h2>
        <ul>
            <li>
                <a href="{{ route('profile') }}" @class(['active' => Route::is('profile')]) wire:navigate>
                    <x-tabler-user class="size-5" />
                    <span>Edit Profile</span>
                </a>
            </li>
            <li>
                <button wire:click='logout' class="flex items-center">
                    <x-tabler-logout class="size-5" />
                    <span>Logout</span>
                </button>
            </li>
        </ul>
    </li>
</ul>

<script>
    window.addEventListener('logout-success', event => {
        window.location.href = "{{ route('login') }}";
    });
</script>
