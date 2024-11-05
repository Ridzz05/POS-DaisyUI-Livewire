<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DialogModal extends Component
{
    public $showModal; // Properti untuk mengontrol visibilitas modal
    public $title;     // Judul modal
    public $content;   // Konten modal
    public $footer;    // Footer modal

    public function __construct($showModal, $title = null, $content = null, $footer = null)
    {
        $this->showModal = $showModal;
        $this->title = $title;
        $this->content = $content;
        $this->footer = $footer;
    }

    public function render()
    {
        return view('components.dialog-modal');
    }
}
