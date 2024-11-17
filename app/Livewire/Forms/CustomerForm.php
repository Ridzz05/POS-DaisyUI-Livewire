<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{
    public $name;
    public $contact;
    public $desc;

    public ?Customer $customer;

    //set customer name
    public function setcustomer(Customer $customer)
    {
        $this->customer = $customer;

        $this->name = $customer->name;
        $this->contact = $customer->contact;
        $this->desc = $customer->desc;
    }

    //function save data
    public function store()
    {
        $validate = $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'desc' => '',
        ]);

        // Save the customer
        customer::create($validate);

        // Reset the form
        $this->reset();
    }

    //function update data
    public function update()
    {
        $validate = $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'desc' => '',
        ]);

        // update data customer
        $this->customer->update($validate);

        // Reset the form
        $this->reset();
    }
}