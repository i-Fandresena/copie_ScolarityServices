<?php

namespace App\Http\Livewire;


use App\Models\Bordereau;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\DossierRecus\DRCandidatL1;
use App\Models\DossierRecus\DRCandidatM1;
use App\Models\DossierRecus\DRCandidatM2;
use App\Models\DossierRecus\DRL1;
use App\Models\DossierRecus\DRL2;
use App\Models\DossierRecus\DRL3;
use App\Models\DossierRecus\DRM1;
use App\Models\DossierRecus\DRM2;
use App\Models\Droit;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterTwo;
use Livewire\Component;
use Livewire\WithPagination;

class DossierRecus extends Component
{
    use WithPagination;

    public string $search = '';
    public string $niveau = '';

    public $idEtd;
    public $numInscrit;
    public $nom;
    public $prenom;
    public $dateNaissance;
    public $lieuNaissance;
    public $telCandidat;
    public $cin;
    public $nationalite;
    public $genre;
    public $anneeUnivers;
    public $email;
    public $situationMat;
    public $profession;
    public $statut;
    public $centreExamen;
    public $referenceBrd1;
    public $montant = null;
    public $dateBrd1;
    public $agence;


    /*
     * PRESELECTION L1
     * */

    public $anneeBacc;
    public $serieBacc;
    public $mentionBacc;

    /*
     * PRESELECTION MASTER
     * */

    public $etablissement;
    public $parcours;
    public $universite;

    public $observation;

    public $isFull = false;

    protected $listeners = [
        'deleteStudent' => 'deleteStudent',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'referenceBrd1' => ['unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'email' => 'email',
        ]);
    }

    private function bordereau()
    {
        try {
            $bordereau = Bordereau::create([
                'referenceBrd1' => $this->referenceBrd1,
                'montantBrd1' => preg_replace('/\s+/', '', $this->montant),
                'dateBrd1' => $this->dateBrd1,
                'agenceBrd1' => $this->agence,
                'createdBy' => Auth()->user()->name.' '.Auth()->user()->prenom,
            ]);

        }catch (Exception $e){
            $this->emit('flash', 'Erreur lors du importation!'.$e, 'error');
            return null;
        }
        return $bordereau->idBrd;
    }

    public function resetData(){
        $this->dispatchBrowserEvent('reset-data');
        $this->reset(['cin','referenceBrd1', 'email', 'idEtd']);
    }

    private function setCommonData($data, $brd)
    {
        $this->idEtd = $data['idEtd'];
        $this->numInscrit = $data['numInscrit'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->dateNaissance = $data['dateNaissance'];
        $this->lieuNaissance = $data['lieuNaissance'];
        $this->telCandidat = preg_replace('/\s+/', '', $data['telCandidat']);
        $this->anneeUnivers = $data['anneeUnivers'];
        $this->genre = $data['genre'];
        $this->observation = $data['observation'];
        $this->nationalite = $data['nationalite'];


        $this->dateBrd1 = $brd['dateBrd'];
        $this->agence = $brd['agenceBrd'];
    }

    public function setDataCandidatL1($data, $brd)
    {
        $this->setCommonData($data, $brd);

        $this->serieBacc = $data['serieBacc'];
        $this->anneeBacc = $data['anneeBacc'];
        $this->mentionBacc = $data['mentionBacc'];

        if($this->nationalite === "Malagasy"){
            $droit = Droit::where('typeDroit', 'PL')->first();
            if($droit){
                $this->submitL1($droit['idDroit']);
            }else{
                $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
            }
        } else{
            $droit = Droit::where('typeDroit', 'PLE')->first();
            if($droit){
                $this->submitL1($droit['idDroit']);
            }else{
                $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
            }
        }
    }

    private function submitL1($idDroit)
    {
        $this->validate([
            'nom' => 'required',
            'nationalite' => 'required',
            'dateNaissance' => 'date',
            'anneeUnivers' => 'required',
            'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'anneeBacc' => ['integer','min:4'],
            'montant' => 'required',
            'dateBrd1' => 'required:date',
        ]);

        $idBrdC = $this->bordereau();
        if(is_numeric($idBrdC)){
            try {
                CandidatL::create([
                    'numInscrit' => $this->numInscrit,
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'dateNaissance' => $this->dateNaissance,
                    'lieuNaissance' => $this->lieuNaissance,
                    'telCandidat' => $this->telCandidat,
                    'cin' => $this->cin,
                    'nationalite' => $this->nationalite,
                    'anneeUnivers' => $this->anneeUnivers,
                    'genre' => $this->genre,
                    'serieBacc' => $this->serieBacc,
                    'anneeBacc' => $this->anneeBacc,
                    'mentionBacc' => $this->mentionBacc,
                    'observation' => $this->observation,
                    'idBrdC' => $idBrdC,
                    'idDroitC' => $idDroit,
                ]);
            } catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                report($e);
                return $this->emit('flash', 'Une erreur a survenue lors de l\'enregistrement du candidat.', 'error');
            }

            DRCandidatL1::destroy($this->idEtd);
            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
    }
    public function setDataCandidatM($data, $brd)
    {
        $this->setCommonData($data, $brd);

        $this->etablissement = $data['etablissement'];
        $this->parcours = $data['parcours'];
        $this->universite = $data['universite'];

        if($data['centreExamen'] === " ") $this->centreExamen = "Pas de centre";
        else $this->centreExamen = $data['centreExamen'];
        $this->profession = $data['profession'];
        $this->situationMat = $data['situationMat'];
        $this->statut = $data['statut'];

        switch($this->niveau){
            case "PM2":
                if($this->nationalite === "Malagasy"){
                    $droit = Droit::where('typeDroit', 'PM2')->first();
                    if($droit){
                        $this->submitM2($droit['idDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                } else{
                    $droit = Droit::where('typeDroit', 'PM2E')->first();
                    if($droit){
                        $this->submitM2($droit['idDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                }
                break;
            default:
                if($this->nationalite === "Malagasy"){
                    $droit = Droit::where('typeDroit', 'PM1')->first();
                    if($droit){
                        $this->submitM1($droit['idDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                } else{
                    $droit = Droit::where('typeDroit', 'PM1E')->first();
                    if($droit){
                        $this->submitM1($droit['idDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                }
                break;
        }
    }

    private function submitM1($idDroit)
    {
        $this->validate([
            'nom' => 'required',
            'dateNaissance' => 'date',
            'nationalite' => 'required',
            'anneeUnivers' => 'required',
            'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'montant' => 'required:numeric',
            'dateBrd1' => 'required:date',
        ]);
        $idBrdC = $this->bordereau();
        if(is_numeric($idBrdC)){

            try {
                CandidatM::create([
                    'numInscrit' => $this->numInscrit,
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'dateNaissance' => $this->dateNaissance,
                    'lieuNaissance' => $this->lieuNaissance,
                    'telCandidat' => preg_replace('/\s+/', '', $this->telCandidat),
                    'cin' => preg_replace('/\s+/', '', $this->cin),
                    'nationalite' => $this->nationalite,
                    'anneeUnivers' => $this->anneeUnivers,
                    'genre' => $this->genre,
                    'centreExamen' => $this->centreExamen,
                    'profession' => $this->profession,
                    'statut' => $this->statut,
                    'parcours' => $this->parcours,
                    'universite' => $this->universite,
                    'etablissement' => $this->etablissement,
                    'email' => $this->email,
                    'situationMat' => $this->situationMat,
                    'observation' => $this->observation,
                    'idBrdC' => $idBrdC,
                    'idDroitC' => $idDroit,
                ]);
            } catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                return $this->emit('flash', 'Une erreur a survenue!'.$e, 'error');
            }

            DRCandidatM1::destroy($this->idEtd);
            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
    }
    private function submitM2($idDroit)
    {
        $this->validate([
            'nom' => 'required',
            'dateNaissance' => 'date',
            'nationalite' => 'required',
            'anneeUnivers' => 'required',
            'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'montant' => 'required',
            'dateBrd1' => 'required',
        ]);
        $idBrdC = $this->bordereau();
        if(is_numeric($idBrdC)){

            try {

                CandidatM2::create([
                    'numInscrit' => $this->numInscrit,
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'dateNaissance' => $this->dateNaissance,
                    'lieuNaissance' => $this->lieuNaissance,
                    'telCandidat' => preg_replace('/\s+/', '', $this->telCandidat),
                    'cin' => preg_replace('/\s+/', '', $this->cin),
                    'nationalite' => $this->nationalite,
                    'anneeUnivers' => $this->anneeUnivers,
                    'genre' => $this->genre,
                    'centreExamen' => $this->centreExamen,
                    'profession' => $this->profession,
                    'statut' => $this->statut,
                    'parcours' => $this->parcours,
                    'universite' => $this->universite,
                    'etablissement' => $this->etablissement,
                    'email' => $this->email,
                    'situationMat' => $this->situationMat,
                    'observation' => $this->observation,
                    'idBrdC' => $idBrdC,
                    'idDroitC' => $idDroit,
                ]);
            }  catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                return $this->emit('flash', 'Une erreur a survenue!', 'error');
            }

            DRCandidatM2::destroy($this->idEtd);
            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
    }

    public function setDataStudent($data, $brd)
    {
        switch ($this->niveau) {
            case "L2":
                $newStudent = new LicenceTwo();
                break;
            case "L3":
                $newStudent = new LicenceThree();
                break;
            case "M2":
                $newStudent = new MasterTwo();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $newStudent = new LicenceOne();
                }
                if(Auth()->user()->role === "Master"){
                    $newStudent = new MasterOne();
                }
                break;
        }
        $this->dateBrd1 = $brd['dateBrd'];
        $this->agence = $brd['agenceBrd'];

        $this->validate([
            'montant' => ['required', 'numeric'],
            'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'dateBrd1' => 'required:date',
        ]);

        $idBrdE = $this->bordereau();
        try{
            $newStudent->numInscrit = $data['numInscrit'];
            $newStudent->nom = $data['nom'];
            $newStudent->prenom = $data['prenom'];
            $newStudent->dateNaissance = $data['dateNaissance'];
            $newStudent->lieuNaissance = $data['lieuNaissance'];
            $newStudent->telCandidat = $data['telCandidat'];
            $newStudent->cin = $data['cin'];
            $newStudent->nationalite = $data['nationalite'];
            $newStudent->anneeUnivers = $data['anneeUnivers'];
            $newStudent->genre = $data['genre'];
            $newStudent->centreExamen = $data['centreExamen'];
            $newStudent->email = $data['email'];
            $newStudent-> situationMat = $data['situationMat'];
            $newStudent->profession = $data['profession'];
            $newStudent->statut = $data['statut'];
            $newStudent->RAD = intval($data['RAD']) - intval(preg_replace('/\s+/', '', $this->montant));
            $newStudent->observation = $data['observation'];
            $newStudent->idBrdE = $idBrdE;
            $newStudent->idDroitE = $data['idDroitE'];
            if($this->niveau === 'L3')
                $newStudent->idParcours = $data['idParcours'];


            $newStudent->save();

            switch ($this->niveau) {
                case "L2":
                    $id = DRL2::where('numInscrit', "{$data['numInscrit']}")->value('idEtd');
                    DRL2::destroy($id);
                    break;
                case "L3":
                    $id = DRL3::where('numInscrit', "{$data['numInscrit']}")->value('idEtd');
                    DRL3::destroy($id);
                    break;
                case "M2":
                    $id = DRM2::where('numInscrit', "{$data['numInscrit']}")->value('idEtd');
                    DRM2::destroy($id);
                    break;
                default:
                    if(Auth()->user()->role === "Licence"){
                        $id = DRL1::where('numInscrit', "{$data['numInscrit']}")->value('idEtd');
                        DRL1::destroy($id);
                    }
                    if(Auth()->user()->role === "Master"){
                        $id = DRM1::where('numInscrit', "{$data['numInscrit']}")->value('idEtd');
                        DRM1::destroy($id);
                    }
                    break;
            }

            $this->emit('flash', 'Etudiant(e) ['.$data['numInscrit'].'] ajouté(e) avec succées !', 'success');
            $this->resetData();

        } catch (Exception $e) {
            // delete bordereau if exist an error
            Bordereau::destroy($idBrdE);
            return $this->emit('flash', $e, 'error');
        }
    }

    public function confirmDelete($idEtd)
    {
        $this->emit('modal', 'teste', 'deleteStudent', $idEtd, null);
    }

    public function deleteStudent($id)
    {
        switch ($this->niveau) {
            case "L2":
                DRL2::destroy(DRL2::find($id)->idEtd);
                break;
            case "L3":
                DRL3::destroy(DRL3::find($id)->idEtd);
                break;
            case "M2":
                DRM2::destroy(DRM2::find($id)->idEtd);
                break;
            case "PL":
                DRCandidatL1::destroy(DRCandidatL1::find($id)->idEtd);
                break;
            case "PM1":
                DRCandidatM1::destroy(DRCandidatM1::find($id)->idEtd);
                break;
            case "PM2":
                DRCandidatM2::destroy(DRCandidatM2::find($id)->idEtd);
                break;
            default:
                if (Auth()->user()->role === "Licence") {
                    DRL1::destroy(DRL1::find($id)->idEtd);
                }
                if (Auth()->user()->role === "Master") {
                    DRM1::destroy(DRM1::find($id)->idEtd);
                }
        }
    }

    public function render()
    {
//        $drNiv = '';
        switch ($this->niveau) {
                case "L2":
                    $students = DRL2::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->paginate(10);
                    $drNiv = "L2";
                    $droit = Droit::where('typeDroit', 'L2')->first();
                    if (!$this->montant) {
                        if($droit){
                            $this->montant = intval($droit['montantDroit']) / 2;
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    if ($this->isFull){
                        if($droit){
                            $this->montant = intval($droit['montantDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    break;
                case "L3":
                    $students = DRL3::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->paginate(10);
                    $drNiv = "L3";
                    $droit = Droit::where('typeDroit', 'L3')->first();
                    if (!$this->montant) {
                        if($droit){
                            $this->montant = intval($droit['montantDroit']) / 2;
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    if ($this->isFull){
                        if($droit){
                            $this->montant = intval($droit['montantDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    break;
                case "M2":
                    $students = DRM2::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->paginate(10);
                    $drNiv = "M2";
                    $droit = Droit::where('typeDroit', 'M2')->first();
                    if (!$this->montant) {
                        if($droit){
                            $this->montant = intval($droit['montantDroit']) / 2;
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    if ($this->isFull){
                        if($droit){
                            $this->montant = intval($droit['montantDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    break;
                case "PL":
                    $students = DRCandidatL1::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->paginate(10);
                    $drNiv = "Préselection L1";
                    $droit = Droit::where('typeDroit', 'PL')->first();
                    if($droit){
                        $this->montant = intval($droit['montantDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                    break;
                case "PM1":
                    $students = DRCandidatM1::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->paginate(10);
                    $drNiv = "Préselection M1";
                    $droit = Droit::where('typeDroit', 'PM1')->first();
                    if($droit){
                        $this->montant = intval($droit['montantDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                    break;
                case "PM2":
                    $students = DRCandidatM2::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->paginate(10);
                    $drNiv = "Préselection M2";

                    $droit = Droit::where('typeDroit', 'PM2')->first();
                    if($droit){
                        $this->montant = intval($droit['montantDroit']);
                    }else{
                        $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                    }
                    break;
                default:
                    if(Auth()->user()->role === "Licence"){
                        $students = DRL1::where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                            ->paginate(10);
                        $drNiv = "L1";
                        $droit = Droit::where('typeDroit', 'L1')->first();

                        if (!$this->montant) {
                            if($droit){
                                $this->montant = intval($droit['montantDroit']) / 2;
                            }else{
                                $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                            }
                        }
                        if ($this->isFull){
                            if($droit){
                                $this->montant = intval($droit['montantDroit']);
                            }else{
                                $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                            }
                        }
                    }
                    if(Auth()->user()->role === "Master"){
                        $students = DRM1::where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                            ->paginate(10);


                        $drNiv = "M1";
                        $droit = Droit::where('typeDroit', 'M1')->first();
                        if (!$this->montant) {
                            if($droit){
                                $this->montant = intval($droit['montantDroit']) / 2;
                            }else{
                                $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                            }
                        }
                        if ($this->isFull){
                            if($droit){
                                $this->montant = intval($droit['montantDroit']);
                            }else{
                                $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                            }
                        }
                    }
        }

        return view('livewire.dossier-recus', [
            'students' => $students,
            'drNiv' => $drNiv
        ]);
    }
}
