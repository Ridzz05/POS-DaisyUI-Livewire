<div>
    <!-- Checkbox to toggle the modal visibility -->
    <input type="checkbox" class="modal-toggle" @checked($show) />
    
    <!-- Modal structure -->
    <div class="modal" role="dialog">
        <div class="modal-box">
            <!-- Modal Title -->
            <h3 class="text-lg font-bold">Detail transaksi!</h3>
            
            <!-- Modal Content -->
            <div class="space-y-4 py-4">
                
                <!-- Transaction Date -->
                <div class="flex flex-col">
                    <div class="text-s opacity-50">Tanggal transaksi</div>
                    <div>{{ $transaksi?->created_at->format('d F Y H:i') }}</div>
                </div>
                
                <!-- Customer Name -->
                <div class="flex flex-col">
                    <div class="text-s opacity-50">Nama customer</div>
                    <div>{{ $transaksi?->customer->name ?? '-' }}</div>
                </div>
                
                <!-- Total Payment -->
                <div class="flex flex-col">
                    <div class="text-s opacity-50">Total bayar</div>
                    <div>{{ Number::format($transaksi?->price ?? 0) }}</div>
                </div>

                <!-- Items Table -->
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

            <!-- Modal Action Buttons -->
            <div class="modal-action justify-between">
                <!-- Close Button -->
                <button type="button" wire:click='closeModal' class="btn btn-ghost">Close</button>
                
                <!-- Print Button (only visible if $transaksi is set) -->
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
