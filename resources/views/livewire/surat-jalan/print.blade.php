<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details table {
            width: 100%;
            font-size: 14px;
        }
        .details td {
            padding: 5px;
        }
        .barang-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .barang-table th, .barang-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        .barang-table th {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            font-size: 12px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>PT. Nama Perusahaan Anda</h2>
            <p>Alamat Perusahaan, Kota, Provinsi, Kode Pos</p>
            <p>Telepon: (021) 123-4567 | Email: info@perusahaan.com</p>
        </div>

        <!-- Detail Surat Jalan -->
        <div class="details">
            <table>
                <tr>
                    <td><strong>Nomor Surat:</strong> {{ $suratJalan->nomor_surat }}</td>
                    <td><strong>Tanggal:</strong> {{ $suratJalan->tanggal }}</td>
                </tr>
                <tr>
                    <td><strong>Customer:</strong> {{ $suratJalan->customer->nama }}</td>
                    <td><strong>Alamat:</strong> {{ $suratJalan->alamat }}</td>
                </tr>
                <tr>
                    <td><strong>Keterangan:</strong></td>
                    <td>{{ $suratJalan->keterangan }}</td>
                </tr>
            </table>
        </div>

        <!-- Tabel Barang -->
        <h3>Daftar Barang</h3>
        <table class="barang-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suratJalan->barang as $index => $barang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barang }}</td>
                        <td>{{ $suratJalan->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah mempercayakan layanan kami.</p>
            <p>PT. Nama Perusahaan Anda | Surat Jalan ini berlaku sebagai bukti pengiriman barang.</p>
        </div>
    </div>
</body>
</html>
