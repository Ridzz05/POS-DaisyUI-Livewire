<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class Index extends Component
{

    //declare variable search
    public $search;

    public $no = 1; //declare variable no

    //dispatch reload
    protected $listeners = ['reload' => '$refresh'];

    public function render()
    {
        return view('livewire.customer.index', [ //parsing data
            // tambahkan ketika ada search
            'customers' => Customer::when($this->search, function ($customer) {
                $customer->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('contact', 'like', '%' . $this->search . '%')
                    ->orWhere('desc', 'like', '%' . $this->search . '%');
            })->get() //getAll data customer
        ]);
    }
}
