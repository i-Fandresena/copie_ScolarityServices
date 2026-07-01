<?php

namespace App\Http\Livewire;

use App\Models\Bordereau;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\Candidats\CandidatM2R;
use App\Models\DossierRecus\DRCandidatL1;
use App\Models\DossierRecus\DRCandidatM1;
use App\Models\DossierRecus\DRCandidatM2;
use App\Models\Droit;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\SimpleExcel\SimpleExcelReader;

class Preselection extends Component
{
    use WithFileUploads;
    public $numInscrit;
    public $nom;
    public $prenom;
    public $dateNaissance;
    public $lieuNaissance;
    public $telCandidat;
    public $cin;
    public $nationalite = 'Malagasy';
    public $anneeUnivers;
    public $genre;
    public $serieBacc;
    public $anneeBacc;
    public $mentionBacc;
    public $observation;

    public $referenceBrd1;
    public $montant;
    public $dateBrd1;
    public $agence;

    public $parcours;
    public $universite;
    public $etablissement;
    public $centreExamen;
    public $profession;
    public $statut;
    public $situationMat;
    public $email;
    public $cursus;

    public $selectedLevel;
    public $excelFile;

    //  real-time validation for input referenceBrd1
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'referenceBrd1' => ['unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'email' => 'email',
        ]);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $droit = 0;

        if($this->nationalite === 'Malagasy')
        {
            switch($this->selectedLevel){
                case "M2-R":
                    $droit = Droit::where('typeDroit', 'PM2R')->first()->montantDroit;
                    break;
                case "M2":
                    $droit = Droit::where('typeDroit', 'PM2')->value('montantDroit');
                    break;
                case "M1":
                    $droit = Droit::where('typeDroit', 'PM1')->value('montantDroit');
                    break;
                case "L1":
                    $droit = Droit::where('typeDroit', 'PL')->value('montantDroit');
                    break;
                default:
                    if(Auth()->user()->role === "Licence") $droit = Droit::where('typeDroit', 'PL')->value('montantDroit');
                    if(Auth()->user()->role === "Master") $droit = Droit::where('typeDroit', 'PM1')->value('montantDroit');
                    break;
            }
        } else {
            switch($this->selectedLevel){
                case "M2-R":
                    $droit = Droit::where('typeDroit', 'PM2RE')->first()->montantDroit;
                    break;
                case "M2":
                    $droit = Droit::where('typeDroit', 'PM2E')->value('montantDroit');
                    break;
                case "M1":
                    $droit = Droit::where('typeDroit', 'PM1E')->value('montantDroit');
                    break;
                case "L1":
                    $droit = Droit::where('typeDroit', 'PLE')->value('montantDroit');
                    break;
                default:
                    if(Auth()->user()->role === "Licence") $droit = Droit::where('typeDroit', 'PLE')->value('montantDroit');
                    if(Auth()->user()->role === "Master") $droit = Droit::where('typeDroit', 'PM1E')->value('montantDroit');
                    break;
            }
        }

        $this->montant = number_format($droit, 0, '', ' ');
        return view('livewire.preselection');
    }

    public function submitL($idD): \Livewire\Event
    {
        $this->validate([
            'nom' => 'required',
            'nationalite' => 'required',
            'dateNaissance' => 'date',
            'anneeUnivers' => 'required',
            'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'anneeBacc' => ['required','integer','min:4'],
            'montant' => 'required',
            'dateBrd1' => 'required:date',
        ]);

        $idBrdC = $this->bordereau();
        if(is_numeric($idBrdC)){
            $this->numInscrit = $this->getLastNum("L1");

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
                    'idDroitC' => $idD,
                ]);
            } catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                report($e);
                return $this->emit('flash', 'Une erreur a survenue lors de l\'enregistrement du candidat.', 'error');
            }

            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
    }

    public function submitM($idD): \Livewire\Event
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
            /*
            0001/PRES/M1/SE/D/23
        */

            $this->numInscrit = $this->getLastNum("M1");
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
                    'idDroitC' => $idD,
                ]);
            } catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                return $this->emit('flash', 'Une erreur a survenue!'.$e, 'error');
            }

            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
    }

    public function submitM2($idD): \Livewire\Event
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
            /*
            0001/PRES/M1/SE/D/23
        */

            $this->numInscrit = $this->getLastNum("M2");

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
                    'idDroitC' => $idD,
                ]);
            }  catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                return $this->emit('flash', 'Une erreur a survenue!', 'error');
            }

            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
    }

    public function submitM2R($idD): \Livewire\Event
    {
        $this->validate([
            'nom' => 'required',
            'dateNaissance' => 'date',
            'nationalite' => 'required',
            'anneeUnivers' => 'required',
            'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
            'montant' => 'required',
            'dateBrd1' => 'required:date',
        ]);
        $idBrdC = $this->bordereau();

        if(is_numeric($idBrdC)){
            /*
            0001/PRES/M1/SE/D/23
        */

            $this->numInscrit = $this->getLastNum("M2-R");
            try {
                CandidatM2R::create([
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
                    'profession' => $this->profession,
                    'statut' => $this->statut,
                    'parcours' => $this->parcours,
                    'universite' => $this->universite,
                    'etablissement' => $this->etablissement,
                    'email' => $this->email,
                    'situationMat' => $this->situationMat,
                    'observation' => $this->observation,
                    'cursus' => $this->cursus,
                    'idBrdC' => $idBrdC,
                    'idDroitC' => $idD,
                ]);
            } catch (Exception $e) {
                // delete bordereau if exist an error
                Bordereau::destroy($idBrdC);
                return $this->emit('flash', 'Une erreur a survenue!', 'error');
            }

            $this->resetData();
            return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
        } else {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }
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
        $this->reset(['cin','referenceBrd1', 'email']);
    }

    private function submitNotNowL1($idDroit)
    {
        $this->validate([
            'nom' => 'required',
        ]);

        $this->numInscrit = $this->getLastNum("L1");

        try {
            DRCandidatL1::create([
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
                'anneeBacc' => intval($this->anneeBacc),
                'mentionBacc' => $this->mentionBacc,
                'observation' => $this->observation,
                'idDroitE' => $idDroit,
            ]);
        } catch (Exception $e) {
            return $this->emit('flash', 'Une erreur a survenue!'.$e, 'error');
        }

        $this->resetData();
        return $this->emit('flash', 'Dossier ['.$this->numInscrit.'] reçu avec succées !', 'success');
    }

    private function submitNotNowM1($idDroit)
    {
        $this->validate([
            'nom' => 'required',
        ]);

        $this->numInscrit = $this->getLastNum("M1");
        try {
            DRCandidatM1::create([
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
                'idDroitE' => $idDroit,
            ]);
        } catch (Exception $e) {
            return $this->emit('flash', 'Une erreur a survenue!'.$e, 'error');
        }

        $this->resetData();
        return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
    }

    private function submitNotNowM2($idDroit)
    {
        $this->validate([
            'nom' => 'required',
        ]);
        $this->numInscrit = $this->getLastNum("M2");

        try {

            DRCandidatM2::create([
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
                'idDroitE' => $idDroit,
            ]);
        }  catch (Exception $e) {
            return $this->emit('flash', 'Une erreur a survenue!', 'error');
        }

        $this->resetData();
        return $this->emit('flash', 'Candidat(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
    }

    public function dataSet($data, $type)
    {

        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->dateNaissance = $data['dateNaissance'];
        $this->lieuNaissance = $data['lieuNaissance'];
        $this->telCandidat = preg_replace('/\s+/', '', $data['telCandidat']);
        $this->anneeUnivers = $data['anneeUnivers'];
        $this->genre = $data['genre'];
        $this->observation = $data['observation'];
        $this->montant = $data['montant'];

        /*$this->montant = preg_replace('/\s+/', '', $data['montant']);*/
        $this->dateBrd1 = $data['dateBrd1'];
        $this->agence = $data['agenceBrd1'];

        if (Auth()->user()->role === "Licence"){
            $this->serieBacc = $data['serieBacc'];
            $this->anneeBacc = $data['anneeBacc'];
            $this->mentionBacc = $data['mentionBacc'];

            if($this->nationalite === "Malagasy"){
                $droit = Droit::where('typeDroit', 'PL')->first();
                if($droit){
                    if ($type == 'NN')
                        $this->submitNotNowL1($droit['idDroit']);
                    else
                        $this->submitL($droit['idDroit']);
                }else{
                    $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                }
            } else{
                $droit = Droit::where('typeDroit', 'PLE')->first();
                if($droit){
                    if ($type == 'NN')
                        $this->submitNotNowL1($droit['idDroit']);
                    else
                        $this->submitL($droit['idDroit']);
                }else{
                    $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                }
            }
        }

        if (Auth()->user()->role === "Master"){
            $this->etablissement = $data['etablissement'];
            $this->parcours = $data['parcours'];
            $this->universite = $data['universite'];

            if($data['centreExamen'] === " ") $this->centreExamen = "Pas de centre";
            else $this->centreExamen = $data['centreExamen'];
            $this->profession = $data['profession'];
            $this->situationMat = $data['situationMat'];
            if($data['statut']) $this->statut = "Fonctionnaire";
            else $this->statut = "Non Fonctionnaire";

            $this->cursus = $data['cursus'];

            switch($this->selectedLevel){
                case "M2":
                    if($this->nationalite === "Malagasy"){
                        $droit = Droit::where('typeDroit', 'PM2')->first();
                        if($droit){
                            if ($type == 'NN')
                                $this->submitNotNowM2($droit['idDroit']);
                            else
                                $this->submitM2($droit['idDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    } else{
                        $droit = Droit::where('typeDroit', 'PM2E')->first();
                        if($droit){
                            if ($type == 'NN')
                                $this->submitNotNowM2($droit['idDroit']);
                            else
                                $this->submitM2($droit['idDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    break;
                case "M2-R":
                    if($this->nationalite === "Malagasy"){
                        $droit = Droit::where('typeDroit', 'PM2R')->first();
                        if($droit){
                            $this->submitM2R($droit['idDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    } else{
                        $droit = Droit::where('typeDroit', 'PM2RE')->first();
                        if($droit){
                            $this->submitM2R($droit['idDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    break;
                default:
                    if($this->nationalite === "Malagasy"){
                        $droit = Droit::where('typeDroit', 'PM1')->first();
                        if($droit){
                            if ($type == 'NN')
                                $this->submitNotNowM1($droit['idDroit']);
                            else
                                $this->submitM($droit['idDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    } else{
                        $droit = Droit::where('typeDroit', 'PM1E')->first();
                        if($droit){
                            if ($type == 'NN')
                                $this->submitNotNowM1($droit['idDroit']);
                            else
                                $this->submitM($droit['idDroit']);
                        }else{
                            $this->emit('flash', 'Vous devez verfiez le montant du droit !', 'warning');
                        }
                    }
                    break;
            }
        }


    }

    /***********************************************************************************************
    ******************************************DATA IMPORT*******************************************
    ************************************************************************************************/

    public function verifyImport()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        switch($this->selectedLevel){
            case "M2-R":
                $this->importM2R();
                break;
            case "M2":
                $this->importM2();
                break;
            case "M1":
                $this->importM1();
                break;
            case "L1":
                $this->importL1();
                break;
            default:
                if (Auth()->user()->role === "Licence")
                    $this->importL1();
                if (Auth()->user()->role === "Master")
                    $this->importM1();
                break;
        }
    }

    public function importL1()
    {
        $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
        $rows = $reader->getRows();
        $data = $rows->toArray();
        foreach ($data as $row){
            if($row['Nom'] === "") $this->nom = null;
            else $this->nom = $row['Nom'];
            if($row['Prenoms'] === "") $this->prenom = null;
            else $this->prenom = $row['Prenoms'];
            if($row['Date de Naissance'] === ""){
                $this->dateNaissance = date_create("01/01/2000");
            } elseif (gettype($row['Date de Naissance']) === "string"){
                if (preg_match('/[A-Za-z]/', $row['Date de Naissance'])){
                    // if exist a date type (vers XXXX)
                    try {
                        $date = explode(' ', strval($row['Date de Naissance']));
                        foreach ($date as $d){
                            if(intval($d)){
                                $year = intval($d);
                                break;
                            }
                        }
                    }catch (Exception $e){
                        $year = 2000;
                    }
                    $tmp = "01-01-".$year;
                    $timestamp = strtotime(str_replace('/', '-', $tmp));
                    $date = date('Y-m-d', $timestamp);
                    $this->dateNaissance = $date;
                } else {
                    $timestamp = strtotime(str_replace('/', '-', $row['Date de Naissance']));
                    $date = date('Y-m-d', $timestamp);
                    $this->dateNaissance = $date;
                }
            } else
                $this->dateNaissance = $row['Date de Naissance'];
            if($row['Lieu de Naissance'] === "") $this->lieuNaissance = null;
            else $this->lieuNaissance = $row['Lieu de Naissance'];
            if($row['Telephone'] === "") $this->telCandidat = null;
            else $this->telCandidat = preg_replace('/\s+/', '', $row['Telephone']);
            if($row['Annee Universitaire'] === "") $this->anneeUnivers = null;
            else $this->anneeUnivers = $row['Annee Universitaire'];
            if($row['Genre'] === "" or is_null($row['Genre'])) $this->genre = null;
            else $this->genre = $row['Genre'];
            if($row['CIN'] === "") $this->cin = null;
            else $this->cin = $row['CIN'];
            if ($row['Nationalite'] === "") $this->nationalite = null;
            else $this->nationalite = $row['Nationalite'];

            if ($row['Serie Bac'] === "") $this->serieBacc = null;
            else $this->serieBacc = $row['Serie Bac'];
            if ($row['Annee du Bac'] === "") $this->anneeBacc = null;
            else $this->anneeBacc = $row['Annee du Bac'];
            if ($row['Mention du Bac'] === "") $this->mentionBacc = null;
            else $this->mentionBacc = $row['Mention du Bac'];

            if($row['Observation'] === "") $this->observation = null;
            else $this->observation = $row['Observation'];

            if($row['Montant'] === "") $this->montant = 0;
            else $this->montant = preg_replace('/\s+/', '', $row['Montant']);
            if($row['Date'] === "") {
                $this->dateBrd1 = date_create('now');
            } elseif (gettype($row['Date']) === "string") {
                $timestamp = strtotime(str_replace('/', '-', $row['Date']));
                $date = date('Y-m-d', $timestamp);
                $this->dateBrd1 = $date;
            } else {
                $this->dateBrd1 = $row['Date'];
            }
            if($row['Reference'] === "") $this->referenceBrd1 = rand().$this->prenom;
            else $this->referenceBrd1 = $row['Reference'];


            if($this->nationalite === "Malagasy"){
                $droit = Droit::where('typeDroit', 'PL')->first();
                if($droit){
                    $this->submitL($droit['idDroit']);
                }else{
                    $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                }
            } else{
                $droit = Droit::where('typeDroit', 'PLE')->first();
                if($droit){
                    $this->submitL($droit['idDroit']);
                }else{
                    $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                }
            }

        }
    }

    public function importM1()
    {
        $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
        $rows = $reader->getRows();
        $data = $rows->toArray();
        foreach ($data as $row) {
            try {
                if ($row['Nom'] === "") $this->nom = null;
                else $this->nom = $row['Nom'];
                if ($row['Prenoms'] === "") $this->prenom = null;
                else $this->prenom = $row['Prenoms'];
                if ($row['Date de Naissance'] === "") {
                    $this->dateNaissance = date_create("01/01/2000");
                } elseif (gettype($row['Date de Naissance']) === "string") {
                    if (preg_match('/[A-Za-z]/', $row['Date de Naissance'])) {
                        // if exist a date type (vers XXXX)
                        try {
                            $date = explode(' ', strval($row['Date de Naissance']));
                            foreach ($date as $d) {
                                if (intval($d)) {
                                    $year = intval($d);
                                    break;
                                }
                            }
                        } catch (Exception $e) {
                            $year = 2000;
                        }
                        $tmp = "01-01-" . $year;
                        $timestamp = strtotime(str_replace('/', '-', $tmp));
                        $date = date('Y-m-d', $timestamp);
                        $this->dateNaissance = $date;
                    } else {
                        $timestamp = strtotime(str_replace('/', '-', $row['Date de Naissance']));
                        $date = date('Y-m-d', $timestamp);
                        $this->dateNaissance = $date;
                    }
                } else
                    $this->dateNaissance = $row['Date de Naissance'];
                if ($row['Lieu de Naissance'] === "") $this->lieuNaissance = null;
                else $this->lieuNaissance = $row['Lieu de Naissance'];
                if ($row['Telephone'] === "") $this->telCandidat = null;
                else $this->telCandidat = preg_replace('/\s+/', '', $row['Telephone']);
                if ($row['Annee Universitaire'] === "") $this->anneeUnivers = null;
                else $this->anneeUnivers = $row['Annee Universitaire'];
                if ($row['Genre'] === "") $this->genre = null;
                else $this->genre = $row['Genre'];
                if ($row['CIN'] === "") $this->cin = null;
                else $this->cin = $row['CIN'];
                if ($row['Nationalite'] === "") $this->nationalite = null;
                else $this->nationalite = $row['Nationalite'];

                if ($row['Email'] === "") $this->email = null;
                else $this->email = $row['Email'];
                if ($row['Status'] === "") $this->statut = null;
                else $this->statut = $row['Status'];
                if ($row['Diplome de Licence'] === "") $this->parcours = null;
                else $this->parcours = $row['Diplome de Licence'];
                if ($row['Universite'] === "") $this->universite = null;
                else $this->universite = $row['Universite'];
                if ($row['Etablissement'] === "") $this->etablissement = null;
                else $this->etablissement = $row['Etablissement'];

                if ($row['Centre d\'examen'] === "") $this->centreExamen = "Pas de centre";
                else $this->centreExamen = $row['Centre d\'examen'];
                if ($row['Profession'] === "") $this->profession = null;
                else $this->profession = $row['Profession'];
                if ($row['Situation Matrimoniale'] === "") $this->situationMat = "Célibataire";
                else $this->situationMat = $row['Situation Matrimoniale'];

                if ($row['Montant'] === "") $this->montant = 0;
                else $this->montant = preg_replace('/\s+/', '', $row['Montant']);
                if ($row['Date'] === "") {
                    $this->dateBrd1 = date_create('now');
                } elseif (gettype($row['Date']) === "string") {
                    $timestamp = strtotime(str_replace('/', '-', $row['Date']));
                    $date = date('Y-m-d', $timestamp);
                    $this->dateBrd1 = $date;
                } else {
                    $this->dateBrd1 = $row['Date'];
                }
                if ($row['Reference'] === "") $this->referenceBrd1 = rand() . $this->prenom;
                else $this->referenceBrd1 = $row['Reference'];

                if ($row['Observation'] === "") $this->observation = null;
                else $this->observation = $row['Observation'];


                if ($this->nationalite === "Malagasy") {
                    $droit = Droit::where('typeDroit', 'PM1')->first();
                    if ($droit) {
                        $this->submitM($droit['idDroit']);
                    } else {
                        $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                    }
                } else {
                    $droit = Droit::where('typeDroit', 'PM1E')->first();
                    if ($droit) {
                        $this->submitM($droit['idDroit']);
                    } else {
                        $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                    }
                }
            }
            catch (\Exception $error){
                $this->emit('flash', 'Une erreur a servenue lors de l\'enregistremnt !', 'error');
            }
        }
    }

    public function importM2()
    {
        $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
        $rows = $reader->getRows();
        $data = $rows->toArray();
        foreach ($data as $row) {
            try {
                if ($row['Nom'] === "") $this->nom = null;
                else $this->nom = $row['Nom'];
                if ($row['Prenoms'] === "") $this->prenom = null;
                else $this->prenom = $row['Prenoms'];
                if ($row['Date de Naissance'] === "") {
                    $this->dateNaissance = date_create("01/01/2000");
                } elseif (gettype($row['Date de Naissance']) === "string") {
                    if (preg_match('/[A-Za-z]/', $row['Date de Naissance'])) {
                        // if exist a date type (vers XXXX)
                        try {
                            $date = explode(' ', strval($row['Date de Naissance']));
                            foreach ($date as $d) {
                                if (intval($d)) {
                                    $year = intval($d);
                                    break;
                                }
                            }
                        } catch (Exception $e) {
                            $year = 2000;
                        }
                        $tmp = "01-01-" . $year;
                        $timestamp = strtotime(str_replace('/', '-', $tmp));
                        $date = date('Y-m-d', $timestamp);
                        $this->dateNaissance = $date;
                    } else {
                        $timestamp = strtotime(str_replace('/', '-', $row['Date de Naissance']));
                        $date = date('Y-m-d', $timestamp);
                        $this->dateNaissance = $date;
                    }
                } else
                    $this->dateNaissance = $row['Date de Naissance'];
                if ($row['Lieu de Naissance'] === "") $this->lieuNaissance = null;
                else $this->lieuNaissance = $row['Lieu de Naissance'];
                if ($row['Telephone'] === "") $this->telCandidat = null;
                else $this->telCandidat = preg_replace('/\s+/', '', $row['Telephone']);
                if ($row['Annee Universitaire'] === "") $this->anneeUnivers = null;
                else $this->anneeUnivers = $row['Annee Universitaire'];
                if ($row['Genre'] === "") $this->genre = null;
                else $this->genre = $row['Genre'];
                if ($row['CIN'] === "") $this->cin = null;
                else $this->cin = $row['CIN'];
                if ($row['Nationalite'] === "") $this->nationalite = null;
                else $this->nationalite = $row['Nationalite'];

                if ($row['Email'] === "") $this->email = null;
                else $this->email = $row['Email'];
                if ($row['Status'] === "") $this->statut = null;
                else $this->statut = $row['Status'];
                if ($row['Diplome de Licence'] === "") $this->parcours = null;
                else $this->parcours = $row['Diplome de Licence'];
                if ($row['Universite'] === "") $this->universite = null;
                else $this->universite = $row['Universite'];
                if ($row['Etablissement'] === "") $this->etablissement = null;
                else $this->etablissement = $row['Etablissement'];

                if ($row['Centre d\'examen'] === "") $this->centreExamen = "Pas de centre";
                else $this->centreExamen = $row['Centre d\'examen'];
                if ($row['Profession'] === "") $this->profession = null;
                else $this->profession = $row['Profession'];
                if ($row['Situation Matrimoniale'] === "") $this->situationMat = "Célibataire";
                else $this->situationMat = $row['Situation Matrimoniale'];

                if ($row['Montant'] === "") $this->montant = 0;
                else $this->montant = preg_replace('/\s+/', '', $row['Montant']);
                if ($row['Date'] === "") {
                    $this->dateBrd1 = date_create('now');
                } elseif (gettype($row['Date']) === "string") {
                    $timestamp = strtotime(str_replace('/', '-', $row['Date']));
                    $date = date('Y-m-d', $timestamp);
                    $this->dateBrd1 = $date;
                } else {
                    $this->dateBrd1 = $row['Date'];
                }
                if ($row['Reference'] === "") $this->referenceBrd1 = rand() . $this->prenom;
                else $this->referenceBrd1 = $row['Reference'];

                if ($row['Observation'] === "") $this->observation = null;
                else $this->observation = $row['Observation'];


                if ($this->nationalite === "Malagasy") {
                    $droit = Droit::where('typeDroit', 'PM2')->first();
                    if ($droit) {
                        $this->submitM2($droit['idDroit']);
                    } else {
                        $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                    }
                } else {
                    $droit = Droit::where('typeDroit', 'PM2E')->first();
                    if ($droit) {
                        $this->submitM2($droit['idDroit']);
                    } else {
                        $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                    }
                }
            } catch (\Exception $error){
                $this->emit('flash', 'Une erreur a servenue lors de l\'enregistremnt !', 'error');
            }
        }
    }

    public function importM2R()
    {
        $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
        $rows = $reader->getRows();
        $data = $rows->toArray();
        foreach ($data as $row){
            if($row['Nom'] === "") $this->nom = null;
            else $this->nom = $row['Nom'];
            if($row['Prenoms'] === "") $this->prenom = null;
            else $this->prenom = $row['Prenoms'];
            if($row['Date de Naissance'] === ""){
                $this->dateNaissance = date_create("01/01/2000");
            } elseif (gettype($row['Date de Naissance']) === "string"){
                if (preg_match('/[A-Za-z]/', $row['Date de Naissance'])){
                    // if exist a date type (vers XXXX)
                    try {
                        $date = explode(' ', strval($row['Date de Naissance']));
                        foreach ($date as $d){
                            if(intval($d)){
                                $year = intval($d);
                                break;
                            }
                        }
                    }catch (Exception $e){
                        $year = 2000;
                    }
                    $tmp = "01-01-".$year;
                    $timestamp = strtotime(str_replace('/', '-', $tmp));
                    $date = date('Y-m-d', $timestamp);
                    $this->dateNaissance = $date;
                } else {
                    $timestamp = strtotime(str_replace('/', '-', $row['Date de Naissance']));
                    $date = date('Y-m-d', $timestamp);
                    $this->dateNaissance = $date;
                }
            } else
                $this->dateNaissance = $row['Date de Naissance'];
            if($row['Lieu de Naissance'] === "") $this->lieuNaissance = null;
            else $this->lieuNaissance = $row['Lieu de Naissance'];
            if($row['Telephone'] === "") $this->telCandidat = null;
            else $this->telCandidat = preg_replace('/\s+/', '', $row['Telephone']);
            if($row['Annee Universitaire'] === "") $this->anneeUnivers = null;
            else $this->anneeUnivers = $row['Annee Universitaire'];
            if($row['Genre'] === "") $this->genre = null;
            else $this->genre = $row['Genre'];
            if($row['CIN'] === "") $this->cin = null;
            else $this->cin = $row['CIN'];
            if ($row['Nationalite'] === "") $this->nationalite = null;
            else $this->nationalite = $row['Nationalite'];

            if ($row['Email'] === "") $this->email = null;
            else $this->email = $row['Email'];
            if ($row['Status'] === "") $this->statut = null;
            else $this->statut = $row['Status'];
            if ($row['Universite'] === "") $this->universite = null;
            else $this->universite = $row['Universite'];
            if ($row['Etablissement'] === "") $this->etablissement = null;
            else $this->etablissement = $row['Etablissement'];
            if ($row['Cursus'] === "") $this->cursus = null;
            else $this->cursus = $row['Cursus'];

            if ($row['Profession'] === "") $this->profession = null;
            else $this->profession = $row['Profession'];
            if ($row['Situation Matrimoniale'] === "") $this->situationMat = "Célibataire";
            else $this->situationMat = $row['Situation Matrimoniale'];

            if($row['Montant'] === "") $this->montant = 0;
            else $this->montant = preg_replace('/\s+/', '', $row['Montant']);
            if($row['Date'] === "") {
                $this->dateBrd1 = date_create('now');
            } elseif (gettype($row['Date']) === "string") {
                $timestamp = strtotime(str_replace('/', '-', $row['Date']));
                $date = date('Y-m-d', $timestamp);
                $this->dateBrd1 = $date;
            } else {
                $this->dateBrd1 = $row['Date'];
            }
            if($row['Reference'] === "") $this->referenceBrd1 = rand().$this->prenom;
            else $this->referenceBrd1 = $row['Reference'];

            if ($row['Observation'] === "") $this->observation = null;
            else $this->observation = $row['Observation'];


            if($this->nationalite === "Malagasy"){
                $droit = Droit::where('typeDroit', 'PM2R')->first();
                if($droit){
                    $this->submitM2R($droit['idDroit']);
                }else{
                    $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                }
            } else{
                $droit = Droit::where('typeDroit', 'PM2R')->first();
                if($droit){
                    $this->submitM2R($droit['idDroit']);
                }else{
                    $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                }
            }
        }
    }
    /***********************************************************************************************
    **************************************END DATA IMPORT*******************************************
    ************************************************************************************************/


    private function generateNumL1()
    {
        $verifNiv = CandidatL::count();
        $verifDR = DRCandidatL1::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = CandidatL::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRCandidatL1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            return $this->explodeNumP($preNumNiv, $postNum);
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRCandidatL1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            return $this->explodeNum($preNumDR);
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNum = CandidatL::orderBy('numInscrit', 'desc')->first()->numInscrit;
            return $this->explodeNum($preNum);
        }
        else
        {
            $arrayYear = str_split($this->anneeUnivers);
            return '0001' . '/' . 'PRES' . '/' . 'L1' . '/' . 'SE' . '/' . 'D' . '/' . $arrayYear[2] . $arrayYear[3];
        }
    }
    private function generateNumM1()
    {
        $verifNiv = CandidatM::count();
        $verifDR = DRCandidatM1::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = CandidatM::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRCandidatM1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            return $this->explodeNumP($preNumNiv, $postNum);
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRCandidatM1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            return $this->explodeNum($preNumDR);
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNum = CandidatM::orderBy('numInscrit', 'desc')->first()->numInscrit;
            return $this->explodeNum($preNum);
        }
        else
        {
            $arrayYear = str_split($this->anneeUnivers);
            return '0001' . '/' . 'PRES' . '/' . 'M1' . '/' . 'SE' . '/' . 'D' . '/' . $arrayYear[2] . $arrayYear[3];
        }
    }
    private function generateNumM2()
    {
        $verifNiv = CandidatM2::count();
        $verifDR = DRCandidatM2::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = CandidatM2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRCandidatM2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            return $this->explodeNumP($preNumNiv, $postNum);
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRCandidatM2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            return $this->explodeNum($preNumDR);
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNum = CandidatM2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            return $this->explodeNum($preNum);
        }
        else
        {
            $arrayYear = str_split($this->anneeUnivers);
            return '0001' . '/' . 'PRES' . '/' . 'M2' . '/' . 'SE' . '/' . 'D' . '/' . $arrayYear[2] . $arrayYear[3];
        }
    }
    public function getLastNum($niveau) {
        switch($niveau){
            case "M2-R":
                $verify = CandidatM2R::count();
                if($verify > 0) {
                    $preNum = CandidatM2R::orderBy('numInscrit', 'desc')->first()->numInscrit;
                    $arrayNum = explode("/", $preNum);
                    $postNum = intval($arrayNum[0]);
                    $postNum = $postNum + 1;
                    return sprintf('%03d', strval($postNum)) . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                } else {
                    $arrayYear = str_split($this->anneeUnivers);
                    return '001' . '/' . 'PRES' . '/' . 'MR' . '/' . $arrayYear[2] . $arrayYear[3];
                }
            case "M2":
                return $this->generateNumM2();
            case "M1":
                return $this->generateNumM1();
            case "L1":
                return $this->generateNumL1();
        }
    }

    /**
     * @param $preNum
     * @return string
     */
    protected function explodeNum($preNum): string
    {
        $arrayNum = explode("/", $preNum);
        $postNum = intval($arrayNum[0]);
        $postNum = $postNum + 1;
        return sprintf('%04d', strval($postNum)) . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3] . '/' . $arrayNum[4] . '/' . $arrayNum[5];
    }

    protected function explodeNumP($preNum, $postNum): string
    {
        $arrayNum = explode("/", $preNum);
        $postNum = $postNum + 1;
        return sprintf('%04d', strval($postNum)) . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3] . '/' . $arrayNum[4] . '/' . $arrayNum[5];
    }
}
