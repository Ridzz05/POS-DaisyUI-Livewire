<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <input type="text" class="input input-bordered w-full max-w-md" placeholder="Pencarian.." wire:model.live="search">
        <button class="btn btn-primary flex items-center gap-2" wire:click="$dispatch('createMenu')">
            <x-tabler-plus class="size-5" />
            <span>Tambah Produk</span>
        </button>
    </div>

    <div class="card bg-white shadow-lg rounded-lg">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b border-gray-200">No</th>
                            <th class="px-4 py-2 border-b border-gray-200">Menu</th>
                            <th class="px-4 py-2 border-b border-gray-200">Harga</th>
                            <th class="px-4 py-2 border-b border-gray-200">Keterangan</th>
                            <th class="px-4 py-2 border-b border-gray-200">Stok</th>
                            <th class="px-4 py-2 border-b border-gray-200">Status</th>
                            <th class="px-4 py-2 border-b border-gray-200 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2 border-b border-gray-200 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <div class="flex items-center gap-4 relative">
                                        <div class="avatar">
                                            <div class="w-12 h-12 rounded-lg border overflow-hidden relative">
                                                <img src="{{ $menu->photo_url }}" 
                                                     alt="{{ $menu->name }}"
                                                     onerror="this.src='{{ asset('images/no-image.png') }}'"
                                                     class="object-cover w-full h-full">
                                                @if($menu->stock == 0)
                                                    <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                                        <span class="text-white text-xs font-bold">Barang Habis</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-semibold">{{ $menu->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $menu->type }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">Rp. {{ number_format($menu->price, 2, '.', ',') }}</td>
                                <td class="px-4 py-2 border-b border-gray-200 w-64">
                                    <div class="line-clamp-2">{{ $menu->desc }}</div>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200 text-center">
                                    <span class="font-medium {{ $menu->stock <= 5 ? 'text-red-500' : 'text-green-500' }}">
                                        {{ $menu->stock }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200 text-center">
                                    <span class="badge {{ 
                                        $menu->availability === 'tersedia' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-red-100 text-red-800' 
                                    }} px-2 py-1 rounded-full">
                                        {{ $menu->availability === 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="btn btn-xs btn-warning" wire:click="$dispatch('editMenu', {{ $menu->id }})">
                                            <x-tabler-edit class="size-4" />
                                        </button>
                                        <button class="btn btn-xs btn-error" wire:click="$dispatch('deleteMenu', {{ $menu->id }})">
                                            <x-tabler-trash class="size-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form for Input -->
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <form class="modal-box" wire:submit.prevent="simpan">
            <h3 class="text-lg font-bold mb-4">Form Input Menu</h3>
            <div class="space-y-4">
                <div class="flex flex-col items-center">
                    <label for="pickPhoto" class="avatar cursor-pointer">
                        <div class="w-32 rounded-xl border">
                            <img src="{{ $photo ? $photo->temporaryUrl() : ($form->menu?->photo_url ?? asset('no-image.png')) }}" 
                                 alt="Preview Foto">
                        </div>
                    </label>
                    <span class="text-xs text-gray-500">*Klik foto untuk mengunggah</span>
                </div>

                <input type="file" class="hidden" id="pickPhoto" wire:model="photo" />

                <!-- Nama Menu -->
                <label class="block">
                    <span class="label-text">Nama Menu</span>
                    <input type="text" placeholder="Nama..." 
                           class="input input-bordered w-full @error('form.name') input-error @enderror" 
                           wire:model="form.name">
                    @error('form.name') <span class="text-error">{{ $message }}</span> @enderror
                </label>

                <!-- Harga Menu -->
                <label class="block">
                    <span class="label-text">Harga Menu</span>
                    <input type="number" placeholder="Harga..." 
                           class="input input-bordered w-full @error('form.price') input-error @enderror" 
                           wire:model="form.price">
                    @error('form.price') <span class="text-error">{{ $message }}</span> @enderror
                </label>

                <!-- Tipe Menu -->
                <label class="block">
                    <span class="label-text">Tipe Menu</span>
                    <select class="select select-bordered w-full @error('form.type') select-error @enderror" 
                            wire:model="form.type">
                        <option value="">Pilih Tipe</option>
                        @foreach ($types as $tipe)
                            <option value="{{ $tipe }}">{{ $tipe }}</option>
                        @endforeach
                    </select>
                    @error('form.type') <span class="text-error">{{ $message }}</span> @enderror
                </label>

                <!-- Keterangan Menu -->
                <label class="block">
                    <span class="label-text">Keterangan Menu</span>
                    <textarea placeholder="Keterangan..." 
                              class="textarea textarea-bordered w-full @error('form.desc') textarea-error @enderror" 
                              wire:model="form.desc"></textarea>
                    @error('form.desc') <span class="text-error">{{ $message }}</span> @enderror
                </label>

                <!-- Stok Barang -->
                <label class="block">
                    <span class="label-text">Stok Barang</span>
                    <input type="number" placeholder="Stok..." 
                           class="input input-bordered w-full @error('form.stock') input-error @enderror" 
                           wire:model="form.stock">
                    @error('form.stock') <span class="text-error">{{ $message }}</span> @enderror
                </label>

                <!-- Ketersediaan Barang -->
                <label class="block">
                    <span class="label-text">Ketersediaan Barang</span>
                    <select class="select select-bordered w-full @error('form.availability') select-error @enderror" 
                            wire:model="form.availability">
                        <option value="">Pilih Ketersediaan</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak_tersedia">Tidak Tersedia</option>
                    </select>
                    @error('form.availability') <span class="text-error">{{ $message }}</span> @enderror
                </label>
            </div>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost" wire:click="closeModal">Tutup</button>
                <button type="submit" class="btn btn-primary flex items-center gap-2">
                    <x-tabler-check class="size-5" />
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
