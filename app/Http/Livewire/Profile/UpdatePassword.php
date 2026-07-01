<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $password;
    public $newPassword;
    public $confirmPassword;

    public function render()
    {
        return view('livewire.profile.update-password');
    }

    public function rules()
    {
        return [
            'password' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword',
        ]);
    }

    public function update()
    {
        $this->validate();

        if (Hash::check($this->password, Auth::user()->password)) {
            Auth::user()->update([
                'password' => Hash::make($this->newPassword),
            ]);
            $this->emit('flash', 'Mot de passe a étè modifié avec succée', 'success');
        } else {
            $this->emit('flash', 'Verifier votre mot de passe', 'error');
            $this->addError('password', 'Mot de passe incorrecte    ');
        }
    }

}
