<?php

namespace App\Http\Livewire\Profile;

ini_set('max_execution_time', 0);

use App\Http\Controllers\Export\ExporterController;
use App\Http\Livewire\Preselection;
use App\Models\Archives\ArchiveCandidatL1;
use App\Models\Archives\ArchiveCandidatM1;
use App\Models\Archives\ArchiveCandidatM2;
use App\Models\Archives\ArchiveL1;
use App\Models\Archives\ArchiveL2;
use App\Models\Archives\ArchiveL3;
use App\Models\Archives\ArchiveM1;
use App\Models\Archives\ArchiveM2;
use App\Models\Archives\ArchiveMR;
use App\Models\Archives\ArchiveNote;
use App\Models\Archives\ArchiveNoteL1;
use App\Models\Archives\ArchiveNoteL2;
use App\Models\Archives\ArchiveNoteL3;
use App\Models\Archives\ArchiveNoteM1;
use App\Models\Archives\ArchiveNoteM2;
use App\Models\Archives\ArchiveNoteMRS;
use App\Models\Bordereau;
use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Candidats\CandidatM2;
use App\Models\Candidats\CandidatM2R;
use App\Models\Notes\Note;
use App\Models\Notes\NoteL1;
use App\Models\Notes\NoteL2;
use App\Models\Notes\NoteL3;
use App\Models\Notes\NoteM1;
use App\Models\Notes\NoteM2;
use App\Models\Notes\NoteMR;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterRecherche;
use App\Models\Students\MasterTwo;
use App\Models\UniteEnseignement;
use http\Env\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class GestionArchive extends Component
{
    public $selectedLevel;
    public $niveauCdt;

    protected $listeners = [
        'archiveCdt' => 'archiveCandidat',
    ];
    public function render()
    {
        return view('livewire.profile.gestion-archive');
    }

    public function writtingArchive()
    {
        switch($this->selectedLevel){
            case "L1":
                $this->archiveL1();
                break;
            case "L2":
                $this->archiveL2();
                break;
            case "L3":
                $this->archiveL3();
                break;
            case "M1":
                $this->archiveM1();
                break;
            case "M2":
                $this->archiveM2();
                break;
            case "M2R":
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->archiveL1();
                }
                if(Auth()->user()->role === "Master"){
                    $this->archiveM1();
                }
                break;
        }
    }

    public function archiveL1()
    {
        $lastData = LicenceOne::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'centreExamen', 'email', 'situationMat', 'profession', 'statut', 'RAD', 'observation', 'idBrdE'])->get();
        ArchiveL1::insert($lastData->toArray());
        $lastNote = NoteL1::all();
        if (!empty($lastNote)){
            foreach($lastNote as $note){
                $idArchiveEtd = ArchiveL1::where('numInscrit', '=', $note->numInscrit)->first()->idEtd;

                $newNote = ArchiveNote::create([
                    'noteSN' => $note->note->noteSN,
                    'noteSR' => $note->note->noteSR,
                    'annee' => $note->note->annee,
                    'createdBy' => $note->note->createdBy,
                    'updatedBy' => $note->note->updatedBy,
                ]);
                $newIdNote = $newNote->idNote;

                ArchiveNoteL1::create([
                    'numInscrit' => $note->numInscrit,
                    'idNote' => $newIdNote,
                    'idMatiereN' => $note->idMatiereN,
                    'idEtdN' => $idArchiveEtd,
                ]);

                $DeleteIdNote = $note->idNote;
                $note->delete();
                Note::destroy($DeleteIdNote);
            }
        }

        $ueRecords = UniteEnseignement::where('statut', '=', 1)
            ->where('niveau', '=', 'L1')
            ->get();

        foreach ($ueRecords as $ue) {
            $ue->update([
                'statut' => 0,
                'anneeUnivers' => $lastData->first()->anneeUnivers,
            ]);
        }

        Schema::table('note_l1_s', function (Blueprint $table) {
            $table->dropForeign('note_l1_s_idetdn_foreign');
        });

        LicenceOne::truncate();

        Schema::table('note_l1_s', function (Blueprint $table) {
            $table->foreign('idEtdN')->references('idEtd')->on('licence_ones');
        });

        $this->emit('flash', 'Archive effectué avec succès! ', 'success');
    }

    public function archiveL2()
    {
        $lastData = LicenceTwo::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'centreExamen', 'email', 'situationMat', 'profession', 'statut', 'RAD', 'observation', 'idBrdE'])->get();
        ArchiveL2::insert($lastData->toArray());
        $lastNote = NoteL2::all();

        if (!empty($lastNote)){
            foreach($lastNote as $note){
                $idArchiveEtd = ArchiveL2::where('numInscrit', '=', $note->numInscrit)->first()->idEtd;

                $newNote = ArchiveNote::create([
                    'noteSN' => $note->note->noteSN,
                    'noteSR' => $note->note->noteSR,
                    'annee' => $note->note->annee,
                    'createdBy' => $note->note->createdBy,
                    'updatedBy' => $note->note->updatedBy,
                ]);
                $newIdNote = $newNote->idNote;

                ArchiveNoteL2::create([
                    'numInscrit' => $note->numInscrit,
                    'idNote' => $newIdNote,
                    'idMatiereN' => $note->idMatiereN,
                    'idEtdN' => $idArchiveEtd,
                ]);

                $DeleteIdNote = $note->idNote;
                $note->delete();
                Note::destroy($DeleteIdNote);
            }
        }

        $ueRecords = UniteEnseignement::where('statut', '=', 1)
            ->where('niveau', '=', 'L2')
            ->get();

        foreach ($ueRecords as $ue) {
            $ue->update([
                'statut' => 0,
                'anneeUnivers' => $lastData->first()->anneeUnivers,
            ]);
        }

        Schema::table('note_l2_s', function (Blueprint $table) {
            $table->dropForeign('note_l2_s_idetdn_foreign');
        });

        LicenceTwo::truncate();

        Schema::table('note_l2_s', function (Blueprint $table) {
            $table->foreign('idEtdN')->references('idEtd')->on('licence_twos');
        });

        $this->emit('flash', 'Archive effectué avec succès! ', 'success');
    }

    public function archiveL3()
    {
        $lastData = LicenceThree::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'centreExamen', 'email', 'situationMat', 'profession', 'statut', 'RAD', 'observation', 'idBrdE', 'idParcours', 'idDroitE'])->get();
        ArchiveL3::insert($lastData->toArray());
        $lastNote = NoteL3::all();

        foreach($lastNote as $note){
            $idArchiveEtd = ArchiveL3::where('numInscrit', '=', $note->numInscrit)->first()->idEtd;

            $newNote = ArchiveNote::create([
                'noteSN' => $note->note->noteSN,
                'noteSR' => $note->note->noteSR,
                'annee' => $note->note->annee,
                'createdBy' => $note->note->createdBy,
                'updatedBy' => $note->note->updatedBy,
            ]);
            $newIdNote = $newNote->idNote;

            ArchiveNoteL3::create([
                'numInscrit' => $note->numInscrit,
                'idNote' => $newIdNote,
                'idMatiereN' => $note->idMatiereN,
                'idEtdN' => $idArchiveEtd,
            ]);

            $DeleteIdNote = $note->idNote;
            $note->delete();
            Note::destroy($DeleteIdNote);
        }

        $ueRecords = UniteEnseignement::where('statut', '=', 1)
            ->where('niveau', '=', 'L3')
            ->get();

        foreach ($ueRecords as $ue) {
            $ue->update([
                'statut' => 0,
                'anneeUnivers' => $lastData->first()->anneeUnivers,
            ]);
        }

        Schema::table('note_l3_s', function (Blueprint $table) {
            $table->dropForeign('note_l3_s_idetdn_foreign');
        });

        LicenceThree::truncate();

        Schema::table('note_l3_s', function (Blueprint $table) {
            $table->foreign('idEtdN')->references('idEtd')->on('licence_threes');
        });

        $this->emit('flash', 'Archive effectué avec succès! ', 'success');

    }

    public function archiveM1()
    {
        $lastData = MasterOne::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'centreExamen', 'email', 'situationMat', 'profession', 'statut', 'RAD', 'observation', 'idBrdE'])->get();
        ArchiveM1::insert($lastData->toArray());
        $lastNote = NoteM1::all();

        if (!empty($lastNote)){
            foreach ($lastNote as $note) {
                $idArchiveEtd = ArchiveM1::where('numInscrit', '=', $note->numInscrit)->first()->idEtd;

                $newNote = ArchiveNote::create([
                    'noteSN' => $note->note->noteSN,
                    'noteSR' => $note->note->noteSR,
                    'annee' => $note->note->annee,
                    'createdBy' => $note->note->createdBy,
                    'updatedBy' => $note->note->updatedBy,
                ]);
                $newIdNote = $newNote->idNote;

                ArchiveNoteM1::create([
                    'numInscrit' => $note->numInscrit,
                    'idNote' => $newIdNote,
                    'idMatiereN' => $note->idMatiereN,
                    'idEtdN' => $idArchiveEtd,
                ]);

                $DeleteIdNote = $note->idNote;
                $note->delete();
                Note::destroy($DeleteIdNote);
            }
        }

        $ueRecords = UniteEnseignement::where('statut', '=', 1)
            ->where('niveau', '=', 'M1')
            ->get();

        foreach ($ueRecords as $ue) {
            $ue->update([
                'statut' => 0,
                'anneeUnivers' => $lastData->first()->anneeUnivers,
            ]);
        }

        Schema::table('note_m1_s', function (Blueprint $table) {
            $table->dropForeign('note_m1_s_idetdn_foreign');
        });

        MasterOne::truncate();

        Schema::table('note_m1_s', function (Blueprint $table) {
            $table->foreign('idEtdN')->references('idEtd')->on('master_ones');
        });

        $this->emit('flash', 'Archive effectué avec succès! ', 'success');

    }

    public function archiveM2()
    {
        $lastData = MasterTwo::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'centreExamen', 'email', 'situationMat', 'profession', 'statut', 'RAD', 'observation', 'idBrdE'])->get();
        ArchiveM2::insert($lastData->toArray());
        $lastNote = NoteM2::all();

        if (!empty($lastNote)) {
            foreach ($lastNote as $note) {
                $idArchiveEtd = ArchiveM2::where('numInscrit', '=', $note->numInscrit)->first()->idEtd;

                $newNote = ArchiveNote::create([
                    'noteSN' => $note->note->noteSN,
                    'noteSR' => $note->note->noteSR,
                    'annee' => $note->note->annee,
                    'createdBy' => $note->note->createdBy,
                    'updatedBy' => $note->note->updatedBy,
                ]);
                $newIdNote = $newNote->idNote;

                ArchiveNoteM2::create([
                    'numInscrit' => $note->numInscrit,
                    'idNote' => $newIdNote,
                    'idMatiereN' => $note->idMatiereN,
                    'idEtdN' => $idArchiveEtd,
                ]);

                $DeleteIdNote = $note->idNote;
                $note->delete();
                Note::destroy($DeleteIdNote);
            }
        }

        $ueRecords = UniteEnseignement::where('statut', '=', 1)
            ->where('niveau', '=', 'M2')
            ->get();

        foreach ($ueRecords as $ue) {
            $ue->update([
                'statut' => 0,
                'anneeUnivers' => $lastData->first()->anneeUnivers,
            ]);
        }

        Schema::table('note_m2_s', function (Blueprint $table) {
            $table->dropForeign('note_m2_s_idetdn_foreign');
        });

        MasterTwo::truncate();

        Schema::table('note_m2_s', function (Blueprint $table) {
            $table->foreign('idEtdN')->references('idEtd')->on('master_twos');
        });

        $this->emit('flash', 'Archive effectué avec succès! ', 'success');

    }

    public function archiveM2R()
    {
        $lastData = MasterRecherche::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'centreExamen', 'email', 'situationMat', 'profession', 'statut', 'RAD', 'observation', 'idBrdE'])->get();
        ArchiveMR::insert($lastData->toArray());
        $lastNote = NoteMR::all();

        if (!empty($lastNote)) {
            foreach ($lastNote as $note) {
                $idArchiveEtd = ArchiveMR::where('numInscrit', '=', $note->numInscrit)->first()->idEtd;

                $newNote = ArchiveNote::create([
                    'noteSN' => $note->note->noteSN,
                    'noteSR' => $note->note->noteSR,
                    'annee' => $note->note->annee,
                    'createdBy' => $note->note->createdBy,
                    'updatedBy' => $note->note->updatedBy,
                ]);
                $newIdNote = $newNote->idNote;

                ArchiveNoteMRS::create([
                    'numInscrit' => $note->numInscrit,
                    'idNote' => $newIdNote,
                    'idMatiereN' => $note->idMatiereN,
                    'idEtdN' => $idArchiveEtd,
                ]);

                $DeleteIdNote = $note->idNote;
                $note->delete();
                Note::destroy($DeleteIdNote);
            }
        }

        $ueRecords = UniteEnseignement::where('statut', '=', 1)
            ->where('niveau', '=', 'M2R')
            ->get();

        foreach ($ueRecords as $ue) {
            $ue->update([
                'statut' => 0,
                'anneeUnivers' => $lastData->first()->anneeUnivers,
            ]);
        }

        Schema::table('note_m_r_s', function (Blueprint $table) {
            $table->dropForeign('note_m_r_s_idetdn_foreign');
        });

        MasterRecherche::truncate();

        Schema::table('note_m_r_s', function (Blueprint $table) {
            $table->foreign('idEtdN')->references('idEtd')->on('master_recherches');
        });

        $this->emit('flash', 'Archive effectué avec succès! ', 'success');

    }

    public function confirmArchiveCdt()
    {
        $this->emit('modal', 'teste', 'archiveCdt', null, null);
    }

    public function archiveCandidat()
    {
        switch ($this->niveauCdt)
        {
            case "L1":
                $this->archiveCandidatL1();
                break;
            case "M1":
                $this->archiveCandidatM1();
                break;
            case "M2":
                $this->archiveCandidatM2();
                break;
            case "M2R":
                $this->archiveCandidatM2R();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->archiveCandidatL1();
                }
                if(Auth()->user()->role === "Master"){
                    $this->archiveCandidatM1();
                }
        }
    }

    private function deleteBrd($array){
        // divise le tableau en 4 sous tableaux
        if(count($array) > 0){
            $parts = array_chunk($array, ceil(count($array) / 4));;
            for($i = 0; $i < count($parts); $i++){
                Bordereau::destroy($parts[$i]);
            }
            $this->emit('flash', 'Suppression effectué avec succès! ', 'success');
        }else{
            $this->emit('flash', 'Aucun candidat à supprimer! ', 'error');
        }
    }

    public function archiveCandidatL1()
    {
        $lastData = CandidatL::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'serieBacc', 'anneeBacc', 'mentionBacc', 'observation', 'idBrdC'])->get();
        ArchiveCandidatL1::insert($lastData->toArray());
        CandidatL::truncate();
    }

    public function archiveCandidatM1()
    {
        $lastData = CandidatM::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'parcours', 'universite', 'centreExamen', 'statut', 'etablissement', 'email', 'profession', 'situationMat', 'observation', 'idBrdC'])->get();
        ArchiveCandidatM1::insert($lastData->toArray());
        CandidatM::truncate();
    }

    public function archiveCandidatM2()
    {
        $lastData = CandidatM2::select(['numInscrit', 'nom', 'prenom', 'dateNaissance', 'lieuNaissance', 'telCandidat', 'cin', 'nationalite', 'anneeUnivers', 'genre', 'parcours', 'universite', 'centreExamen', 'statut', 'etablissement', 'email', 'profession', 'situationMat', 'observation', 'idBrdC'])->get();
        ArchiveCandidatM2::insert($lastData->toArray());
        CandidatM2::truncate();
    }

    public function archiveCandidatM2R()
    {
        $tmp = CandidatM2R::select('idBrdC')->get()->toArray();
        CandidatM2R::truncate();
        DB::statement('ALTER TABLE candidat_m2_r_s AUTO_INCREMENT = 1');
        $this->deleteBrd($tmp);
    }
}
