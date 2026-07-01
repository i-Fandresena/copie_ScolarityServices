<?php

namespace App\Http\Livewire\Modal;

use Livewire\Component;

class Modal extends Component
{
    public $Modalmessage;
    public $Modaltype;
    public $student;
    public $session;
    public $matiere;
    public $niveau;
    public $note;
    public $idAttestation;
    public $numeroAttestation;

    protected $listeners = ['modal' => 'setModalMessage'];

    public function render()
    {
        return view('livewire.modal.modal');
    }

//    send data to NoteTrans (valeur a modifié)
    public function updateNote(){
        if ($this->Modaltype === 'confirm'){
            $this->emit('updateNote', $this->student, $this->note);
        }
        if ($this->Modaltype === 'delete'){
            $this->emit('deleteNote', json_decode($this->student));
        }
        if ($this->Modaltype === 'deleteUE'){
            $this->emit('finalDeleteUE', $this->note);
        }
        if ($this->Modaltype === 'deleteMat'){
            $this->emit('finalDeleteMat', $this->note);
        }
        if ($this->Modaltype === 'archiveCdt'){
            $this->emit('archiveCdt');
        }
        if ($this->Modaltype === 'deleteStudent'){
            $this->emit('deleteStudent', $this->note);
        }
    }

    public function deleteAttestation(){
        if ($this->Modaltype === 'deleteAttestation'){
            $this->emit('deleteAttestation', $this->idAttestation);
        }
        if ($this->Modaltype === 'deleteReleve'){
            $this->emit('deleteReleve', $this->idAttestation);
        }
    }

    public function deleteAdmis(){
        if ($this->Modaltype === 'deleteAdmis'){
            $this->emit('deleteAdmis');
        }
    }

    public function setModalMessage($message, $type, $student, $note){
        $this->Modalmessage = $message;
        $this->Modaltype = $type;
        $this->student = $student;
        $this->note = $note;
        if ($this->Modaltype === 'deleteAttestation'){
            $this->idAttestation = $student;
            $this->numeroAttestation = $note;
        }
        if ($this->Modaltype === 'deleteReleve'){
            $this->idAttestation = $student;
            $this->numeroAttestation = $note;
        }
        if ($this->Modaltype === 'deleteStudent'){
            $this->note = $student;
        }

        $this->dispatchBrowserEvent('modal-message');
    }
}
