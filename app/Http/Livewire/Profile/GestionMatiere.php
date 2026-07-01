<?php

namespace App\Http\Livewire\Profile;

use App\Models\ElementConstitutif;
use App\Models\UniteEnseignement;
use Livewire\Component;

class GestionMatiere extends Component
{
    public $niveau;
    public $idShow;
    public $idEditUE;
    public $tmp_design;
    public $tmp_poidUE;

    public $idEditMat;
    public $tmp_mat;
    public $tmp_poidMat;
    public $tmp_enseignant;
    public $tmp_parcours = 'Tronc commun';

    public $newUE;
    public $newUE_credit;
    public $newUE_session;
    public $newUE_niv;

    public $newMt;
    public $newMat_poid;
    public $newMat_prof;
    public $new_idUE;

    public $search;

    public $archive;
    public $year;
    public $searchField = 'ue';


    protected $listeners = [
        'finalDeleteUE' => 'finalDeleteUE',
        'finalDeleteMat' => 'finalDeleteMat',
    ];

    public function setYear()
    {
        $this->year = $this->year;
    }

    public function showMat($ue)
    {
        if ($this->idShow === $ue['idUE']){
            $this->idShow = 0;
        } else{
            $this->idShow = $ue['idUE'];
        }
    }

    public function editUE($ue)
    {
        if ($this->idEditUE === $ue['idUE']){
            $this->idEditUE = 0;
        } else{
            $this->idEditUE = $ue['idUE'];
            $this->tmp_design = $ue['designation'];
            $this->tmp_poidUE = $ue['credit'];
        }
    }

    public function submitUE_edit($id)
    {
        $this->validate([
            'tmp_design' => 'required',
            'tmp_poidUE' => 'required'
        ]);
        $ue = UniteEnseignement::find($id);
        $ue->designation = $this->tmp_design;
        $ue->credit = $this->tmp_poidUE;
        $ue->save();
        $this->idEditUE = 0;
    }

    public function deleteUE($ue)
    {
        $this->emit('modal', 'teste', 'deleteUE', $ue['idUE'], $ue['idUE']);
    }

    public function finalDeleteUE($id){
        $ue = UniteEnseignement::find($id);
        $ue->statut = 0;
        $ue->save();
    }

    public function deleteMat($id){
        $this->emit('modal', 'teste', 'deleteMat', $id, $id);
    }

    public function finalDeleteMat($id){
        $ec = ElementConstitutif::find($id);
        $ec->statut = 0;
        $ec->save();
    }

    public function editMat($ec)
    {
        if ($this->idEditMat === $ec['idMatiere']){
            $this->idEditMat = 0;
        } else{
            $this->idEditMat = $ec['idMatiere'];
            $this->tmp_mat = $ec['matiere'];
            $this->tmp_poidMat = $ec['poids'];
            $this->tmp_enseignant = $ec['enseignant'];
        }
    }

    public function submitMat_edit($id)
    {
        $this->validate([
            'tmp_mat' => 'required',
            'tmp_poidMat' => 'required'
        ]);
        $ec = ElementConstitutif::find($id);
        $ec->matiere = $this->tmp_mat;
        $ec->poids = $this->tmp_poidMat;
        $ec->enseignant = $this->tmp_enseignant;
        $ec->parcours = $this->tmp_parcours;
        $ec->save();
        $this->idEditMat = 0;
    }

    public function addUE()
    {
        if($this->newUE_niv === null)
        {
            if(Auth()->user()->role === "Licence"){
                $this->newUE_niv = "L1";
            }
            if(Auth()->user()->role === "Master"){
                $this->newUE_niv = "M1";
            }
        }
        $this->validate([
            'newUE' => 'required',
            'newUE_credit' => 'required|numeric',
            'newUE_session' => 'required',
            'newUE_niv' => 'required'
        ]);
        $currentUE = UniteEnseignement::create([
            'designation' => $this->newUE,
            'credit' => $this->newUE_credit,
            'niveau' => $this->newUE_niv,
            'session' => $this->newUE_session,
        ]);
        $this->emit('flash', 'Unité d\'enseignement ajoutée avec succès', 'success');
        $this->reset();
    }

    public function addMat($id)
    {
        if (is_string($id)) {
            $idArray = json_decode($id, true);
            if (isset($idArray['idUE'])) {
                $this->new_idUE = $idArray['idUE'];
            }
        }

        $this->validate([
            'newMt' => 'required',
            'newMat_poid' => 'required',
        ]);

        ElementConstitutif::create([
            'matiere' => $this->newMt,
            'poids' => $this->newMat_poid,
            'idUE' => $this->new_idUE,
            'enseignant' => $this->newMat_prof
        ]);

        $this->emit('flash', 'Matière ajoutée avec succès', 'success');
        $this->newMat_prof = '';
        $this->newMat_poid = '';
        $this->newMt = '';
    }


    public function render()
    {
        $annees = UniteEnseignement::select('anneeUnivers')->distinct()->get();
        $niveau = $this->niveau ?? (Auth()->user()->role === "Licence" ? 'L1' : 'M1');

        if ($this->searchField === 'ue') {
            $ue = UniteEnseignement::with('element')
                ->where('niveau', '=', $niveau)
                ->where(function ($query) {
                    $query->where('designation', 'LIKE', "%{$this->search}%");
                });
        } else {
            $ue = UniteEnseignement::with('element')
                ->leftJoin('element_constitutifs', 'unite_enseignements.idUE', '=', 'element_constitutifs.idUE')
                ->where('niveau', '=', $niveau)
                ->where(function ($query) {
                    $query->where('element_constitutifs.matiere', 'LIKE', "%{$this->search}%");
                });
        }


        if ($this->archive) {
            $ue->where('unite_enseignements.anneeUnivers', '=', "{$this->year}");
        } else {
            $ue->where('unite_enseignements.statut', '=', 1);
        }

        $ue = $ue->get()->groupBy('idUE');


        return view('livewire.profile.gestion-matiere', [
            'ue' => $ue,
            'annees' => $annees,
        ]);
    }

}
