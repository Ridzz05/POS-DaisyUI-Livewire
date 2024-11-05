<div class="page-wrapper">
    <!-- Statistik Pendapatan Card -->
    <div class="grid gap-4 md:grid-cols-4 md:gap-6">
        <!-- Pendapatan Bulan Ini -->
        <div class="card card-compact">
            <div class="card-body flex-row items-center gap-4">
                <div class="avatar placeholder">
                    <div class="w-12 rounded-full bg-primary">
                        <x-tabler-calendar-month class="size-6" />
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-xs opacity-60">Pendapatan Bulan Ini</div>
                    <div class="text-2xl font-bold">Rp. {{ Number::format($monthly) }}</div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Hari Ini -->
        <div class="card card-compact">
            <div class="card-body flex-row items-center gap-4">
                <div class="avatar placeholder">
                    <div class="w-12 rounded-full bg-primary">
                        <x-tabler-calendar-check class="size-6" />
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-xs opacity-60">Pendapatan Hari Ini</div>
                    <div class="text-2xl font-bold">Rp. {{ Number::format($today->sum('price')) }}</div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bulan Lalu -->
        <div class="card card-compact">
            <div class="card-body flex-row items-center gap-4">
                <div class="avatar placeholder">
                    <div class="w-12 rounded-full bg-primary">
                        <x-tabler-calendar class="size-6" />
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-xs opacity-60">Pendapatan Bulan Lalu</div>
                    <div class="text-2xl font-bold">Rp. {{ Number::format($previousMonth) }}</div>
                </div>
            </div>
        </div>

        <!-- Pesanan Hari Ini -->
        <div class="card card-compact">
            <div class="card-body flex-row items-center gap-4">
                <div class="avatar placeholder">
                    <div class="w-12 rounded-full bg-primary">
                        <x-tabler-list-check class="size-6" />
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-xs opacity-60">Pesanan Hari Ini</div>
                    <div class="text-2xl font-bold">{{ $today->count() }} Pesanan</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabel Transaksi Belum Selesai -->
    <h2 class="text-center font-bold uppercase underline md:text-2xl">Transaksi Belum Selesai</h2>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Keterangan</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Cetak</th>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr wire:key='{{ $data->id }}'>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->created_at->format('d F Y') }}</td>
                        <td>{{ $data->customer?->name ?? '-' }}</td>
                        <td>{{ $data->desc }}</td>
                        <td>{{ Number::format($data->price) }}</td>
                        <td>
                            <input type="checkbox" class="toggle toggle-primary toggle-sm" @checked($data->done)
                                wire:change='toggleDone({{ $data->id }})'>
                        </td>
                        <td>
                            <button class="btn btn-xs"
                                onclick="return cetakStruk('{{ route('transaksi.cetak', $data) }}')">
                                <x-tabler-printer class="size-4" />
                                <span>Cetak</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
