<div>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Barang Masuk</h1>
            <button class="btn btn-primary" wire:click="$set('showModal', true)">
                <x-tabler-plus class="size-5" />
                Tambah Data Barang
            </button>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div class="form-control w-full max-w-xs">
                        <input type="text" placeholder="Cari barang..." 
                               class="input input-bordered w-full" 
                               wire:model.live.debounce.30ms="search">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMasuks as $index => $barangMasuk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $barangMasuk->date }}</td>
                                    <td>{{ $barangMasuk->supplier->name ?? 'Supplier Tidak Ditemukan' }}</td>
                                    <td>{{ $barangMasuk->item_name }}</td>
                                    <td>{{ $barangMasuk->quantity }}</td>
                                    <td>
                                        <div class="flex justify-center gap-1">
                                        <button class="btn-s btn btn-square btn-warning" wire:click="edit({{ $barangMasuk->id }})">
                                            <x-tabler-edit class="size-4"/>
                                        </button>
                                        <button class="btn-s btn btn-square btn-error" wire:click="confirmDelete({{ $barangMasuk->id }})">
                                            <x-tabler-trash class="size-4" />
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data barang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $barangMasuks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <dialog class="modal" x-bind:open="$wire.showModal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">
                {{ $editingId ? 'Edit Barang Masuk' : 'Tambah Barang Masuk' }}
            </h3>
            <form class="space-y-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Supplier</span>
                    </label>
                    <select class="select select-bordered" wire:model="supplier_id">
                        <option value="">Pilih Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama Barang</span>
                    </label>
                    <input type="text" class="input input-bordered" 
                           wire:model="item_name">
                    @error('item_name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Jumlah</span>
                    </label>
                    <input type="number" class="input input-bordered" 
                           wire:model="quantity">
                    @error('quantity') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanggal</span>
                    </label>
                    <input type="date" class="input input-bordered" 
                           wire:model="date">
                    @error('date') <span class="text-red-500">{{ $message }}</span> @enderror
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
</div>
