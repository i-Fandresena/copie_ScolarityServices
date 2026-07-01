<?php

namespace App\Http\Livewire\Export;

use App\Models\Archives\ArchiveCandidatL1;
use App\Models\Archives\ArchiveCandidatM1;
use App\Models\Archives\ArchiveCandidatM2;
use Livewire\Component;

class ExportCandidat extends Component
{

    public string $selectedLevel = '';
    public string $name = '';
    public string $extension = 'xlsx';

    public function render()
    {
        switch ($this->selectedLevel) {
            case "L1":
                $annees = ArchiveCandidatL1::select('anneeUnivers')->distinct()->get();
                $niveau = 'L1';
                break;
            case "M1":
                $annees = ArchiveCandidatM1::select('anneeUnivers')->distinct()->get();
                $niveau = 'M1';
                break;
            case "M2":
                $annees = ArchiveCandidatM2::select('anneeUnivers')->distinct()->get();
                $niveau = 'M2';
                break;
            case "M2-R":
                $niveau = 'M2-R';
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $annees = ArchiveCandidatL1::select('anneeUnivers')->distinct()->get();
                    $niveau = 'L1';
                }
                if(Auth()->user()->role === "Master"){
                    $annees = ArchiveCandidatM1::select('anneeUnivers')->distinct()->get();
                    $niveau = 'M1';
                }
                break;
        }
        return view('livewire.export.export-candidat', [
            'niveau' => $niveau,
            'annees' => $annees,
        ]);
    }
}
