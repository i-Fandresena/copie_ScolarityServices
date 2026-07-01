<?php

namespace App\Http\Livewire;

use App\Models\Admis;
use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveMR;
use App\Models\Bordereau;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\Candidats\CandidatM2R;
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
use App\Models\Students\MasterRecherche;
use App\Models\Students\MasterTwo;
use Exception;
use Livewire\Component;

class ListeAdmis extends Component
{
    public string $search = '';
    public int $currentId = 0;
    public $selectedLevel = '';
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
    public $observation;
    public $idBrdE;
    public $idDroitE;
    public $referenceBrd1;
    public $dateBrd1;
    public $agenceBrd1;
    public $montantBrd1;
    private $parcours;
    private $mention;
    public $case = 'P';

    public function dataRegisterSet($data, $cdt, $type)
    {
        $oldData = null;
        $num = $cdt['numInscrit'];
        switch ($this->selectedLevel) {
            case "L1":
                if ($this->case === 'P') {
                    $oldData = CandidatL::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'L1E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'L1')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                } else {
                    $oldData = ArchiveL1::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'L1E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'L1')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifiez le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }


                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                }

                break;
            case "L2":
                if ($this->case === 'P') {
                    $oldData = ArchiveL1::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'L2E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'L2')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                } else {
                    $oldData = ArchiveL2::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'L2E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'L2')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }
                        // droit verification
                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                }

                break;
            case "L3":
                if ($this->case === 'P') {
                    $oldData = ArchiveL2::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'L3E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'L3')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                } else {
                    $oldData = ArchiveL3::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'L3E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'L3')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                }

                break;
            case "M1":
                if ($this->case === 'P') {
                    $oldData = CandidatM::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'M1E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'M1')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                } else {
                    $oldData = ArchiveM1::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'M1E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'M1')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                }

                break;
            case "M2":
                if ($this->case === 'P') {
                    $oldData = ArchiveM1::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if (!is_null($oldData)) {
                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'M2E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'M2')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }
                    } elseif (is_null($oldData)) {
                        $oldData = CandidatM2::where('numInscrit', 'LIKE', "%{$num}%")->first();
                        if ($oldData) {
                            $this->anneeUnivers = $oldData->anneeUnivers;
                            if ($oldData->nationalite === 'Etranger') {
                                $this->idDroitE = Droit::where('typeDroit', 'M2E')->value('idDroit');
                            } else {
                                $this->idDroitE = Droit::where('typeDroit', 'M2')->value('idDroit');
                            }

                            if (!$this->idDroitE) {
                                return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                            }

                            if($oldData->RAD > 0){
                                return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                            }

                        } else {
                            return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                        }
                    }

                } else {
                    $oldData = ArchiveM2::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        $this->anneeUnivers = $oldData->anneeUnivers + 1;
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'M2E')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'M2')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                }

                break;
            case "M2R":
                if ($this->case === 'P') {
                    $oldData = CandidatM2R::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'M2R')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'M2R')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                } else {
                    $oldData = ArchiveMR::where('numInscrit', 'LIKE', "%{$num}%")->first();
                    if ($oldData) {
                        if ($oldData->nationalite === 'Etranger') {
                            $this->idDroitE = Droit::where('typeDroit', 'M2R')->value('idDroit');
                        } else {
                            $this->idDroitE = Droit::where('typeDroit', 'M2R')->value('idDroit');
                        }

                        if (!$this->idDroitE) {
                            return $this->emit('flash', 'Vous devez verifier le montant du droit !', 'warning');
                        }

                        if($oldData->RAD > 0){
                            return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                        }

                        $this->anneeUnivers = $oldData->anneeUnivers;
                    } else {
                        return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                    }
                }

                break;
            default:
                if (Auth()->user()->role === "Licence") {
                    if ($this->case === 'P') {
                        // check on Preselection
                        $oldData = CandidatL::where('numInscrit', 'LIKE', "%{$num}%")->first();
                        if ($oldData) {
                            $this->anneeUnivers = $oldData->anneeUnivers;
                            if ($oldData->nationalite === 'Etranger') {
                                $this->idDroitE = Droit::where('typeDroit', 'L1E')->value('idDroit');
                            } else {
                                $this->idDroitE = Droit::where('typeDroit', 'L1')->value('idDroit');
                            }
                            if (!$this->idDroitE) {
                                return $this->emit('flash', 'Vous devez vérifiez le montant du droit !', 'warning');
                            }

                            if($oldData->RAD > 0){
                                return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                            }

                        } else {
                            return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                        }
                    }
                    if ($this->case === 'R') {
                        $oldData = ArchiveL1::where('numInscrit', 'LIKE', "%{$num}%")->first();

                        if ($oldData) {
                            $this->anneeUnivers = $oldData->anneeUnivers + 1;

                            if ($oldData->nationalite === 'Etranger') {
                                $this->idDroitE = Droit::where('typeDroit', 'L1E')->value('idDroit');
                            } else {
                                $this->idDroitE = Droit::where('typeDroit', 'L1')->value('idDroit');
                            }

                            if (!$this->idDroitE) {
                                return $this->emit('flash', 'Vous devez vérifiez le montant du droit !', 'info');
                            }

                            if($oldData->RAD > 0){
                                return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                            }

                        } else {
                            return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                        }
                    }

                    break;
                }
                if (Auth()->user()->role === "Master") {
                    if ($this->case === 'P') {
                        $oldData = CandidatM::where('numInscrit', 'LIKE', "%{$num}%")->first();
                        if ($oldData) {
                            $this->anneeUnivers = $oldData->anneeUnivers;

                            if ($oldData->nationalite === 'Etranger') {
                                $this->idDroitE = Droit::where('typeDroit', 'M1E')->value('idDroit');
                            } else {
                                $this->idDroitE = Droit::where('typeDroit', 'M1')->value('idDroit');
                            }
                            if (!$this->idDroitE) {
                                return $this->emit('flash', 'Vous devez vérifiez le montant du droit !', 'warning');
                            }

                            if($oldData->RAD > 0){
                                return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                            }

                        } else {
                            return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                        }
                    } else {
                        $oldData = ArchiveM1::where('numInscrit', 'LIKE', "%{$num}%")->first();

                        if ($oldData) {
                            $this->anneeUnivers = $oldData->anneeUnivers + 1;

                            if ($oldData->nationalite === 'Etranger') {
                                $this->idDroitE = Droit::where('typeDroit', 'M1E')->value('idDroit');
                            } else {
                                $this->idDroitE = Droit::where('typeDroit', 'M1')->value('idDroit');
                            }

                            if (!$this->idDroitE) {
                                return $this->emit('flash', 'Vous devez vérifiez le montant du droit !', 'warning');
                            }

                            if($oldData->RAD > 0){
                                return $this->emit('flash', "L'étudiant doit payer leur frais precendent ".$oldData->anneeUnivers - 1 ."-".$oldData->anneeUnivers. " de montant de ". $oldData->RAD . " Ar", 'warning');
                            }

                        } else {
                            return $this->emit('flash', 'Aucune information concernant ' . $num . ' !', 'warning');
                        }
                    }
                    break;
                }
        }
//      if student exist in database
        if ($oldData){
            $this->nom = $oldData->nom;
            $this->prenom = $oldData->prenom;
            $this->dateNaissance = $oldData->dateNaissance;
            $this->lieuNaissance = $oldData->lieuNaissance;
            $this->telCandidat = $oldData->telCandidat;
            $this->cin = $oldData->cin;
            $this->nationalite = $oldData->nationalite;
            $this->genre = $oldData->genre;
            if(Auth()->user()->role === "Licence" and $this->selectedLevel !== "L2" and $this->selectedLevel !== "L3") {
                $this->centreExamen = $data['centreExamen'];
                $this->email = $data['email'];
                $this->situationMat = $data['situationMat'];
                $this->profession = $data['profession'];
                $this->statut = $data['statut'];
            }else {
                $this->centreExamen = $oldData->centreExamen;
                $this->email = $oldData->email;
                $this->situationMat = $oldData->situationMat;
                $this->profession = $oldData->profession;
                $this->statut = $oldData->statut;
            }

            if($this->selectedLevel === 'L3'){
                $this->parcours = $data['parcours'];
            }
            if($this->selectedLevel === 'M2R'){
                $this->mention = $data['mention'];
            }
            $this->observation = $data['observation'];

            $this->montantBrd1 = preg_replace('/\s+/', '', $data['montantBrd1']);
            $this->dateBrd1 = $data['dateBrd1'];
            $this->agenceBrd1 = $data['agenceBrd1'];

            try {
                $drt = Droit::find($this->idDroitE);
                if(is_numeric(strval($this->montantBrd1))){
                    $this->RAD = $drt->montantDroit - strval($this->montantBrd1);
                }
            } catch (Exception){
                $this->emit('flash', 'Vous devez vérifiez le montant du droit !', 'warning');
                return null;
            }

            if ($type === 'inscrire')
                return $this->submit($num);
            else
                return $this->NotNowSubmit($num, $drt->montantDroit);

        }else{
            $this->emit('flash', 'Aucune information concernant: '.$num.'!', 'warning');
            return null;
        }
    }

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function resetData(){
        $this->dispatchBrowserEvent('reset-data');
        $this->reset(['referenceBrd1', 'email']);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'referenceBrd1' => ['unique:bordereaus,referenceBrd1', 'unique:bordereaus,referenceBrd2'],
        ]);
    }

    private function generateL1Num()
    {
        $verifNiv = LicenceOne::count();
        $verifDR = DRL1::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = LicenceOne::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRL1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumNiv);
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRL1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNumDR = LicenceOne::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
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
    private function generateL2Num()
    {
        $verifNiv = LicenceTwo::count();
        $verifDR = DRL2::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = LicenceTwo::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRL2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumNiv);
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRL2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNumDR = LicenceTwo::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else
        {
            $arrayYear = str_split($this->anneeUnivers);
            return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L2' . '/SE' . '/' . 'D';
        }
    }
    private function generateL3Num()
    {
        $verifNiv = LicenceThree::count();
        $verifDR = DRL3::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = LicenceThree::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRL3::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumNiv);
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRL3::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNumDR = LicenceThree::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else
        {
            $arrayYear = str_split($this->anneeUnivers);
            return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L3' . '/SE' . '/' . 'D';
        }
    }
    private function generateM1Num()
    {
        $verifNiv = MasterOne::count();
        $verifDR = DRM1::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = MasterOne::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRM1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumNiv);
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRM1::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNumDR = MasterOne::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
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
    private function generateM2Num()
    {
        $verifNiv = MasterTwo::count();
        $verifDR = DRM2::count();
        if ($verifDR > 0 && $verifNiv > 0)
        {
            $preNumNiv = MasterTwo::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $preNumDR = DRM2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumNiv);
            preg_match('/(\d+)/', $preNumNiv, $matches1);
            preg_match('/(\d+)/', $preNumDR, $matches2);
            $numero1 = isset($matches1[1]) ? intval($matches1[1]) : 0;
            $numero2 = isset($matches2[1]) ? intval($matches2[1]) : 0;

            $postNum = max($numero1, $numero2);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR > 0 && $verifNiv <= 0)
        {
            $preNumDR = DRM2::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else if ($verifDR <= 0 && $verifNiv > 0)
        {
            $preNumDR = MasterTwo::orderBy('numInscrit', 'desc')->first()->numInscrit;
            $arrayNum = explode("/", $preNumDR);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            return $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else
        {
            $arrayYear = str_split($this->anneeUnivers);
            return $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'M2' . '/SE' . '/' . 'D';
        }
    }

    private function generateNum()
    {
        switch ($this->selectedLevel) {
            case "L2":
                return $this->generateL2Num();
                break;
            case "L3":
                return $this->generateL3Num();
                break;
            case "M2":
                return $this->generateM2Num();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    return $this->generateL1Num();
                }
                if(Auth()->user()->role === "Master"){
                    return $this->generateM1Num();
                }
                break;
        }
    }

    public function NotNowSubmit($deleteNum, $montantDroit)
    {
        $this->validate([
            'nom' => 'required'
        ]);

        $this->numInscrit = $this->generateNum();

        switch ($this->selectedLevel) {
            case "L1":
                $newStudent = new DRL1();
                break;
            case "L2":
                $newStudent = new DRL2();
                break;
            case "L3":
                $newStudent = new DRL3();
                break;
            case "M1":
                $newStudent = new DRM1();
                break;
            case "M2":
                $newStudent = new DRM2();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $newStudent = new DRL1();
                }
                if(Auth()->user()->role === "Master"){
                    $newStudent = new DRM1();
                }
                break;
        }

        try{
            $newStudent->numInscrit = $this->numInscrit;
            $newStudent->nom = $this->nom;
            $newStudent->prenom = $this->prenom;
            $newStudent->dateNaissance = $this->dateNaissance;
            $newStudent->lieuNaissance = $this->lieuNaissance;
            $newStudent->telCandidat = $this->telCandidat;
            $newStudent->cin = $this->cin;
            $newStudent->nationalite = $this->nationalite;
            $newStudent->anneeUnivers = $this->anneeUnivers;
            $newStudent->genre = $this->genre;
            $newStudent->centreExamen = $this->centreExamen;
            $newStudent->email = $this->email;
            $newStudent-> situationMat = $this->situationMat;
            $newStudent->profession = $this->profession;
            $newStudent->statut = $this->statut;
            $newStudent->RAD = $montantDroit;
            $newStudent->observation = $this->observation;
            $newStudent->idDroitE = $this->idDroitE;
            if($this->selectedLevel === 'L3')
                $newStudent->idParcours = $this->parcours;


            $newStudent->save();

            $id = Admis::where('numInscrit', "{$deleteNum}")->value('idAdmis');
            Admis::destroy($id);

            $this->emit('flash', 'Dossier ['.$this->numInscrit.'] reçu avec succées !', 'success');
            $this->dispatchBrowserEvent('end-submit');
            $this->resetData();

        } catch (Exception $e) {
            return $this->emit('flash', $e, 'error');
        }
    }

    public function submit($deleteNum)
    {

        if ($this->selectedLevel != "M2R")
            $this->validate([
                'nom' => 'required',
                'anneeUnivers' => 'required',
                'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1','unique:bordereaus,referenceBrd2'],
                'montantBrd1' => 'required',
                'dateBrd1' => 'required:date',
                'agenceBrd1' => 'required',
                'centreExamen' => 'required',
                'email' => 'email',
                'statut' => 'required',
            ]);
        if ($this->selectedLevel == "M2R")
            $this->validate([
                'nom' => 'required',
                'anneeUnivers' => 'required',
                'referenceBrd1' => ['required', 'unique:bordereaus,referenceBrd1','unique:bordereaus,referenceBrd2'],
                'montantBrd1' => 'required',
                'dateBrd1' => 'required:date',
                'agenceBrd1' => 'required',
                'email' => 'email',
                'statut' => 'required',
            ]);

        $this->numInscrit = $this->generateNum();

        switch ($this->selectedLevel) {
            case "L1":
                $newStudent = new LicenceOne();
                break;
            case "L2":
                $newStudent = new LicenceTwo();
                break;
            case "L3":
                $newStudent = new LicenceThree();
                break;
            case "M1":
                $newStudent = new MasterOne();
                break;
            case "M2":
                $newStudent = new MasterTwo();
                break;
            case "M2R":
                $newStudent = new MasterRecherche();
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
        $this->idBrdE = $this->bordereau();
        try{
            $newStudent->numInscrit = $this->numInscrit;
            $newStudent->nom = $this->nom;
            $newStudent->prenom = $this->prenom;
            $newStudent->dateNaissance = $this->dateNaissance;
            $newStudent->lieuNaissance = $this->lieuNaissance;
            $newStudent->telCandidat = $this->telCandidat;
            $newStudent->cin = $this->cin;
            $newStudent->nationalite = $this->nationalite;
            $newStudent->anneeUnivers = $this->anneeUnivers;
            $newStudent->genre = $this->genre;
            if ($this->selectedLevel != 'M2R')
                $newStudent->centreExamen = $this->centreExamen;
            $newStudent->email = $this->email;
            $newStudent-> situationMat = $this->situationMat;
            $newStudent->profession = $this->profession;
            $newStudent->statut = $this->statut;
            $newStudent->RAD = $this->RAD;
            $newStudent->observation = $this->observation;
            $newStudent->idBrdE = $this->idBrdE;
            $newStudent->idDroitE = $this->idDroitE;
            if($this->selectedLevel === 'L3')
                $newStudent->idParcours = $this->parcours;
            if($this->selectedLevel === 'M2R')
                $newStudent->mention = $this->mention;


            $newStudent->save();

            $id = Admis::where('numInscrit', "{$deleteNum}")->value('idAdmis');
            Admis::destroy($id);

            if($newStudent->centreExamen === "Pas de centre"){
                $this->emit('flash', 'Certaines informations ne sont pas encore complète !', 'info');
                $this->dispatchBrowserEvent('end-submit');
            }
            else{
                $this->emit('flash', 'Etudiant(e) ['.$this->numInscrit.'] ajouté(e) avec succées !', 'success');
                $this->dispatchBrowserEvent('end-submit');
                $this->resetData();
            }
        } catch (Exception $e) {
            // delete bordereau if exist an error
            Bordereau::destroy($this->idBrdE);
            return $this->emit('flash', $e, 'error');
        }
    }

    public function bordereau()
    {
        $bordereau = Bordereau::create([
            'referenceBrd1' => $this->referenceBrd1,
            'montantBrd1' => $this->montantBrd1,
            'dateBrd1' => $this->dateBrd1,
            'agenceBrd1' => $this->agenceBrd1,
            'createdBy' => Auth()->user()->name,
        ]);
        return $bordereau->idBrd;
    }

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

        $candidats = Admis::where('niveau', '=', "{$niveau}")
            ->where(function($query) {
                $query->where('prenom', 'LIKE', "%{$this->search}%")
                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
            })
            ->orderBy('numInscrit')
            ->get();

        return view('livewire.liste-admis', [
            'candidats' => $candidats,
            'niveau' => $niveau
        ]);
    }
}
