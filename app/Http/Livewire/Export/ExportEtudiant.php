<?php

namespace App\Http\Livewire\Export;

use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveL3;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveM2;
use App\Models\Archives\ArchiveMR;
use Livewire\Component;

class ExportEtudiant extends Component
{

    public string $selectedLevel = '';
    public string $name = '';
    public string $extension = 'xlsx';

    public function render()
    {
        switch ($this->selectedLevel) {
            case "L1":
                $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                $niveau = 'L1';
                break;
            case "L2":
                $annees = ArchiveL2::select('anneeUnivers')->distinct()->get();
                $niveau = 'L2';
                break;
            case "L3":
                $annees = ArchiveL3::select('anneeUnivers')->distinct()->get();
                $niveau = 'L3';
                break;
            case "M1":
                $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                $niveau = 'M1';
                break;
            case "M2":
                $annees = ArchiveM2::select('anneeUnivers')->distinct()->get();
                $niveau = 'M2';
                break;
            case "M2-R":
                $annees = ArchiveMR::select('anneeUnivers')->distinct()->get();
                $niveau = 'M2-R';
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                    $niveau = 'L1';
                }
                if(Auth()->user()->role === "Master"){
                    $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                    $niveau = 'M1';
                }
                break;
        }
        return view('livewire.export.export-etudiant', [
            'niveau' => $niveau,
            'annees' => $annees,
        ]);
    }
}
