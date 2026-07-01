<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;

class EditProfile extends Component
{

    public $nom;
    public $prenom;
    public $email;

    public function render()
    {
        return view('livewire.profile.edit-profile');
    }

    public function messages()
    {
        return [
            'nom.required' => 'Vous devez ajouté le champ nom',
            'email.required' => 'Vous devez ajouté le champ email',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);
    }

    public function updateProfile($userId){
        $user = User::find($userId);

        $this->validate([
            'nom' => 'required|max:255',
            'prenom' => 'nullable|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->name = $this->nom;
        $user->prenom = $this->prenom;
        $user->email = $this->email;

        $user->save();

        $this->emit('flash', 'Votre profile a ete mis à jour', 'success');
    }

    public function dataSet($userId, $data){
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->email = $data['email'];
    }

}
