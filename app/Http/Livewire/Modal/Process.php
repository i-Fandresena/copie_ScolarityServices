<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class Process extends Component
{
    protected $listeners = [
        'startProcess' => 'startProcess',
        'endProcess' => 'endProcess',
    ];

    public function startProcess()
    {
        $this->dispatchBrowserEvent('show-process');
    }

    public function endProcess()
    {
        $this->dispatchBrowserEvent('hide-process');
    }

    public function render()
    {
        return view('livewire.modal.process');
    }
}
