<div class="page-wrapper">
    <div class="mx-auto max-w-sm space-y-8">
        <div class="text-center">
            <h3 class="text-xl font-bold">{{ config('app.name') }}</h3>
            <p>{{ fake()->address() }}</p>
        </div>

        {{-- Detail transaksi --}}
        <div>
            <table class="w-full">
                <tr>
                    <td>Kode transaksi</td>
                    <td>:</td>
                    <td>{{ $transaksi->id }}</td>
                </tr>
                <tr>
                    <td>Tanggal transaksi</td>
                    <td>:</td>
                    <td>{{ $transaksi->created_at->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td>:</td>
                    <td>{{ $transaksi->customer?->name ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- Detail items --}}
        <div class="space-y-2">
            {{-- yang menjadi key adalah nama barang --}}
            {{-- $item berisi quantity dan total harga --}}
            @foreach ($transaksi->items as $name => $item)
                <div class="flex flex-col">
                    <div>{{ $name }}</div>
                    <div class="flex justify-between">
                        <div>{{ $item['price'] / $item['qty'] }} x {{ $item['qty'] }}</div>
                        <div>{{ Number::format($item['price']) }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end">
            <div class="flex flex-col">
                <small class="text-end">Total bayar</small>
                <div class="text-lg">Rp. {{ Number::format($transaksi->price) }}</div>
            </div>
        </div>
    </div>
</div>
