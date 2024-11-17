<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .page-wrapper {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .text-center {
            text-align: center;
        }
        .flex {
            display: flex;
        }
        .justify-between {
            justify-content: space-between;
        }
        .justify-end {
            justify-content: flex-end;
        }
        .space-y-8 > * + * {
            margin-top: 2rem;
        }
        .text-lg {
            font-size: 1.125rem;
        }
        .text-xl {
            font-size: 1.25rem;
        }
        .text-end {
            text-align: right;
        }
        .text-sm {
            font-size: 0.875rem;
        }
        .footer {
            text-align: center; /* Memastikan teks berada di tengah */
            margin-top: 30px;
            font-size: 0.9rem;
            color: #555;
        }
        .address {
            font-size: 1rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page-wrapper">
        <div class="mx-auto max-w-sm space-y-8">
            {{-- Alamat Toko --}}
            <div class="text-center address">
                <h2 class="text-xl font-bold">Filo Pet Shop</h2>
                <p>{{ $companyAddress ?? 'JL. MGS. H. A RACHMAN No. 12, RT.01/RW.01' }}</p> <!-- Replace with valid address -->
                <p>{{ $companyPhone ?? '0856-0923-8109' }}</p> <!-- Replace with valid phone number -->
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
                            <div>{{ number_format($item['price'] / $item['qty'], 0, ',', '.') }} x {{ $item['qty'] }}</div>
                            <div>Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <div class="flex flex-col">
                    <small class="text-end">Total bayar</small>
                    <div class="text-lg">Rp. {{ number_format($transaksi->price, 0, ',', '.') }}</div>
                </div>
            </div>

            {{-- Footer Ucapan Terima Kasih --}}
            <div class="footer" >
                <p>Terimakasih sudah berbelanja di Filo ^_^</p>
            </div>
        </div>
    </div>
</body>
</html>
