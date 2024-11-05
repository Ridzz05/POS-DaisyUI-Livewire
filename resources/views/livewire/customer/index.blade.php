<div class="page-wrapper">
    {{-- search  --}}
    <div class="flex flex-col justify-between gap-2 md:flex-row">
        <!-- wire:model.live akan melalukan pencarian dengan filter secara langsung -->
        <input type="text" class="input input-bordered" placeholder="Pencarian.." wire:model.live="search">

        {{-- wire:click mengarah pada action livewire --}}
        <button class="btn btn-primary" wire:click="dispatch('createCustomer')" wire:loading.attr="disabled">
            <x-tabler-plus class="size-5" />
            <span>tambah customer</span>
            <span wire:loading wire:target="dispatch('createCustomer')" class="loading-spinner"></span>
        </button>
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Nomer </th>
                <th>Keterangan</th>
                <th class="text-center">Aksi</th>
            </thead>
            <tbody>
                {{-- foreach dari livewire --}}
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->contact }}</td>
                        <td>{{ Str::limit($customer->desc, 50) }}</td>
                        <td>
                            <div class="flex justify-center gap-1">
                                <!-- wire:click for edit with customer:id -->
                                <button class="btn-s btn btn-square btn-warning"
                                    wire:click="$dispatch('editCustomer', {customer: {{ $customer->id }}})"
                                    wire:loading.class="opacity-50 transition-opacity duration-30">
                                    <x-tabler-edit class="size-4" />
                                </button>
                                <button class="btn-s btn btn-square btn-error"
                                    wire:click="$dispatch('deleteCustomer', {customer: {{ $customer->id }}})"
                                    wire:loading.class="opacity-50 transition-opacity duration-30">
                                    <x-tabler-trash class="size-4" />
                                </button>
                                <span wire:loading wire:target="$dispatch('editCustomer')" class="loading-spinner"></span>
                                <span wire:loading wire:target="$dispatch('deleteCustomer')" class="loading-spinner"></span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @livewire('customer.actions')
</div>