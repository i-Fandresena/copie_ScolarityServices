<?php

namespace App\Http\Livewire\Export;

use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveL3;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveM2;
use App\Models\Archives\ArchiveMR;
use App\Models\ElementConstitutif;
use App\Models\UniteEnseignement;
use Livewire\Component;

class ExportNote extends Component
{
    public string $selectedLevel = '';
    public string $name = '';
    public $id_ue;
    public $id_ec;
    public string $extension = 'xlsx';

    public function render()
    {
        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
        switch ($this->selectedLevel) {
            case "L1":
                $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                $niveau = 'L1';
                $ue = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                $UE = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                break;
            case "L2":
                $annees = ArchiveL2::select('anneeUnivers')->distinct()->get();
                $niveau = 'L2';
                $ue = UniteEnseignement::where('niveau', 'L2')->where('statut', 1)->get();
                $UE = UniteEnseignement::where('niveau', 'L2')->where('statut', 1)->get();
                break;
            case "L3":
                $annees = ArchiveL3::select('anneeUnivers')->distinct()->get();
                $niveau = 'L3';
                $ue = UniteEnseignement::where('niveau', 'L3')->where('statut', 1)->get();
                $UE = UniteEnseignement::where('niveau', 'L3')->where('statut', 1)->get();
                break;
            case "M1":
                $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                $niveau = 'M1';
                $ue = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                $UE = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                break;
            case "M2":
                $annees = ArchiveM2::select('anneeUnivers')->distinct()->get();
                $niveau = 'M2';
                $ue = UniteEnseignement::where('niveau', 'M2')->where('statut', 1)->get();
                $UE = UniteEnseignement::where('niveau', 'M2')->where('statut', 1)->get();
                break;
            case "M2-R":
                $annees = ArchiveMR::select('anneeUnivers')->distinct()->get();
                $niveau = 'M2-R';
                $ue = UniteEnseignement::where('niveau', 'M2-R')->where('statut', 1)->get();
                $UE = UniteEnseignement::where('niveau', 'M2-R')->where('statut', 1)->get();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                    $ue = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                    $niveau = 'L1';
                }
                if(Auth()->user()->role === "Master"){
                    $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                    $ue = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    $niveau = 'M1';
                }
                break;
        }
        $ec = ElementConstitutif::where('idUE', $this->id_ue)->where('statut', 1)->get();
        $this->selectedUE = UniteEnseignement::find($this->id_ue);
        $this->selectedEC = ElementConstitutif::find($this->id_ec);

        return view('livewire.export.export-note', [
            'niveau' => $niveau,
            'ec' => $ec,
            'ue' => $ue,
            'UE' => $UE,
            'annees' => $annees,
        ]);
    }
}
