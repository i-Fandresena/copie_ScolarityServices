<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class ModalExcel extends Component
{
    public $Modalmessage;
    public $Modaltype;
    protected $listeners = ['modalExcel' => 'setModalMessage'];

    public function render()
    {
        return view('livewire.modal.modal-excel');
    }

    public function confirm(){
        if ($this->Modaltype === 'confirm') $this->emit('UpdateImport');
//        if ($this->Modaltype === 'deleteUE') $this->emit('finalDeleteUE');
    }
    public function setModalMessage($type){
        $this->Modaltype = $type;
        $this->dispatchBrowserEvent('modal-excel');
    }
}
