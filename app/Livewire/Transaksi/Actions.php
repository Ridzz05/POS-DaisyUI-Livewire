<?php
    
    namespace App\Livewire\Transaksi;
    
    use App\Livewire\Forms\TransaksiForm;
    use App\Models\Customer;
    use App\Models\Menu;
    use App\Models\Transaksi;
    use Illuminate\Support\Facades\Storage;
    use Livewire\Component;
    use App\Helpers\Number;
    
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
    
        // Tambahkan property untuk uang diterima
        public $uangDiterima = 0;
    
        public function addItem(Menu $menu)
        {
            if ($menu->stock > 0) {
                if (isset($this->items[$menu->name])) {
                    $item = $this->items[$menu->name];
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

                // Kurangi stok di database
                $menu->stock -= 1;
                $menu->save();
            } else {
                session()->flash('error', 'Stok tidak mencukupi');
                return;
            }
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
                // Konversi ke float sebelum dijumlahkan
                return (float) array_sum($prices);
            }
            return 0.0;
        }
    
        // Tambahkan method untuk menghitung kembalian
        public function getKembalian()
        {
            $total = (float) $this->getTotalPrice();
            // Jika uang diterima kosong, return nilai negatif dari total
            if (empty($this->uangDiterima)) {
                return -$total;
            }
            // Hapus semua karakter non-digit sebelum konversi
            $uangDiterima = (float) preg_replace('/\D/', '', $this->uangDiterima);
            return $uangDiterima - $total;
        }
    
        //function untuk simpan transaksi (pada tombol simpan berada di form transaksi->warna kuning)
        public function simpan()
        {
            // Validasi dasar
            if (empty($this->items)) {
                session()->flash('error', 'Belum ada item yang dipilih');
                return;
            }
    
            // Validasi pembayaran
            if ($this->getKembalian() < 0) {
                session()->flash('error', 'Uang yang diberikan kurang dari total pembelian');
                return;
            }
    
            try {
                // Set data transaksi
                $this->form->items = $this->items;
                $this->form->price = $this->getTotalPrice();
                
                // Format informasi pembayaran
                $pembayaranInfo = sprintf(
                    "\nUang Diterima: Rp. %s\nKembalian: Rp. %s",
                    number_format($this->uangDiterima, 2, ',', '.'),
                    number_format($this->getKembalian(), 2, ',', '.')
                );
                
                // Tambahkan info pembayaran ke deskripsi
                $this->form->desc = ($this->form->desc ?? '') . $pembayaranInfo;
    
                // Simpan transaksi
                if (isset($this->form->transaksi)) {
                    $this->form->update();
                } else {
                    $this->form->store();
                }
    
                // Redirect setelah sukses
                session()->flash('success', 'Transaksi berhasil disimpan');
                $this->redirect(route('transaksi.index'), true);
    
            } catch (\Exception $e) {
                session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
                return;
            }
        }
    
        //ketika halaman pertama di load
        public function mount()
        {
            //cek apakah ada data transaksi
            if (isset($this->transaksi)) {
                $this->form->setTransaksi($this->transaksi);
                $this->items = $this->form->items;
            }
            $this->uangDiterima = 0;
        }
    
        public function render()
        {
            // Ambil menu dan group berdasarkan type
            $menus = Menu::when($this->search, function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('type', 'like', '%' . $this->search . '%');
                })
                ->where('availability', 'tersedia')
                ->where('stock', '>', 0)
                ->get()
                ->groupBy('type');

            return view('livewire.transaksi.actions', [
                'menus' => $menus,
                'customers' => Customer::pluck('name', 'id')
            ]);
        }
    
        public function updatedUangDiterima($value)
        {
            // Jika input kosong, set ke empty string
            if (empty($value)) {
                $this->uangDiterima = '';
                return;
            }
            // Simpan nilai numerik murni (tanpa format)
            $this->uangDiterima = preg_replace('/\D/', '', $value);
        }
    }