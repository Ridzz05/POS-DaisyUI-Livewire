<?php

namespace App\Livewire\Transaksi;

use App\Livewire\Forms\TransaksiForm;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Actions extends Component
{
    //search public property
    public $search;

    //item total public property
    public $items = []; //ini akan menyimpan 2 data obj yaitu nama makanan , qty dan price

    //form
    public TransaksiForm $form;

    //DB. berikan ? siapa tau bernilai null
    public ?Transaksi $transaksi;

    public function addItem(Menu $menu)
    {
        //$menu->name adalah key
        if (isset($this->items[$menu->name])) {
            // jika item sudah ada, tambahkan qty
            $item = $this->items[$menu->name];

            //tambahkan qty dan price jika item sudah ada
            $this->items[$menu->name] = [
                'qty' => $item['qty'] + 1,
                'price' => $item['price'] + $menu->price,
            ];
        } else {
            $this->items[$menu->name] = [
                'qty' => 1,
                'price' => $menu->price,
            ];
        }
        // dd($this->items);
    }

    public function removeItem($key)
    {
        $item = $this->items[$key];

        //jika qty lebih dari 1, kurangi qty dan price
        if ($item['qty'] > 1) {
            //deklare
            $hargaSatuan = $item['price'] / $item['qty'];
            $qtyBaru = $item['qty'] - 1;

            //kurangi qty dan price jika item lebih dari 1
            $this->items[$key]['qty'] = $qtyBaru;
            $this->items[$key]['price'] = $hargaSatuan * $qtyBaru;
        } else {
            //unset
            unset($this->items[$key]);
        }
    }

    public function getTotalPrice()
    {
        if (isset($this->items)) {
            $prices = array_column($this->items, 'price');
            //return sum
            return array_sum($prices);
        } else {
            return 0;
        }
    }

    //function untuk simpan transaksi (pada tombol simpan berada di form transaksi->warna kuning)
    public function simpan()
    {
        //set, ambil seluruh data dalam form items dimasukkan dalam arrat
        $this->form->items = $this->items;
        //set dalam form price ke getTotalPrice
        $this->form->price = $this->getTotalPrice();

        if (isset($this->form->transaksi)) {
            // jika mengambil dari edit, maka lakukan update form
            $this->form->update();
        } else {
            //jalankan store pada form
            $this->form->store();
        }

        //jika sudah redirect ke index riwayat transaksi
        $this->redirect(route('transaksi.index'), true);

        // dd($this->items, $this->form->customer_id, $this->form->desc);
    }

    //ketika halaman pertama di load
    public function mount()
    {
        //cek apakah ada data transaksi
        if (isset($this->transaksi)) {
            $this->form->setTransaksi($this->transaksi);
            $this->items = $this->form->items;
        }
    }

    public function render()
    {
        return view('livewire.transaksi.actions', [
            //get menu. jika terdapat search gunakan function search, jika tidak get by type;
            'menus' => Menu::when($this->search, function ($menu) {
                $menu->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%')
                    ->orWhere('desc', 'like', '%' . $this->search . '%');
            })->get()->groupBy('type'),
            //get customer
            'customers' => Customer::pluck('name', 'id')
        ]);
    }
}
