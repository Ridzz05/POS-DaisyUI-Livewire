<div class="page-wrapper">
    {{-- Search Bar --}}
    <div class="flex flex-col justify-between gap-2 md:flex-row">
        <input type="text" class="input input-bordered" placeholder="Pencarian.." wire:model.live="search">

        <button class="btn btn-primary" wire:click="$dispatch('createMenu')">
            <x-tabler-plus class="size-5" />
            <span>Tambah Produk</span>
        </button>
    </div>

    <div class="table-wrapper mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="flex gap-2">
                                <div class="avatar">
                                    <div class="w-10 rounded-lg border-2">
                                        <img src="{{ $menu->photo ? Storage::url($menu->photo) : url('no-image.png') }}" alt="{{ $menu->name }}">
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <span>{{ $menu->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $menu->type }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ number_format($menu->price, 2, ',', '.') }}</td>
                        <td class="w-80 whitespace-normal">
                            <div class="line-clamp-2">
                                {{ $menu->desc }}
                            </div>
                        </td>
                        <td>
                            <div class="flex justify-center gap-1">
                                <button class="btn-s btn btn-square btn-warning" wire:click="$dispatch('editMenu', {{ $menu->id }})">
                                    <x-tabler-edit class="size-4" />
                                </button>
                                <button class="btn-s btn btn-square btn-error" wire:click="$dispatch('deleteMenu', {{ $menu->id }})">
                                    <x-tabler-trash class="size-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Form for Input --}}
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <form class="modal-box" wire:submit.prevent="simpan">
            <h3 class="text-lg font-bold">Form Input Menu!</h3>
            <div class="space-y-2 py-4">
                <div class="flex flex-col items-center justify-center">
                    <label for="pickPhoto" class="avatar">
                        <div class="w-32 rounded-xl border-2">
                            <img class="cursor-pointer" src="{{ $photo ? $photo->temporaryUrl() : url('no-image.png') }}" alt="Preview Foto">
                        </div>
                    </label>
                    <span class="text-xs font-light">*Klik foto untuk mengunggah</span>
                </div>

                <input type="file" class="hidden" id="pickPhoto" wire:model='photo' />

                {{-- Nama Menu --}}
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Nama Menu</span>
                    </div>
                    <input type="text" placeholder="Nama..." @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.name'),
                    ]) wire:model='form.name' />
                </label>

                {{-- Harga Menu --}}
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Harga Menu</span>
                    </div>
                    <input type="number" placeholder="Harga..." @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.price'),
                    ]) wire:model='form.price' />
                </label>

                {{-- Tipe Menu --}}
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Tipe Menu</span>
                    </div>
                    <select @class([
                        'select select-bordered',
                        'select-error' => $errors->first('form.type'),
                    ]) wire:model='form.type'>
                        <option value="">Pilih Tipe</option>
                        @foreach ($types as $tipe)
                            <option value="{{ $tipe }}">{{ $tipe }}</option>
                        @endforeach
                    </select>
                </label>

                {{-- Keterangan Menu --}}
                <label class="form-control">
                    <div class="label">
                        <span class="label-text">Keterangan Menu</span>
                    </div>
                    <textarea placeholder="Keterangan..." @class([
                        'textarea textarea-bordered',
                        'textarea-error' => $errors->first('form.desc'),
                    ]) wire:model='form.desc'></textarea>
                </label>
            </div>

            <div class="modal-action justify-between">
                <button type="button" class="btn btn-ghost" wire:click="closeModal">Tutup</button>
                <button class="btn btn-primary">
                    <x-tabler-check class="size-5" />
                    <span>Simpan!</span>
                </button>
            </div>
        </form>
    </div>
</div>
