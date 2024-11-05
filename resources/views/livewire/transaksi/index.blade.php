<div class="page-wrapper">
    {{-- search --}}
    <div class="flex flex-col justify-between gap-2 md:flex-row">
        <!-- wire:model.live akan melalukan pencarian dengan filter secara langsung -->
        <input type="date" class="input input-bordered" wire:model.live="date">

        <a href="{{ route('transaksi.export') }}" class="btn btn-success" wire:navigate>
            <x-tabler-file-export class="size-5" />
            <span>export to excel</span>
        </a>
    </div>
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaksi->created_at->diffForHumans() }}</td>
                        <td>{{ $transaksi->desc }}</td>
                        <td>
                            {{ $transaksi->customer->name ?? '-' }}
                        </td>
                        <td>Rp. {{ Number::format($transaksi->price) }}</td>
                        <td>
                            <input type="checkbox" class="toggle toggle-primary toggle-sm" @checked($transaksi->done)
                                wire:change='toggleDone({{ $transaksi->id }})'>
                        </td>
                        {{-- action --}}
                        <td>
                            <div class="flex justify-center gap-1">
                                <button class="btn btn-xs"
                                    wire:click="$dispatch('detailTransaksi', {transaksi: {{ $transaksi->id }}})">
                                    <x-tabler-folder class="size-4" />
                                </button>
                                <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-xs">
                                    <x-tabler-edit class="size-4" />
                                </a>
                                <button class="btn btn-xs" wire:click='deleteTransaksi({{ $transaksi->id }})'>
                                    <x-tabler-trash class="size-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- panggil livewire detail, dispatch --}}
    @livewire('transaksi.detail')
</div>
