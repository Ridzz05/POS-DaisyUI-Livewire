<style>
    .card-revenue {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-revenue:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card-revenue .text-2xl {
        transition: color 0.3s ease;
    }

    .card-revenue:hover .text-2xl {
        color: #23ec2a; /* Ganti dengan warna yang diinginkan */
    }
</style>
<div>
    <div class="page-wrapper p-6">
        {{-- Statistik Cards --}}
        <div class="grid gap-4 md:grid-cols-3 mb-6">
            {{-- Pendapatan Bulan --}}
            <div class="card-revenue bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <div class="card-body flex-row items-center gap-4">
                    <div class="avatar placeholder">
                        <div class="w-16 rounded-lg bg-primary text-white flex items-center justify-center">
                            <x-tabler-calendar-month class="size-8" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-sm opacity-70">Pendapatan Bulan Ini</div>
                        <div class="text-2xl font-bold">Rp. {{ number_format($monthly, 0, ',', '.') }}</div>
                        <div class="text-xs text-success">{{ $monthlyCount }} Transaksi</div>
                    </div>
                </div>
            </div>

            {{-- Pendapatan Hari --}}
            <div class="card-revenue bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <div class="card-body flex-row items-center gap-4">
                    <div class="avatar placeholder">
                        <div class="w-16 rounded-lg bg-secondary text-white flex items-center justify-center">
                            <x-tabler-calendar-check class="size-8" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-sm opacity-70">Pendapatan Hari Ini</div>
                        <div class="text-2xl font-bold">Rp. {{ number_format($today['revenue'], 0, ',', '.') }}</div>
                        <div class="text-xs text-info">{{ $today['count'] }} Transaksi</div>
                    </div>
                </div>
            </div>

            {{-- Total Pesanan --}}
            <div class="card-revenue bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <div class="card-body flex-row items-center gap-4">
                    <div class="avatar placeholder">
                        <div class="w-16 rounded-lg bg-accent text-white flex items-center justify-center">
                            <x-tabler-list-check class="size-8" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="text-sm opacity-70">Total Pesanan</div>
                        <div class="text-2xl font-bold">{{ $today['orders'] }} Pesanan</div>
                        <div class="text-xs text-warning">{{ $datas->count() }} Pending</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Orders Table --}}
        <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300">
            <div class="card-body">
                <h2 class="card-title mb-4">Transaksi Belum Selesai</h2>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Keterangan</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                            <tr wire:key='{{ $data->id }}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->created_at->format('d F Y') }}</td>
                                <td>{{ $data->customer?->name ?? '-' }}</td>
                                <td>{{ Str::limit($data->desc, 30) }}</td>
                                <td>Rp. {{ number_format($data->price, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-xs {{ $data->done ? 'bg-blue-500' : 'bg-red-500' }} text-white hover:opacity-75 transition"
                                            wire:click='toggleDone({{ $data->id }})'>
                                        {{ $data->done ? 'Selesai' : 'Belum Selesai' }}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-ghost" 
                                            onclick="return cetakStruk('{{ route('transaksi.cetak', $data) }}')">
                                        <x-tabler-printer class="size-4" />
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>