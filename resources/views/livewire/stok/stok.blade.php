<div>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Stok</h1>
            <button class="btn btn-primary" wire:click="$set('showModal', true)">
                <x-tabler-plus class="size-5" />
                Tambah Data Stok
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
                                <th>Nama Barang</th>
                                <th>Kode Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stocks as $key => $stock)
                                <tr>
                                    <td>{{ $key + 1 + (($stocks->currentPage() - 1) * $stocks->perPage()) }}</td>
                                    <td>{{ $stock->nama_barang }}</td>
                                    <td>{{ $stock->kode_barang }}</td>
                                    <td>{{ $stock->jumlah }}</td>
                                    <td>Rp {{ number_format($stock->harga_beli, 2) }}</td>
                                    <td>Rp {{ number_format($stock->harga_jual, 2) }}</td>
                                    <td>
                                        <div class="badge {{ 
                                            $stock->status === 'tersedia' ? 'badge-success' :
                                            ($stock->status === 'menipis' ? 'badge-warning' : 'badge-error')
                                        }}">
                                            {{ $stock->status }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-1">
                                            <button wire:click="edit({{ $stock->id }})" class="btn-s btn btn-square btn-warning">
                                                <x-tabler-edit class="size-4"/>
                                            </button>
                                            <button wire:click="confirmDelete({{ $stock->id }})" class="btn-s btn btn-square btn-error">
                                                <x-tabler-trash class="size-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">Tidak ada data stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $stocks->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <dialog class="modal" x-bind:open="$wire.showModal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">
                {{ $editingId ? 'Edit Stok' : 'Tambah Stok Baru' }}
            </h3>
            <form class="space-y-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama Barang</span>
                    </label>
                    <input type="text" class="input input-bordered" 
                           wire:model="nama_barang">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Kode Barang</span>
                    </label>
                    <input type="text" class="input input-bordered" 
                           wire:model="kode_barang">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Jumlah</span>
                    </label>
                    <input type="number" class="input input-bordered" 
                           wire:model="jumlah">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Harga Beli</span>
                    </label>
                    <input type="number" class="input input-bordered" 
                           wire:model="harga_beli" step="0.01">
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Harga Jual</span>
                    </label>
                    <input type="number" class="input input-bordered" 
                           wire:model="harga_jual" step="0.01">
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select wire:model="status" class="select select-bordered">
                        <option value="tersedia">Tersedia</option>
                        <option value="menipis">Stok Menipis</option>
                        <option value="habis">Habis</option>
                    </select>
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
    <x-dialog-modal :show-modal="$confirmingDelete" title="Hapus Stok">
        <x-slot name="content">
            Apakah Anda yakin ingin menghapus stok ini?
        </x-slot>
    
        <x-slot name="footer">
            <button class="btn" wire:click="$set('confirmingDelete', false)">Batal</button>
            <button class="btn" wire:click="delete">Hapus</button>
        </x-slot>
    </x-dialog-modal>
</div>
