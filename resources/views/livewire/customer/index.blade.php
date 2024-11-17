<div>
    <div class="container mx-auto p-6">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Customer</h1>
            <button class="btn btn-primary" wire:click="dispatch('createCustomer')">
                <x-tabler-plus class="size-5" />
                Tambah Data Customer
            </button>
        </div>

        {{-- Card Wrapper --}}
        <div class="card bg-white shadow-lg rounded-lg">
            <div class="card-body">
                {{-- Search Bar --}}
                <div class="flex justify-between items-center mb-4">
                    <div class="form-control w-full max-w-xs">
                        <input type="text" 
                               placeholder="Cari customer..." 
                               class="input input-bordered w-full" 
                               wire:model.live.debounce.30ms="search">
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border-b border-gray-200">No</th>
                                <th class="px-4 py-2 border-b border-gray-200">Nama Customer</th>
                                <th class="px-4 py-2 border-b border-gray-200">Nomor</th>
                                <th class="px-4 py-2 border-b border-gray-200">Keterangan</th>
                                <th class="px-4 py-2 border-b border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $key => $customer)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border-b border-gray-200 text-center">{{ $key + 1 }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $customer->name }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ $customer->contact }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200">{{ Str::limit($customer->desc, 50) }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button class="btn btn-xs btn-warning"
                                                wire:click="$dispatch('editCustomer', {customer: {{ $customer->id }}})">
                                                <x-tabler-edit class="size-4" />
                                            </button>
                                            <button class="btn btn-xs btn-error"
                                                wire:click="$dispatch('deleteCustomer', {customer: {{ $customer->id }}})">
                                                <x-tabler-trash class="size-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada data customer.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Component --}}
    @livewire('customer.actions')
</div>