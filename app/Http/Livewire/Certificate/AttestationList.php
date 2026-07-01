<?php

namespace App\Http\Livewire;

use App\Models\Attestation;
use Livewire\Component;

class AttestationList extends Component
{

    public function render()

    {
        return view('livewire.certificate.export-attestation-list');
    }
}
