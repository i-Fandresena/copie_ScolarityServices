<?php

namespace App\Http\Livewire\Profile;

use App\Models\Droit;
use Livewire\Component;

class GestionDroit extends Component
{
    public $typeDroit;
    public $montantDroit;
    public $montantDroitEdit;
    public $designation;

    public $showEditDroit;

    public function render()
    {
        $droits = Droit::where('role', Auth()->user()->role)->get();
        return view('livewire.profile.gestion-droit', [
            'droits' => $droits,
        ]);
    }

    public function setShowEditDroit($id)
    {
        $this->showEditDroit = $id;
    }

    public function save(){
        try {
            $this->montantDroit = preg_replace('/\s+/', '', $this->montantDroit);
            $this->validate([
                'montantDroit' => ['required', 'integer'],
                'designation' => 'required',
            ]);

            if($this->typeDroit === null)
            {
                if(Auth()->user()->role === "Licence") $this->typeDroit = 'PL';
                if(Auth()->user()->role === "Master") $this->typeDroit = 'PM1';
            }

            $droit = new Droit();
            $droit->typeDroit = $this->typeDroit;
            $droit->montantDroit = $this->montantDroit;
            $droit->designation = $this->designation;
            $droit->role = Auth()->user()->role;
            $droit->createdBy = Auth()->user()->name;
            $droit->save();

            $this->reset();
            $this->emit('flash', 'Droit ajouté avec succès', 'success');
        }catch (\Exception $e){
            $this->emit('flash', 'Type droit existant !', 'error');
        }
    }

    public function editDroit($data)
    {
        try {
            $this->montantDroitEdit = preg_replace('/\s+/', '', $data['montantDroit']);
            $this->validate([
                'montantDroitEdit' => ['required', 'integer'],
            ]);

            if($data['typeDroit'] === null)
            {
                if(Auth()->user()->role === "Licence") $this->typeDroit = 'PL';
                elseif(Auth()->user()->role === "Master") $this->typeDroit = 'PM1';
            }

            $droit = Droit::find($this->showEditDroit);
            $droit->montantDroit = $this->montantDroitEdit;
            $droit->role = Auth()->user()->role;
            $droit->udatedBy = Auth()->user()->name;
            $droit->save();

            $this->reset();
            $this->emit('flash', 'Droit édité avec succès', 'success');
        }catch (\Exception $e){
            $this->emit('flash', 'Erreur lors de la modification !', 'error');
        }
    }

    public function deleteDroit($id)
    {
        Droit::destroy($id);
        $this->emit('flash', 'Droit supprimé avec succès', 'success');
    }
}
