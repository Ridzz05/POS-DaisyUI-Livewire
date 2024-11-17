<div>
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <div class="modal-box max-w-4xl flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-2/3 max-h-[70vh] overflow-y-auto pr-4">
                <h3 class="text-lg font-bold sticky top-0 bg-base-100 py-2">Form Input Customer</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Customer -->
                    <label class="form-control">
                        <div class="label">
                            <span class="label-text">Nama Customer</span>
                        </div>
                        <input type="text" placeholder="Nama..." 
                               class="input input-bordered w-full @error('form.name') input-error @enderror" 
                               wire:model='form.name' />
                        @error('form.name') <span class="text-error">{{ $message }}</span> @enderror
                    </label>

                    <!-- Kontak -->
                    <label class="form-control">
                        <div class="label">
                            <span class="label-text">Kontak</span>
                        </div>
                        <input type="number" placeholder="Nomor" 
                               class="input input-bordered w-full @error('form.contact') input-error @enderror" 
                               wire:model='form.contact' />
                        @error('form.contact') <span class="text-error">{{ $message }}</span> @enderror
                    </label>

                    <!-- Keterangan -->
                    <label class="form-control md:col-span-2">
                        <div class="label">
                            <span class="label-text">Keterangan</span>
                        </div>
                        <textarea placeholder="Keterangan..." 
                                  class="textarea textarea-bordered w-full @error('form.desc') textarea-error @enderror" 
                                  wire:model='form.desc'></textarea>
                        @error('form.desc') <span class="text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </div>
            <div class="w-full md:w-1/3 sticky top-0 h-fit">
                <div class="card bg-base-200 p-4">
                    <h4 class="font-semibold mb-2">Informasi</h4>
                    <img src="https://picsum.photos/200" alt="Customer Image" class="rounded-lg mb-4">
                    <p class="text-sm text-gray-600">Pastikan semua data yang diinput sudah benar sebelum menyimpan.</p>
                </div>
                <div class="modal-action flex-col gap-2 mt-4">
                    <button type="button" class="btn btn-primary w-full" wire:click="saveCustomer">
                        <x-tabler-check class="size-5" />
                        <span>Simpan</span>
                    </button>
                    <button type="button" class="btn btn-ghost w-full" wire:click="closeModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
