<div>
    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Surat Jalan</h1>
            <button class="btn btn-primary" wire:click="create">
                <x-tabler-plus class="size-5" />
                Tambah Surat Jalan
            </button>
        </div>

        <!-- Data Table Section -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div class="form-control w-full max-w-xs">
                        <input type="text" placeholder="Cari surat jalan..." 
                               class="input input-bordered w-full" 
                               wire:model.debounce.30ms="search">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suratjalans as $key => $suratJalan)
                                <tr>
                                    <td>{{ $key + 1 + (($suratjalans->currentPage() - 1) * $suratjalans->perPage()) }}</td>
                                    <td>{{ $suratJalan->nomor_surat }}</td>
                                    <td>{{ \Carbon\Carbon::parse($suratJalan->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $suratJalan->customer->name ?? '-' }}</td>
                                    <td>{{ $suratJalan->alamat }}</td>
                                    <td>{{ $suratJalan->keterangan }}</td>
                                    <td>
                                        <div class="flex justify-center gap-1">
                                            <button wire:click="edit({{ $suratJalan->id }})" class="btn-s btn btn-square btn-warning">
                                                <x-tabler-edit class="size-4"/>
                                            </button>
                                            <button wire:click="confirmDelete({{ $suratJalan->id }})" class="btn-s btn btn-square btn-error">
                                                <x-tabler-trash class="size-4" />
                                            </button>
                                            <button wire:click="print({{ $suratJalan->id }})" class="btn-s btn btn-square btn-info">
                                                <x-tabler-printer class="size-4" />
                                            </button>                                                                             
                                        </div>
                                    </td>                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Tidak ada data Surat Jalan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $suratjalans->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <dialog class="modal" x-bind:open="$wire.showModal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">
                {{ $editingId ? 'Edit Surat Jalan' : 'Tambah Surat Jalan Baru' }}
            </h3>
            
            <form class="space-y-4" wire:submit.prevent="save">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nomor Surat</span>
                    </label>
                    <input type="text" class="input input-bordered" wire:model.defer="nomor_surat" required>
                    @error('nomor_surat') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal</span>
                    </label>
                    <input type="date" class="input input-bordered" wire:model.defer="tanggal" required>
                    @error('tanggal') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Customer</span>
                    </label>
                    <select class="select select-bordered" wire:model.defer="customer_id" required>
                        <option value="">Pilih Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Alamat</span>
                    </label>
                    <textarea class="textarea textarea-bordered" wire:model.defer="alamat" required></textarea>
                    @error('alamat') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Barang</span>
                    </label>
                    @foreach($barang as $index => $item)
                        <input type="text" class="input input-bordered mb-2" 
                               wire:model="barang.{{ $index }}" placeholder="Masukkan item barang">
                        @error('barang.' . $index) <span class="text-red-500">{{ $message }}</span> @enderror
                    @endforeach
                    <button type="button" class="btn btn-secondary mt-2" wire:click="addBarang">Tambah Item</button>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Keterangan</span>
                    </label>
                    <textarea class="textarea textarea-bordered" wire:model.defer="keterangan"></textarea>
                </div>
            </form>
            
            <div class="modal-action">
                <button class="btn" wire:click="$set('showModal', false)">Batal</button>
                <button class="btn btn-primary" wire:click="save">Simpan</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button wire:click="$set('showModal', false)">close</button>
        </form>
    </dialog>

    <!-- Alert Confirmation -->
    <dialog x-data="{ open: @entangle('confirmingDelete') }" x-show="open" class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Hapus Surat Jalan</h3>
            <p>Apakah Anda yakin ingin menghapus Surat Jalan ini?</p>
            <div class="modal-action">
                <button class="btn" @click="open = false" wire:click="$set('confirmingDelete', false)">Batal</button>
                <button class="btn btn-error" wire:click="delete">Hapus</button>
            </div>
        </div>
    </dialog>
</div>
