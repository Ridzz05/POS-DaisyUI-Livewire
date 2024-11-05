<div>
    <input type="checkbox" class="modal-toggle" @checked($show) />
    <div class="modal" role="dialog">
        <!-- wire:submit mengarah ke simpan yang ada di Action livewire -->
        <form class="modal-box" wire:submit="simpan">
            <h3 class="text-lg font-bold">Form input menu!</h3>
            <div class="space-y-2 py-4">
                {{-- nama --}}
                <label class="form-control" for="">
                    <div class="label">
                        <span class="label-text">Nama customer</span>
                    </div>
                    {{-- wire model form.name diambil dari Actions livewire --}}
                    <input type="text" placeholder="Nama..." @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.name'),
                    ]) wire:model='form.name' />
                </label>
                {{-- harga --}}
                <label class="form-control" for="">
                    <div class="label">
                        <span class="label-text">Kontak</span>
                    </div>
                    <input type="number" placeholder="Nomor" @class([
                        'input input-bordered',
                        'input-error' => $errors->first('form.contact'),
                    ]) wire:model='form.contact' />
                </label>
                {{-- keterangan --}}
                <label class="form-control" for="">
                    <div class="label">
                        <span class="label-text">Keterangan</span>
                    </div>
                    <textarea placeholder="Keterangan..." @class([
                        'textarea textarea-bordered',
                        'textarea-error' => $errors->first('form.desc'),
                    ]) wire:model='form.desc'>
                    </textarea>
                </label>
            </div>
            <div class="modal-action justify-between">
                <button type="button" class="btn btn-ghost" wire:click="closeModal">Close!</button>
                <button class="btn btn-primary">
                    <x-tabler-check class="size-5" />
                    <span>Save!</span>
                </button>
            </div>
        </form>
    </div>
</div>
