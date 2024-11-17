<div class="container mx-auto p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Transaksi</h1>
        <a href="{{ route('transaksi.export') }}" class="btn btn-success flex items-center gap-2 bg-green-500 text-white hover:bg-green-600 transition mt-4 md:mt-0">
            <x-tabler-file-export class="size-5" />
            <span>Export data ke Excel</span>
        </a>
    </div>

    <div class="card bg-white shadow-lg rounded-lg">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <div class="form-control w-full max-w-xs">
                    <input type="date" class="input input-bordered w-full border-gray-300" wire:model.live="date">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 text-left text-gray-600">No</th>
                            <th class="py-2 px-4 border-b border-gray-200 text-left text-gray-600">Tanggal</th>
                            <th class="py-2 px-4 border-b border-gray-200 text-left text-gray-600">Keterangan</th>
                            <th class="py-2 px-4 border-b border-gray-200 text-left text-gray-600">Customer</th>
                            <th class="py-2 px-4 border-b border-gray-200 text-left text-gray-600">Total</th>
                            <th class="py-2 px-4 border-b border-gray-200 text-center text-gray-600">Status</th>
                            <th class="py-2 px-4 border-b border-gray-200 text-center text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $transaksi)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $transaksi->created_at->format('d F Y') }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="text-blue-500 hover:underline">
                                            Lihat Keterangan
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute z-10 bg-white border border-gray-200 rounded-lg shadow-lg p-4 mt-2 w-64">
                                            {{ $transaksi->desc }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $transaksi->customer->name ?? '-' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">Rp. {{ Number::format($transaksi->price) }}</td>
                                <td class="py-2 px-4 border-b border-gray-200 text-center">
                                    <button class="btn btn-xs {{ $transaksi->done ? 'bg-blue-500' : 'bg-red-500' }} text-white hover:opacity-75 transition"
                                            wire:click="toggleDone({{ $transaksi->id }})">
                                        {{ $transaksi->done ? 'Selesai' : 'Belum Selesai' }}
                                    </button>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="btn btn-xs bg-blue-500 text-white hover:bg-blue-600 transition" 
                                                wire:click="$dispatch('detailTransaksi', { transaksi: {{ $transaksi->id }} })">
                                            <x-tabler-folder class="size-4" />
                                        </button>
                                        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-xs bg-yellow-500 text-white hover:bg-yellow-600 transition">
                                            <x-tabler-edit class="size-4" />
                                        </a>
                                        <button class="btn btn-xs bg-red-500 text-white hover:bg-red-600 transition" wire:click="deleteTransaksi({{ $transaksi->id }})">
                                            <x-tabler-trash class="size-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="4" class="py-2 px-4 text-right font-bold text-gray-600">Total Keseluruhan Penjualan:</td>
                            <td colspan="3" class="py-2 px-4 font-bold text-gray-800">Rp. {{ Number::format($totalPenjualan) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @livewire('transaksi.detail')
</div>
