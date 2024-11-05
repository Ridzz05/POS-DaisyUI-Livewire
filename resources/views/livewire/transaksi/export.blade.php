<div class="page-wrapper">
    <div class="card card-divider max-w-4xl mx-auto">
        <div class="card-body space-y-4">
            <h3 class="text-2xl font-bold">Export data transaksi</h3>
            <p class="text-sm opacity-60">Export data transaksi ke excel, pilih dahulu bulan yang akan di export, lalu klik to export</p>
        </div>
        <div class="card-body">
            <form class="card-actions justify-between" wire:submit="export">
            <input type="month" @class([
                    'input input-bordered',
                    'input-error' => $errors->first('bulan'),
                ]) wire:model='bulan'>
                <button wire:click='export' class="btn btn-primary">
                    <x-tabler-upload class="size-5" />
                    Klik to export
                </button>
            </form>
        </div>
    </div>
    {{-- menuju function export di Livewire Export --}}
</div>
