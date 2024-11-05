<div>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Supplier</h1>
            <button class="btn btn-primary" wire:click="$set('showModal', true)">
                <x-tabler-plus class="size-5" />
                Tambah Data Supplier
            </button>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <div class="form-control w-full max-w-xs">
                        <input type="text" placeholder="Cari supplier..." 
                               class="input input-bordered w-full" 
                               wire:model.live.debounce.30ms="search">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($suppliers as $key => $supplier)
                                <tr>
                                    <td>{{ $key + 1 + (($suppliers->currentPage() - 1) * $suppliers->perPage()) }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>
                                    <div class="flex justify-center gap-1">
                                        <button wire:click="edit({{ $supplier->id }})" class="btn-s btn btn-square btn-warning">
                                            <x-tabler-edit class="size-4"/>
                                        </button>
                                        <button wire:click="confirmDelete({{ $supplier->id }})" class="btn-s btn btn-square btn-error">
                                            <x-tabler-trash class="size-4" />
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data supplier.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $suppliers->links() }} <!-- Pagination links -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <dialog class="modal" x-bind:open="$wire.showModal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">
                {{ $editingId ? 'Edit Supplier' : 'Tambah Supplier Baru' }}
            </h3>
            <form class="space-y-4">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama Supplier</span>
                    </label>
                    <input type="text" class="input input-bordered" 
                           wire:model="name">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Alamat</span>
                    </label>
                    <textarea class="textarea textarea-bordered" 
                              wire:model="address"></textarea>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Telepon</span>
                    </label>
                    <input type="text" class="input input-bordered" 
                           wire:model="phone">
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" class="input input-bordered" 
                           wire:model="email">
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
    <x-dialog-modal :show-modal="$confirmingDelete" title="Hapus Supplier">
        <x-slot name="content">
            Apakah Anda yakin ingin menghapus supplier ini?
        </x-slot>
    
        <x-slot name="footer">
            <button class="btn" wire:click="$set('confirmingDelete', false)">Batal</button>
            <button class="btn" wire:click="delete">Hapus</button>
        </x-slot>
    </x-dialog-modal>
</div>
