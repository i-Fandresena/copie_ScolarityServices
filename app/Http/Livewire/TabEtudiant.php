<?php

namespace App\Http\Livewire;

use App\Http\Controllers\DroitController;
use App\Models\Archives\ArchiveCandidatL1;
use App\Models\Archives\ArchiveCandidatM1;
use App\Models\Archives\ArchiveCandidatM2;
use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveL3;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveM2;
use App\Models\Archives\ArchiveMR;
use App\Models\Bordereau;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\Candidats\CandidatM2R;
use App\Models\Droit;
use App\Models\Parcours;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterRecherche;
use App\Models\Students\MasterTwo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use mysql_xdevapi\Exception;
use Spatie\SimpleExcel\SimpleExcelReader;

class TabEtudiant extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';
    public string $niveau = '';
    public $referenceBrd1;
    public $aboutId = 0;
    public $referenceBrd2;
    public $montantBrd1;
    public $montantBrd2;
    public $dateBrd1;
    public $dateBrd2;
    public $agenceBrd2;
    public $numInscrit;
    public $nom;
    public $prenom;
    public $dateNaissance;
    public $lieuNaissance;
    public $telCandidat;
    public $cin;
    public $nationalite;
    public $anneeUnivers;
    public $genre;
    public $centreExamen;
    public $email;
    public $situationMat;
    public $profession;
    public $statut;
    public $RAD;
    public $idParcours;
    public $observation;
    public $idDroitE;

    public $archive;
    public $year;

    /* L3 */
    public $parcoursL3;

    /*Candidat L*/

    public $serieBacc;
    public $anneeBacc;
    public $mentionBacc;
    public $mention;

    /*Candidat M1*/

    public $parcours;
    public $universite;
    public $etablissement;

    /*Candidat M2R*/
    public $cursus;

    public $excelFile;
    public $rap;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'deleteStudent' => 'deleteStudent',
    ];


    // function to seach from table students
    public function updatingSearch(){
        $this->resetPage();
    }

    public function setYear(){
        $this->year = $this->year;
    }

    public function confirmDelete($id)
    {
        $this->emit('modal', 'teste', 'deleteStudent', $id, null);
    }

    public function deleteStudent($id)
    {
        switch ($this->niveau)
        {
            case "L2":
                $student = LicenceTwo::find($id);
                $idBrd = $student->bordereau->idBrd;
                LicenceTwo::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "L3":
                $student = LicenceThree::find($id);
                $idBrd = $student->bordereau->idBrd;
                LicenceThree::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "M1":
                $student = MasterOne::find($id);
                $idBrd = $student->bordereau->idBrd;
                MasterOne::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "M2":
                $student = MasterTwo::find($id);
                $idBrd = $student->bordereau->idBrd;
                MasterTwo::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "MR":
                $student = MasterRecherche::find($id);
                $idBrd = $student->bordereau->idBrd;
                MasterRecherche::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "PL":
                $student = CandidatL::find($id);
                $idBrd = $student->bordereau->idBrd;
                CandidatL::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "PM2":
                $student = CandidatM2::find($id);
                $idBrd = $student->bordereau->idBrd;
                CandidatM2::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            case "PMR":
                $student = CandidatM2R::find($id);
                $idBrd = $student->bordereau->idBrd;
                CandidatM2R::destroy($student->idEtd);
                Bordereau::destroy($idBrd);
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $student = LicenceOne::find($id);
                    $idBrd = $student->bordereau->idBrd;
                    LicenceOne::destroy($student->idEtd);
                    Bordereau::destroy($idBrd);
                }
                if(Auth()->user()->role === "Master"){
                    $student = MasterOne::find($id);
                    $idBrd = $student->bordereau->idBrd;
                    MasterOne::destroy($student->idEtd);
                    Bordereau::destroy($idBrd);
                }
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'referenceBrd2' => ['unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
        ]);
    }

    public function dataPaySet($dataPay, $studentPay)
    {
        $this->montantBrd2 = preg_replace('/\s+/', '', $dataPay['montantBrd2']);
        $this->dateBrd2 = $dataPay['dateBrd2'];
        $this->agenceBrd2 = $dataPay['agenceBrd2'];
        if($this->archive){
            $this->savePayArchive($studentPay);
        }else{
            $this->savePay($studentPay);
        }

    }

    public function savePayArchive($studentPay)
    {
        $this->validate([
            'referenceBrd2' => ['required', 'unique:bordereaus,referenceBrd1','unique:bordereaus,referenceBrd2'],
            'montantBrd2' => 'required:integer',
            'dateBrd2' => 'required:date',
        ]);

        try{
            $id = $studentPay['idBrdE'];
            $bordereau = Bordereau::find($id);
            $bordereau->referenceBrd2 = $this->referenceBrd2;
            $bordereau->montantBrd2 += $this->montantBrd2;
            $bordereau->agenceBrd2 = $this->agenceBrd2;
            $bordereau->dateBrd2 = $this->dateBrd2;
            $bordereau->createdBy = Auth()->user()->name;
            $bordereau->save();

            $array = explode("/", $studentPay['numInscrit']);
            $niveau = $array[1];
            switch ($niveau) {
                    case "L1":
                        $studentEditPay = ArchiveL1::find($studentPay['idEtd']);
                        break;
                    case "L2":
                        $studentEditPay = ArchiveL2::find($studentPay['idEtd']);
                        break;
                    case "L3":
                        $studentEditPay = ArchiveL3::find($studentPay['idEtd']);
                        break;
                    case "M1":
                        $studentEditPay = ArchiveM1::find($studentPay['idEtd']);
                        break;
                    case "M2":
                        $studentEditPay = ArchiveM2::find($studentPay['idEtd']);
                        break;
                    case "MR":
                        $studentEditPay = ArchiveMR::find($studentPay['idEtd']);
                    break;
                }
            $studentEditPay->RAD -= $this->montantBrd2;
            if ($studentEditPay->RAD < 0){
                //mettre è zero si le droit est negative
                $studentEditPay->observation = "Surplus de : ".$studentEditPay->RAD * (-1)." pour la droit";
                $studentEditPay->RAD = 0;
            }
            $studentEditPay->save();
            $this->emit('flash', 'Transaction effféctuée avec succées !', 'success');
            $this->dispatchBrowserEvent('end-pay');
        } catch (\Exception $e){
            $this->emit('flash', 'Il y une erreur lors du payment du deuxiement tranche', 'error');
        }
}

    public function savePay($studentPay)
    {
        $this->validate([
            'referenceBrd2' => ['required', 'unique:bordereaus,referenceBrd1','unique:bordereaus,referenceBrd2'],
            'montantBrd2' => 'required:integer',
            'dateBrd2' => 'required:date',
        ]);

        try {
            $id = $studentPay['idBrdE'];
            $bordereau = Bordereau::find($id);
            $bordereau->referenceBrd2 = $this->referenceBrd2;
            $bordereau->montantBrd2 += $this->montantBrd2;
            $bordereau->agenceBrd2 = $this->agenceBrd2;
            $bordereau->dateBrd2 = $this->dateBrd2;
            $bordereau->createdBy = Auth()->user()->name;
            $bordereau->save();

            $array = explode("/", $studentPay['numInscrit']);
            $niveau = $array[1];
            switch ($niveau) {
                case "L1":
                    $studentEditPay = LicenceOne::find($studentPay['idEtd']);
                    break;
                case "L2":
                    $studentEditPay = LicenceTwo::find($studentPay['idEtd']);
                    break;
                case "L3":
                    $studentEditPay = LicenceThree::find($studentPay['idEtd']);
                    break;
                case "M1":
                    $studentEditPay = MasterOne::find($studentPay['idEtd']);
                    break;
                case "M2":
                    $studentEditPay = MasterTwo::find($studentPay['idEtd']);
                    break;
                case "MR":
                    $studentEditPay = MasterRecherche::find($studentPay['idEtd']);
                    break;
            }
            $studentEditPay->RAD = $studentEditPay->droit->montantDroit - $studentEditPay->bordereau->montantBrd1 - $studentEditPay->bordereau->montantBrd2;
            if ($studentEditPay->RAD < 0){
//                mettre è zero si le droit est negative
                $studentEditPay->observation = "Surplus de : ".$studentEditPay->RAD * (-1)." pour la droit";
                $studentEditPay->RAD = 0;
            }
            $studentEditPay->save();
            $this->emit('flash', 'Transaction effféctuée avec succées !', 'success');
            $this->dispatchBrowserEvent('end-pay');
        }catch (\Exception $e){
            $this->emit('flash', 'Il y une erreur lors du payment du deuxiement tranche', 'error');
        }

    }

    public function editStudent($studentEdit)
    {
        if($this->niveau != "MR")
            $this->validate([
                'nom' => 'required',
                'dateNaissance' => 'required:date',
                'nationalite' => 'required',
                'genre' => 'required',
                'centreExamen' => 'required',
                'email' => 'email',
                'statut' => 'required',
                'RAD' => 'numeric',
            ]);
        else
            $this->validate([
                'nom' => 'required',
                'dateNaissance' => 'required:date',
                'nationalite' => 'required',
                'genre' => 'required',
//                'centreExamen' => 'required',
                'email' => 'email',
                'statut' => 'required',
                'RAD' => 'numeric',
            ]);
        $array = explode("/", $studentEdit['numInscrit']);
        $niveau = $array[1];
        switch ($niveau) {
            case "L1":
                $stdEdit = LicenceOne::find($studentEdit['idEtd']);
                break;
            case "L2":
                $stdEdit = LicenceTwo::find($studentEdit['idEtd']);
                break;
            case "L3":
                $stdEdit = LicenceThree::find($studentEdit['idEtd']);
                $stdEdit->idParcours = $this->idParcours;
                break;
            case "M1":
                $stdEdit = MasterOne::find($studentEdit['idEtd']);
                break;
            case "M2":
                $stdEdit = MasterTwo::find($studentEdit['idEtd']);
                break;
            case "MR":
                $stdEdit = MasterRecherche::find($studentEdit['idEtd']);
                break;
        }

        $stdEdit->nom = $this->nom;
        $stdEdit->prenom = $this->prenom;
        $stdEdit->dateNaissance = $this->dateNaissance;
        $stdEdit->lieuNaissance = $this->lieuNaissance;
        $stdEdit->telCandidat = $this->telCandidat;
        $stdEdit->cin = $this->cin;
        $stdEdit->nationalite = $this->nationalite;
        $stdEdit->anneeUnivers = $this->anneeUnivers;
        $stdEdit->genre = $this->genre;
        if($niveau != 'MR')
            $stdEdit->centreExamen = $this->centreExamen;
        $stdEdit->email = $this->email;
        $stdEdit->situationMat = $this->situationMat;
        $stdEdit->profession = $this->profession;
        $stdEdit->statut = $this->statut;
        $stdEdit->RAD = $this->RAD;
        $stdEdit->observation = $studentEdit['observation'];
        $stdEdit->save();

        $this->dispatchBrowserEvent('end-edit');
        $this->emit('flash', 'Etudiant modifié avec succés !', 'success');

    }

    public function editArchive($studentEdit)
    {
        $this->validate([
            'nom' => 'required',
            'dateNaissance' => 'required:date',
            'nationalite' => 'required',
            'anneeUnivers' => 'required',
            'genre' => 'required',
            'centreExamen' => 'required',
            'email' => 'email',
            'statut' => 'required',
            'RAD' => 'numeric',
        ]);
        $array = explode("/", $studentEdit['numInscrit']);
        $niveau = $array[1];
        switch ($niveau) {
            case "L1":
                $stdEdit = ArchiveL1::find($studentEdit['idEtd']);
                break;
            case "L2":
                $stdEdit = ArchiveL2::find($studentEdit['idEtd']);
                break;
            case "L3":
                $stdEdit = ArchiveL3::find($studentEdit['idEtd']);
                break;
            case "M1":
                $stdEdit = ArchiveM1::find($studentEdit['idEtd']);
                break;
            case "M2":
                $stdEdit = ArchiveM2::find($studentEdit['idEtd']);
                break;
        }

        $stdEdit->nom = $this->nom;
        $stdEdit->prenom = $this->prenom;
        $stdEdit->dateNaissance = $this->dateNaissance;
        $stdEdit->lieuNaissance = $this->lieuNaissance;
        $stdEdit->telCandidat = $this->telCandidat;
        $stdEdit->cin = $this->cin;
        $stdEdit->nationalite = $this->nationalite;
        $stdEdit->anneeUnivers = $this->anneeUnivers;
        $stdEdit->genre = $this->genre;
        $stdEdit->centreExamen = $this->centreExamen;
        $stdEdit->email = $this->email;
        $stdEdit->situationMat = $this->situationMat;
        $stdEdit->profession = $this->profession;
        $stdEdit->statut = $this->statut;
        $stdEdit->RAD = $this->RAD;
        $stdEdit->observation = $studentEdit['observation'];
        $stdEdit->save();

        $this->dispatchBrowserEvent('end-edit');
        $this->emit('flash', 'Etudiant modifié avec succés !', 'success');
    }

    public function dataEditSet($studentEdit)
    {
        try {
            $this->nom = $studentEdit['nom'];
            $this->prenom = $studentEdit['prenom'];
            $this->dateNaissance = $studentEdit['dateNaissance'];
            $this->lieuNaissance = $studentEdit['lieuNaissance'];
            $this->telCandidat = $studentEdit['telCandidat'];
            $this->cin = $studentEdit['cin'];
            $this->nationalite = $studentEdit['nationalite'];
            $this->anneeUnivers = $studentEdit['anneeUnivers'];
            $this->genre = $studentEdit['genre'];
            if($this->niveau != "MR")
                $this->centreExamen = $studentEdit['centreExamen'];
            $this->email = $studentEdit['email'];
            // for L3
            if (isset($studentEdit['idParcours']))
                $this->idParcours = $studentEdit['idParcours'];
            $this->situationMat = $studentEdit['situationMat'];
            $this->profession = $studentEdit['profession'];
            $this->statut = $studentEdit['statut'];
            $this->RAD = preg_replace('/\s+/', '', $studentEdit['RAD']);

            if($this->archive){
                $this->editArchive($studentEdit);
            }else{
                $this->editStudent($studentEdit);
            }
        }catch (Exception){
            $this->emit('flash', 'Une erreur est survenue lors de la validation des données.', 'error');
        }

    }

    public function dataSetCandidatL($candidat)
    {
        $this->nom = $candidat['nom'];
        $this->prenom = $candidat['prenom'];
        $this->dateNaissance = $candidat['dateNaissance'];
        $this->lieuNaissance = $candidat['lieuNaissance'];
        $this->telCandidat = $candidat['telCandidat'];
        $this->cin = $candidat['cin'];
        $this->nationalite = $candidat['nationalite'];
        $this->anneeUnivers = $candidat['anneeUnivers'];
        $this->genre = $candidat['genre'];

        $this->serieBacc = $candidat['serieBacc'];
        $this->mentionBacc = $candidat['mentionBacc'];
        $this->anneeBacc = $candidat['anneeBacc'];

        $this->candidatL($candidat);
    }

    public function candidatL($candidat)
    {
        $this->validate([
            'nom' => 'required',
            'dateNaissance' => 'required:date',
            'nationalite' => 'required',
            'anneeUnivers' => 'required',
            'genre' => 'required',
            'serieBacc' => 'required',
            'mentionBacc' => 'required',
            'anneeBacc' => ['required:integer', 'max:4', 'min:4'],
        ]);
        $stdEdit = CandidatL::find($candidat['idEtd']);

        $stdEdit->nom = $this->nom;
        $stdEdit->prenom = $this->prenom;
        $stdEdit->dateNaissance = $this->dateNaissance;
        $stdEdit->lieuNaissance = $this->lieuNaissance;
        $stdEdit->telCandidat = $this->telCandidat;
        $stdEdit->cin = $this->cin;
        $stdEdit->nationalite = $this->nationalite;
        $stdEdit->anneeUnivers = $this->anneeUnivers;
        $stdEdit->genre = $this->genre;

        $stdEdit->serieBacc = $this->serieBacc;
        $stdEdit->mentionBacc = $this->mentionBacc;
        $stdEdit->anneeBacc = $this->anneeBacc;
        $stdEdit->observation = $candidat['observation'];
        $stdEdit->save();

        $this->dispatchBrowserEvent('end-edit');
        $this->emit('flash', 'Candidat modifié avec succés !', 'success');
    }

    public function dataSetcandidatM1($candidat)
    {
        $this->nom = $candidat['nom'];
        $this->prenom = $candidat['prenom'];
        $this->dateNaissance = $candidat['dateNaissance'];
        $this->lieuNaissance = $candidat['lieuNaissance'];
        $this->telCandidat = $candidat['telCandidat'];
        $this->cin = $candidat['cin'];
        $this->nationalite = $candidat['nationalite'];
        $this->anneeUnivers = $candidat['anneeUnivers'];
        $this->genre = $candidat['genre'];

        if ($this->niveau !== 'PMR') {
            $this->centreExamen = $candidat['centreExamen'];
        }
        $this->email = $candidat['email'];
        $this->situationMat = $candidat['situationMat'];
        $this->profession = $candidat['profession'];
        $this->statut = $candidat['statut'];

        $this->parcours = $candidat['parcours'];
        $this->etablissement = $candidat['etablissement'];
        $this->universite = $candidat['universite'];

        if ($this->niveau === 'PMR')
        {
            $this->cursus = $candidat['cursus'];
        }

        $this->candidatM1($candidat);
    }

    public function candidatM1($candidat)
    {
        $this->validate([
            'nom' => 'required',
            'dateNaissance' => 'required|date',
            'nationalite' => 'required',
            'anneeUnivers' => 'required',
            'genre' => 'required',
            'parcours' => 'required',
            'etablissement' => 'required',
            'universite' => 'required',
        ]);
        $array = explode("/", $candidat['numInscrit']);
        $niveau = $array[2];
        // switch between preselection
        switch ($niveau) {
            case "M1":
                $stdEdit = CandidatM::find($candidat['idEtd']);
                break;
            case "M2":
                $stdEdit = CandidatM2::find($candidat['idEtd']);
                break;
            case "MR":
                $stdEdit = CandidatM2R::find($candidat['idEtd']);
                $stdEdit->cursus = $this->cursus;
                break;
        }

        $stdEdit->nom = $this->nom;
        $stdEdit->prenom = $this->prenom;
        $stdEdit->dateNaissance = $this->dateNaissance;
        $stdEdit->lieuNaissance = $this->lieuNaissance;
        $stdEdit->telCandidat = $this->telCandidat;
        $stdEdit->cin = $this->cin;
        $stdEdit->nationalite = $this->nationalite;
        $stdEdit->anneeUnivers = $this->anneeUnivers;
        $stdEdit->genre = $this->genre;

        if ($this->niveau !== 'PMR'){
            $stdEdit->centreExamen = $this->centreExamen;
        }
        $stdEdit->email = $this->email;
        $stdEdit->situationMat = $this->situationMat;
        $stdEdit->profession = $this->profession;
        $stdEdit->statut = $this->statut;

        $stdEdit->parcours = $this->parcours;
        $stdEdit->etablissement = $this->etablissement;
        $stdEdit->universite = $this->universite;

        $stdEdit->observation = $candidat['observation'];

        $stdEdit->save();

        $this->dispatchBrowserEvent('end-edit');
        $this->emit('flash', 'Candidat modifié avec succés !', 'success');
    }

    public function orderType()
    {
        if($this->archive){
            $this->typeArchive();
        } else{
            $this->typeNormal();
        }
    }

    private function typeArchive()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv',
            'year' => 'required|integer',
        ]);

        switch ($this->niveau){
            case "L1":
                $this->importArchiveL1();
                break;
            case "L2":
                $this->importArchiveL2();
                break;
            case "L3":
                $this->importArchiveL3();
                break;
            case "M1":
                $this->importArchiveM1();
                break;
            case "M2":
                $this->importArchiveM2();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->importArchiveL1();
                }
                if(Auth()->user()->role === "Master"){
                    $this->importArchiveM1();
                }
        }
    }

    private function importArchiveL1()
    {
         try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                try {
                    ArchiveL1::create([
                        'numInscrit' => $this->numInscrit,
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'dateNaissance' => $this->dateNaissance,
                        'lieuNaissance' => $this->lieuNaissance,
                        'telCandidat' => $this->telCandidat,
                        'cin' => $this->cin,
                        'nationalite' => $this->nationalite,
                        'anneeUnivers' => $this->year,
                        'genre' => $this->genre,
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                    ]);
                } catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }

            }
            $status = true;

        }catch (\Exception $e){
             $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', $e, 'error');
        }
    }
    private function importArchiveL2()
    {
    try {
        $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
        $rows = $reader->getRows();
        $data = $rows->toArray();
        foreach ($data as $row) {
            $this->dataImportSet($row);
            $idBrd = $this->bordereau();
            try {
                ArchiveL2::create([
                    'numInscrit' => $this->numInscrit,
                    'nom' => $this->nom,
                    'prenom' => $this->prenom,
                    'dateNaissance' => $this->dateNaissance,
                    'lieuNaissance' => $this->lieuNaissance,
                    'telCandidat' => $this->telCandidat,
                    'cin' => $this->cin,
                    'nationalite' => $this->nationalite,
                    'anneeUnivers' => $this->year,
                    'genre' => $this->genre,
                    'centreExamen' => $this->centreExamen,
                    'email' => $this->email,
                    'situationMat' => $this->situationMat,
                    'profession' => $this->profession,
                    'RAD' => $this->rap,
                    'observation' => $this->observation,
                    'idBrdE' => $idBrd,
                ]);
            } catch (\Exception $e){
                Bordereau::destroy($idBrd);
                $status = false;
            }
        }
        $status = true;

    }catch (\Exception $e){
        $status = false;
    }
    if ($status) {
        $reader->close();
        $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
    } else {
        $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
    }
}
    private function importArchiveL3()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                try {
                    ArchiveL3::create([
                        'numInscrit' => $this->numInscrit,
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'dateNaissance' => $this->dateNaissance,
                        'lieuNaissance' => $this->lieuNaissance,
                        'telCandidat' => $this->telCandidat,
                        'cin' => $this->cin,
                        'nationalite' => $this->nationalite,
                        'anneeUnivers' => $this->year,
                        'genre' => $this->genre,
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idParcours' => $this->parcoursL3,
                        'idBrdE' => $idBrd,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importArchiveM1()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                try {
                    ArchiveM1::create([
                        'numInscrit' => $this->numInscrit,
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'dateNaissance' => $this->dateNaissance,
                        'lieuNaissance' => $this->lieuNaissance,
                        'telCandidat' => $this->telCandidat,
                        'cin' => $this->cin,
                        'nationalite' => $this->nationalite,
                        'anneeUnivers' => $this->year,
                        'genre' => $this->genre,
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importArchiveM2()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                try {
                    ArchiveM2::create([
                        'numInscrit' => $this->numInscrit,
                        'nom' => $this->nom,
                        'prenom' => $this->prenom,
                        'dateNaissance' => $this->dateNaissance,
                        'lieuNaissance' => $this->lieuNaissance,
                        'telCandidat' => $this->telCandidat,
                        'cin' => $this->cin,
                        'nationalite' => $this->nationalite,
                        'anneeUnivers' => $this->year,
                        'genre' => $this->genre,
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }

    private function bordereau()
    {
        try {
            $bordereau = Bordereau::create([
                'referenceBrd1' => $this->referenceBrd1,
                'montantBrd1' => $this->montantBrd1,
                'dateBrd1' => $this->dateBrd1,
                'referenceBrd2' => $this->referenceBrd2,
                'montantBrd2' => $this->montantBrd2,
                'dateBrd2' => $this->dateBrd2,
                'createdBy' => Auth()->user()->name,
            ]);
            return $bordereau->idBrd;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function dataImportSet($row)
    {
        if ($this->niveau === 'MR') {
            if($row['Mention'] === "") $this->mention = null;
            else $this->mention = $row['Mention'];
        }
        if($this->archive){
            if($row['Numero'] === "") $this->numInscrit = null;
            else $this->numInscrit = preg_replace('/\s+/', '',strval($row['Numero']));
        } else{
            $this->anneeUnivers = $row['Annee Universitaire'];
            $this->numInscrit = $this->getNumber();
        }

        if($this->niveau === 'L3'){
            // Education Présco
            if( strtoupper(strval($row['Options'])) === "PRESCO"){
                $this->parcoursL3 = 2;
            }else{
                $this->parcoursL3 = 1;
            }
        }
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
        if($row['Genre'] === "") $this->genre = "Masculin";
        else $this->genre = $row['Genre'];
        if($row['CIN'] === "") $this->cin = null;
        else $this->cin = preg_replace('/\s+/', '',$row['CIN']);
        if ($row['Nationalite'] === "") $this->nationalite = "Malagasy";
        else $this->nationalite = $row['Nationalite'];
        if ($row['Email'] === "") $this->email = null;
        else $this->email = preg_replace('/\s+/', '', $row['Email']);
        if ($row['Status'] === "") $this->statut = "Non Fonctionnaire";
        else $this->statut = $row['Status'];
        if ($this->niveau != 'MR') {
            if ($row['Centre d\'examen'] === "") $this->centreExamen = "Fianarantsoa";
            else $this->centreExamen = $row['Centre d\'examen'];
        }
        if ($row['Profession'] === "") $this->profession = null;
        else $this->profession = $row['Profession'];
        if ($row['Situation matrimoniale'] === "") $this->situationMat = "Célibataire";
        else $this->situationMat = $row['Situation matrimoniale'];

        if($row['Reference 1ere tranche'] === "") $this->referenceBrd1 = $this->numInscrit;
        else $this->referenceBrd1 = $row['Reference 1ere tranche'];
        if($row['Montant 1ere tranche'] === "") $this->montantBrd1 = 0;
        else $this->montantBrd1 = preg_replace('/\s+/', '', $row['Montant 1ere tranche']);
        if($row['Date 1ere tranche'] === "") {
            $this->dateBrd1 = date_create('now');
        } elseif (gettype($row['Date 1ere tranche']) === "string") {
            $timestamp = strtotime(str_replace('/', '-', $row['Date 1ere tranche']));
            $date = date('Y-m-d', $timestamp);
            $this->dateBrd1 = $date;
        } else {
            $this->dateBrd1 = $row['Date 1ere tranche'];
        }

        if($row['Reference 2eme tranche'] === "") $this->referenceBrd2 = null;
        else $this->referenceBrd2 = $row['Reference 2eme tranche'];
        if($row['Montant 2eme tranche'] === "") $this->montantBrd2 = 0;
        else $this->montantBrd2 = preg_replace('/\s+/', '', $row['Montant 2eme tranche']);
        if($row['Date 2eme tranche'] === "") {
            $this->dateBrd1 = date_create('now');
        } elseif (gettype($row['Date 2eme tranche']) === "string") {
            $timestamp = strtotime(str_replace('/', '-', $row['Date 2eme tranche']));
            $date = date('Y-m-d', $timestamp);
            $this->dateBrd1 = $date;
        } else {
            $this->dateBrd1 = $row['Date 2eme tranche'];
        }

        if($row['Reste à payer'] === "" or !is_numeric($row['Reste à payer'])) $this->rap = DroitController::getDroit($this->niveau) - ($this->montantBrd1 + $this->montantBrd2);
        else $this->rap = preg_replace('/\s+/', '', $row['Reste à payer']);

        if ($row['Observation'] === "") $this->observation = "Aucune";
        else $this->observation = $row['Observation'];
    }

    private function typeNormal()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        switch ($this->niveau){
            case "L1":
                $this->importListL1();
                break;
            case "L2":
                $this->importListL2();
                break;
            case "L3":
                $this->importListL3();
                break;
            case "M1":
                $this->importListM1();
                break;
            case "M2":
                $this->importListM2();
                break;
            case "MR":
                $this->importListMRecherche();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->importListL1();
                }
                if(Auth()->user()->role === "Master"){
                    $this->importListM1();
                }
        }
    }

    private function importListL1()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                try{
                    LicenceOne::create([
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
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                        'idDroitE' => Droit::where('typeDroit', 'L1')->value('idDroit'),
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importListL2()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                try {
                    LicenceTwo::create([
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
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                        'idDroitE' =>Droit::where('typeDroit', 'L2')->value('idDroit'),
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importListL3()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                $idDroit = DroitController::getIdDroit('L3');
                try {
                    LicenceThree::create([
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
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idParcours' => $this->parcoursL3,
                        'idBrdE' => $idBrd,
                        'idDroitE' => $idDroit,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importListM1()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                $idDroit = DroitController::getIdDroit('M1');
                try {
                    MasterOne::create([
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
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                        'idDroitE' => $idDroit,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importListM2()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                $idDroit = DroitController::getIdDroit('M2');
                try {
                    MasterTwo::create([
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
                        'centreExamen' => $this->centreExamen,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                        'idDroitE' => $idDroit,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }
    private function importListMRecherche()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $status = true;
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                $this->dataImportSet($row);
                $idBrd = $this->bordereau();
                $idDroit = DroitController::getIdDroit('M2R');
                try {
                    MasterRecherche::create([
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
                        'mention' => $this->mention,
                        'email' => $this->email,
                        'situationMat' => $this->situationMat,
                        'profession' => $this->profession,
                        'RAD' => $this->rap,
                        'observation' => $this->observation,
                        'idBrdE' => $idBrd,
                        'idDroitE' => $idDroit,
                    ]);
                }catch (\Exception $e){
                    Bordereau::destroy($idBrd);
                    $status = false;
                }
            }
        }catch (\Exception $e){
            $status = false;
        }
        if ($status) {
            $reader->close();
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $reader->close();
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }

    private function getNumber()
    {
        switch ($this->niveau) {
            case "L1":
                $verif = LicenceOne::count();
                if ($verif > 0)
                {
                    $preNum = LicenceOne::orderBy('idEtd', 'desc')->first()->numInscrit;;
                    $arrayNum = explode("/", $preNum);
                    $postNum = intval($arrayNum[0]);
                    $postNum = $postNum + 1;
                    return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                }
                else
                {
                    $arrayYear = str_split($this->anneeUnivers);
                    return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L1' . '/SE' . '/' . 'D';
                }
                break;
            case "L2":
                $verif = LicenceTwo::count();
                if ($verif > 0)
                {
                    $preNum = LicenceTwo::orderBy('idEtd', 'desc')->first()->numInscrit;
                    $arrayNum = explode("/", $preNum);
                    $postNum = intval($arrayNum[0]);
                    $postNum = $postNum + 1;
                    return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                }
                else
                {
                    $arrayYear = str_split($this->anneeUnivers);
                    return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L2' . '/SE' . '/' . 'D';
                }
                break;
            case "L3":
                $verif = LicenceThree::count();
                if ($verif > 0)
                {
                    $preNum = LicenceThree::orderBy('idEtd', 'desc')->first()->numInscrit;
                    $arrayNum = explode("/", $preNum);
                    $postNum = intval($arrayNum[0]);
                    $postNum = $postNum + 1;
                    return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                }
                else
                {
                    $arrayYear = str_split($this->anneeUnivers);
                    return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L3' . '/SE' . '/' . 'D';
                }
                break;
            case "M1":
                $verif = MasterOne::count();
                if ($verif > 0)
                {
                    $preNum = MasterOne::orderBy('idEtd', 'desc')->first()->numInscrit;
                    $arrayNum = explode("/", $preNum);
                    $postNum = intval($arrayNum[0]);
                    $postNum = $postNum + 1;
                    return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                }
                else
                {
                    $arrayYear = str_split($this->anneeUnivers);
                    return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'M1' . '/SE' . '/' . 'D';
                }
                break;
            case "M2":
                $verif = MasterTwo::count();
                if ($verif > 0)
                {
                    $preNum = MasterTwo::orderBy('idEtd', 'desc')->first()->numInscrit;
                    $arrayNum = explode("/", $preNum);
                    $postNum = intval($arrayNum[0]);
                    $postNum = $postNum + 1;
                    return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                }
                else
                {
                    $arrayYear = str_split($this->anneeUnivers);
                    return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'M2' . '/SE' . '/' . 'D';
                }
                break;
            case "MR":
                $verif = MasterRecherche::count();
                $arrayYear = str_split($this->anneeUnivers);
                if ($verif > 0)
                {
                    if ($this->mention == "Mathematique"){
                        $preNum = MasterRecherche::whereRaw('UPPER(mention) = ?', ['MATHEMATIQUE'])
                            ->orderBy('idEtd', 'desc')
                            ->first();
                        // if exist
                        if ($preNum){
                            $arrayNum = explode("/", $preNum->numInscrit);
                            $postNum = intval($arrayNum[0]);
                            $postNum = $postNum + 1;
                            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2];
                        } else {
                            return $arrayYear[2] . $arrayYear[3] . '001' . '/' . 'MR' . '/MT';
                        }
                    }
                    elseif ($this->mention == "Physique-Chimie"){
                        $preNum = MasterRecherche::whereRaw('UPPER(mention) = ?', ['PHYSIQUE-CHIMIE'])
                            ->orderBy('idEtd', 'desc')
                            ->first();
                        if ($preNum){
                            $arrayNum = explode("/", $preNum->numInscrit);
                            $postNum = intval($arrayNum[0]);
                            $postNum = $postNum + 1;
                            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2];
                        } else {
                            return $arrayYear[2] . $arrayYear[3] . '001' . '/' . 'MR' . '/PC';
                        }
                    }
                    else {
                        $preNum = MasterRecherche::whereRaw('UPPER(mention) = ?', ["SCIENCE DE L'EDUCATION"])
                            ->orderBy('idEtd', 'desc')
                            ->first();
                        if ($preNum){
                            $arrayNum = explode("/", $preNum->numInscrit);
                            $postNum = intval($arrayNum[0]);
                            $postNum = $postNum + 1;
                            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2];
                        } else {
                            return $arrayYear[2] . $arrayYear[3] . '001' . '/' . 'MR' . '/SE';
                        }
                    }
                }
                else
                {
                    if ($this->mention == "Mathematique")
                        return $arrayYear[2] . $arrayYear[3] . '001' . '/' . 'MR' . '/MT';
                    elseif ($this->mention == "Physique-Chimie")
                        return $arrayYear[2] . $arrayYear[3] . '001' . '/' . 'MR' . '/PC';
                    else
                        return $arrayYear[2] . $arrayYear[3] . '001' . '/' . 'MR' . '/SE';
                }
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $verif = LicenceOne::count();
                    if ($verif > 0)
                    {
                        $preNum = LicenceOne::orderBy('idEtd', 'desc')->first()->numInscrit;
                        $arrayNum = explode("/", $preNum);
                        $postNum = intval($arrayNum[0]);
                        $postNum = $postNum + 1;
                        return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                    }
                    else
                    {
                        $arrayYear = str_split($this->anneeUnivers);
                        return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L1' . '/SE' . '/' . 'D';
                    }
                }
                if(Auth()->user()->role === "Master"){
                    $verif = MasterOne::count();
                    if ($verif > 0)
                    {
                        $preNum = MasterOne::orderBy('idEtd', 'desc')->first()->numInscrit;
                        $arrayNum = explode("/", $preNum);
                        $postNum = intval($arrayNum[0]);
                        $postNum = $postNum + 1;
                        return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
                    }
                    else
                    {
                        $arrayYear = str_split($this->anneeUnivers);
                        return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'M1' . '/SE' . '/' . 'D';
                    }
                }
                break;
        }
    }

    public function setId($id)
    {
        $this->aboutId = $id;
    }

    public function resetId()
    {
        $this->aboutId = 0;
        $this->resetPage();
    }

    public function render()
    {
        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
        if($this->archive)
        {
            switch ($this->niveau)
            {
                case "L1":
                    $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL1::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "L2":
                    $annees = ArchiveL2::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL2::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "L3":
                    $annees = ArchiveL3::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL3::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "M1":
                    $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveM1::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "M2":
                    $annees = ArchiveM2::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveM2::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "MR":
                    $annees = ArchiveMR::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveMR::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;

                case "PL":
                    $annees = ArchiveCandidatL1::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveCandidatL1::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "PM1":
                    $annees = ArchiveCandidatM1::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveCandidatM1::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "PM2":
                    $annees = ArchiveCandidatM2::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveCandidatM2::where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;

                default:
                    if(Auth()->user()->role === "Licence"){
                        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                        $students = ArchiveL1::where('anneeUnivers', '=', "{$this->year}")
                            ->where(function($query) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            })
                            ->orderBy('numInscrit')
                            ->paginate(10);
                    }
                    if(Auth()->user()->role === "Master"){
                        $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                        $students = ArchiveM1::where('anneeUnivers', '=', "{$this->year}")
                            ->where(function($query) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            })
                            ->orderBy('numInscrit')
                            ->paginate(10);
                    }
            }

            if($this->aboutId === 0 and $students->count() > 0)
            {
                $item = $students[0];
            }
            elseif ($students->count() > 0)
            {
                switch ($this->niveau) {
                    case "L1":
                        $item = ArchiveL1::find($this->aboutId);
                        break;
                    case "L2":
                        $item = ArchiveL2::find($this->aboutId);
                        break;
                    case "L3":
                        $item = ArchiveL3::find($this->aboutId);
                        break;
                    case "M1":
                        $item = ArchiveM1::find($this->aboutId);
                        break;
                    case "M2":
                        $item = ArchiveM2::find($this->aboutId);
                        break;
                    case "MR":
                        $item = ArchiveMR::find($this->aboutId);
                        break;
                    default:
                        if(Auth()->user()->role === "Licence"){
                            $item = ArchiveL1::find($this->aboutId);
                        }
                        if(Auth()->user()->role === "Master"){
                            $item = ArchiveM1::find($this->aboutId);
                        }
                }
            }
            else
            {
                $item = null;
            }
        } else{
            switch ($this->niveau) {
                case "L1":
                    $students = LicenceOne::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "L2":
                    $students = LicenceTwo::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "L3":
                    $students = LicenceThree::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "M1":
                    $students = MasterOne::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "M2":
                    $students = MasterTwo::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "MR":
                    $students = MasterRecherche::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "PL":
                    $students = CandidatL::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "PM1":
                    $students = CandidatM::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "PM2":
                    $students = CandidatM2::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                case "PMR":
                    $students = CandidatM2R::where(function($query) {
                        if (!empty($this->search)) {
                            $query->where('prenom', 'LIKE', "%{$this->search}%")
                                ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                        }
                    })
                        ->orderBy('numInscrit')
                        ->paginate(10);
                    break;
                default:
                    if(Auth()->user()->role === "Licence"){
                        $students = LicenceOne::where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                            ->orderBy('numInscrit')
                            ->paginate(10);
                    }
                    if(Auth()->user()->role === "Master"){
                        $students = MasterOne::where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                            ->orderBy('numInscrit')
                            ->paginate(10);
                    }
            }

            if($this->aboutId === 0 and $students->count() > 0)
            {
                $item = $students[0];
            }
            elseif ($students->count() > 0)
            {
                switch ($this->niveau) {
                    case "L1":
                        $item = LicenceOne::find($this->aboutId);
                        break;
                    case "L2":
                        $item = LicenceTwo::find($this->aboutId);
                        break;
                    case "L3":
                        $item = LicenceThree::find($this->aboutId);
                        break;
                    case "M1":
                        $item = MasterOne::find($this->aboutId);
                        break;
                    case "M2":
                        $item = MasterTwo::find($this->aboutId);
                        break;
                    case "MR":
                        $item = MasterRecherche::find($this->aboutId);
                        break;
                    case "PL":
                        $item = CandidatL::find($this->aboutId);
                        break;
                    case "PM1":
                        $item = CandidatM::find($this->aboutId);
                        break;
                    case "PM2":
                        $item = CandidatM2::find($this->aboutId);
                        break;
                    case "PMR":
                        $item = CandidatM2R::find($this->aboutId);
                        break;
                    default:
                        if(Auth()->user()->role === "Licence"){
                            $item = LicenceOne::find($this->aboutId);
                        }
                        if(Auth()->user()->role === "Master"){
                            $item = MasterOne::find($this->aboutId);
                        }
                }
            }
            else
            {
                $item = null;
            }
        }

        return view('livewire.tab-etudiant', [
            'students' => $students,
            'item' => $item,
            'annees' => $annees,
        ]);
    }

}
