<div class="page-wrapper p-4 mt-0">
    <div class="grid gap-4 md:grid-cols-12 md:gap-4">
        <div class="md:col-span-7 card h-[calc(100vh-5rem)] bg-white shadow-lg rounded-lg border border-gray-200 overflow-y-auto">
            <div class="card-body sticky top-0 bg-white z-10">
                <input type="search" class="input input-bordered w-full" placeholder="Cari Barang" wire:model.live='search'>
            </div>
            @forelse ($menus as $type => $menuItems)
                <div class="card-body pt-2">
                    <h3 class="text-xl font-bold capitalize mb-2">{{ $type }}</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                        @foreach ($menuItems as $item)
                            <div class="flex flex-col hover:shadow-md transition-all duration-200 rounded-lg p-2">
                                <button class="w-full" wire:click='addItem({{ $item->id }})'>
                                    <div class="aspect-square rounded-lg overflow-hidden mb-2">
                                        <img src="{{ $item->photo_url }}" 
                                             alt="{{ $item->name }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                </button>
                                <p class="font-bold text-center">{{ $item->name }}</p>
                                <p class="text-center text-sm font-medium">Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-center text-xs">Stok: {{ $item->stock }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="card-body">
                    <p class="text-center text-gray-500">Tidak ada menu tersedia</p>
                </div>
            @endforelse
        </div>
        <div class="md:col-span-5 card sticky top-20 h-fit bg-white shadow-lg rounded-lg border border-gray-200 transition-all duration-200 hover:shadow-xl">
            <form class="card-body space-y-3" wire:submit='simpan'>
                <h3 class="card-title mb-2">Detail transaksi</h3>

                <div @class([
                    'table-wrapper',
                    'border-error' => $errors->first('form.items'),
                ])>
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>QTY</th>
                                <th>Harga Satuan</th>
                                <th>Harga Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items ?? [] as $key => $value)
                                @php
                                    $price = (float) $value['price'];
                                    $qty = (float) $value['qty'];
                                    $hargaSatuan = $qty > 0 ? $price / $qty : 0;
                                @endphp
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $qty }}</td>
                                    <td>Rp. {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($price, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-square btn-xs"
                                            wire:click="removeItem('{{ $key }}')">
                                            <x-tabler-minus class="size-4" />
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-bold">Total Keseluruhan:</td>
                                <td colspan="2" class="font-bold">Rp. {{ number_format($this->getTotalPrice(), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Uang Diterima</span>
                        </label>
                        <input type="text" 
                               class="input input-bordered" 
                               placeholder="Masukkan jumlah uang" 
                               wire:model.live="uangDiterima"
                               x-data
                               x-on:input="
                                   let value = $event.target.value.replace(/\D/g, '');
                                   value = value.replace(/^0+/, '');
                                   if (value === '') {
                                       $event.target.value = '';
                                       $wire.set('uangDiterima', '');
                                   } else {
                                       $event.target.value = new Intl.NumberFormat('id-ID').format(value);
                                       $wire.set('uangDiterima', value);
                                   }
                               "
                               inputmode="numeric">
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Kembalian</span>
                        </label>
                        <div class="input input-bordered flex items-center">
                            Rp. {{ number_format($this->getKembalian(), 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <select class="select select-bordered w-full" wire:model='form.customer_id'>
                    <option value="">Pilih Customer</option>
                    @foreach ($customers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>

                <label class="block">
                    <span class="label-text">Metode Pembayaran</span>
                    <select class="select select-bordered w-full @error('form.desc') select-error @enderror" 
                            wire:model='form.desc'>
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="Cash">Cash</option>
                        <option value="QRIS">QRIS</option>
                        <option value="Virtual Account">Virtual Account</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                    </select>
                    @error('form.desc') <span class="text-error">{{ $message }}</span> @enderror
                </label>

                <div class="card-actions justify-between">
                    <div class="flex flex-col gap-1">
                        <div class="text-sm">Ringkasan Pembayaran:</div>
                        <div class="text-lg font-bold">
                            Total: Rp. {{ number_format((float) $this->getTotalPrice(), 0, ',', '.') }}
                        </div>
                        <div class="text-sm font-normal">
                            Dibayar: Rp. {{ number_format((float) $this->uangDiterima, 0, ',', '.') }}
                        </div>
                        <div class="text-sm font-normal">
                            Kembalian: Rp. {{ number_format((float) $this->getKembalian(), 0, ',', '.') }}
                        </div>
                    </div>
                    <button class="btn btn-primary" {{ $this->getKembalian() < 0 ? 'disabled' : '' }}>
                        <x-tabler-check class="size-5" />
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>