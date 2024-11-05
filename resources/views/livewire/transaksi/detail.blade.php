<div>
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Detail transaksi!</h3>
            <div class="space-y-4 py-4">
                <div class="flex flex-col">
                    <div class="text-s opacity-50">Tanggal transaksi</div>
                    <div>{{ $transaksi?->created_at->format('d F Y H:i') }}</div>
                </div>
                <div class="flex flex-col">
                    <div class="text-s opacity-50">Nama customer</div>
                    <div>{{ $transaksi?->customer->name ?? '-' }}</div>
                </div>
                <div class="flex flex-col">
                    <div class="text-s opacity-50">Total bayar</div>
                    <div>{{ Number::format($transaksi?->price ?? 0) }}</div>
                </div>

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <th>Nama menu</th>
                            <th>Qty</th>
                            <th>Harga</th>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->items ?? [] as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>{{ Number::format($item['price']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            {{-- <p class="py-4">This modal works with a hidden checkbox!</p> --}}
            <div class="modal-action justify-between">
                <button type="button" wire:click='closeModal' class="btn btn-ghost">Close</button>
                @isset($transaksi)
                    <a href="{{ route('transaksi.cetak', $transaksi->id) }}" wire:click='closeModal' class="btn btn-primary"
                        onclick="return cetakStruk('{{ route('transaksi.cetak', $transaksi) }}')">
                        <x-tabler-printer class="size-5" /> cetak
                    </a>
                @endisset
            </div>
        </div>
    </div>
</div>
