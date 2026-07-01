<?php

namespace App\Http\Livewire\Export;

use Livewire\Component;

class ExportModel extends Component
{
    public string $selectedLevel = '';
    public string $name = '';
    public string $extension = 'xlsx';

    public function render()
    {
        switch ($this->selectedLevel) {
            case "L1":
                $niveau = 'L1';
                break;
            case "L2":
                $niveau = 'L2';
                break;
            case "L3":
                $niveau = 'L3';
                break;
            case "M1":
                $niveau = 'M1';
                break;
            case "M2":
                $niveau = 'M2';
                break;
            case "M2R":
                $niveau = 'M2R';
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $niveau = 'L1';
                }
                if(Auth()->user()->role === "Master"){
                    $niveau = 'M1';
                }
                break;
        }
        return view('livewire.export.export-model')
            ->with('niveau', $niveau);
    }
}
