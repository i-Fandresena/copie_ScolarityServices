<?php

namespace App\Http\Livewire;

use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveL3;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveM2;
use App\Models\Archives\ArchiveMR;
use App\Models\Attestation;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\Candidats\CandidatM2R;
use App\Models\Releve;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterRecherche;
use App\Models\Students\MasterTwo;
use Livewire\Component;

class Certificate extends Component
{
    public $numero = '';
    public $message;
    public $archive;
    public $niveau;
    public string $search = '';
    public $year;
    public int $count;
    public int $index = 0;
    public bool $verify = false;
    public bool $exist = false;

// using for relever
    public string $parcours = "Tronc Commun";

    protected $listeners = [
        'deleteAttestation' => 'deleteAttestation',
        'deleteReleve' => 'deleteReleve',
    ];

    public function increment(){
        if($this->count - 2 < $this->index){
            $this->index = 0;
        }else{
            $this->index++;
        }
    }

    public function deleteAttestation($id){
        if($id){
            Attestation::find($id)->delete();
            $this->emit('flash', 'Attestation supprimée avec succès', 'success');
        }else{
            $this->emit('flash', 'Une erreur est survenue', 'error');
        }

    }

    public function deleteReleve($id)
    {
        if($id){
            Releve::find($id)->delete();
            $this->emit('flash', 'Relevé de note supprimée avec succès', 'success');
        }else{
            $this->emit('flash', 'Une erreur est survenue', 'error');
        }
    }

    public function confirmAttestation($id, $numero)
    {
        if($id == 'checkIfExistAttestation'){
            $verification = Attestation::where('numInscrit', $numero)->get();
            if ($verification->count() >= 1){
                $lastDate = $verification->last()->dateDelivrance;
                // 31536000 == 365j
                if (date_timestamp_get(date_create($lastDate)) >= (date_timestamp_get(date_create())) - 31536000){
                    // Cet étudiant a déjà une attestation de réussite pour cette année
                    $this->verify = true;
                    $this->exist = true;
                    $this->message = "Cet étudiant a déjà une attestation de réussite pour cette année !";
                }
            } elseif ( $numero != '' ) {
                $this->verify = true;
                $this->exist = false;
                $this->message = "Veillez verifier les informations avant de valider !";
            }

        }else{
            // confirmation delete attestation
            $this->emit('modal', 'Delete attestation', 'deleteAttestation', $id, $numero);
        }
    }

    public function confirmReleve($id, $numero)
    {
        $this->emit('modal', 'Delete attestation', 'deleteReleve', $id, $numero);
    }

    public function resetIndex(){
        $this->index = 0;
    }


    public function render()
    {
        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
        $attestations = Attestation::where('numAttestation', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('prenom', 'LIKE', "%{$this->search}%")
                    ->get();

        $releveStd = Releve::where('numReleve', 'LIKE', "%{$this->search}%")
            ->where('niveau', 'LIKE', "%{$this->niveau}%")
            ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
            ->orWhere('nom', 'LIKE', "%{$this->search}%")
            ->orWhere('prenom', 'LIKE', "%{$this->search}%")
            ->get();


        switch ($this->niveau) {
            case "L1":
                $this->parcours = "Tronc Commun";
                $students = LicenceOne::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "L2":
                $this->parcours = "Tronc Commun";
                $students = LicenceTwo::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "L3":
                $students = LicenceThree::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "M1":
                $this->parcours = "Tronc Commun";
                $students = MasterOne::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "M2":
                $this->parcours = "Tronc Commun";
                $students = MasterTwo::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "MR":
                $students = MasterRecherche::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "PL":
                $students = CandidatL::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "PM1":
                $students = CandidatM::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "PM2":
                $students = CandidatM2::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            case "PMR":
                $students = CandidatM2R::where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                    ->get();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->niveau = "L1";
                    $students = LicenceOne::where('prenom', 'LIKE', "%{$this->search}%")
                        ->orWhere('nom', 'LIKE', "%{$this->search}%")
                        ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                        ->get();
                }
                if(Auth()->user()->role === "Master"){
                    $this->niveau = "M1";
                    $students = MasterOne::where('prenom', 'LIKE', "%{$this->search}%")
                        ->orWhere('nom', 'LIKE', "%{$this->search}%")
                        ->orWhere('numInscrit', 'LIKE', "%{$this->search}%")
                        ->get();
                }
        }


        if($this->archive)
        {
            switch ($this->niveau)
            {
                case "L1":
                    $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                    $this->parcours = "Tronc Commun";
                    $students = ArchiveL1::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orderBy('numInscrit')
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->get();
                    break;
                case "L2":
                    $annees = ArchiveL2::select('anneeUnivers')->distinct()->get();
                    $this->parcours = "Tronc Commun";
                    $students = ArchiveL2::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orderBy('numInscrit')
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->get();
                    break;
                case "L3":
                    $annees = ArchiveL3::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL3::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orderBy('numInscrit')
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->get();
                    break;
                case "M1":
                    $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                    $this->parcours = "Tronc Commun";
                    $students = ArchiveM1::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orderBy('numInscrit')
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->get();
                    break;
                case "M2":
                    $annees = ArchiveM2::select('anneeUnivers')->distinct()->get();
                    $this->parcours = "Tronc Commun";
                    $students = ArchiveM2::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orderBy('numInscrit')
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->get();
                    break;
                case "MR":
                    $annees = ArchiveMR::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveMR::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orderBy('numInscrit')
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->get();
                    break;

                default:
                    if(Auth()->user()->role === "Licence"){
                        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                        $this->niveau = "L1";
                        $students = ArchiveL1::where('anneeUnivers', '=', "{$this->year}")
                            ->where(function($query) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orderBy('numInscrit')
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            })
                            ->get();
                    }
                    if(Auth()->user()->role === "Master"){
                        $this->niveau = "M1";
                        $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                        $students = ArchiveM1::where('anneeUnivers', '=', "{$this->year}")
                            ->where(function($query) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orderBy('numInscrit')
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            })
                            ->get();
                    }
            }
        }

        $this->count = count($students);

        // get last num attestation
        $lastAttestation = Attestation::latest()->value('numAttestation');

        if (!$lastAttestation){
            $lastAttestation = 1;
        }else {
            $lastAttestation += 1;
        }

        // get last num per niveau
        $lastReleve = Releve::where('niveau', $this->niveau)
            ->latest()->value('numReleve');

        if (!$lastReleve){
            $lastReleve = 1;
        }else {
            $lastReleve += 1;
        }

        if ($this->count > 0) {
            $this->numero = $students[$this->index]->numInscrit;
        }

        return view('livewire.certificate')->with([
            'student' => $students,
            'lastAttestation' => $lastAttestation,
            'attestations' => $attestations,
            'lastRelever' => $lastReleve,
            'releves' => $releveStd,
            'annees' => $annees,
        ]);
    }
}
