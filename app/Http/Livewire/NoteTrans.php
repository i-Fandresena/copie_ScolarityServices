<?php

namespace App\Http\Livewire;

set_time_limit(0);

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
use App\Models\ElementConstitutif;
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
use Livewire\Component;
use Livewire\Event;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\SimpleExcel\SimpleExcelReader;

class NoteTrans extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';
    public string $niveau = '';
    public string $designation = '';
    public $id_ue;
    public $selectedUE;
    public $selectedEC;
    public $id_ec;
    public $note;
    public $numSelect;
    public $session = 'SN';

    public $year;
    public $archive;

//   import
    public $excelFile;


    protected $listeners = [
        'deleteNote' => 'deleteNote',
        'updateNote' => 'updateNote',
        'UpdateImport' => 'UpdateImport',
    ];

    protected $queryString = [
        'search' => ['except' => '']
    ];

    // function to seach from table students
    public function updatingSearch(){
        $this->resetPage();
    }

    public function updatingNiveau(){
        $this->resetPage();
    }

    public function updatingArchive()
    {
        $this->resetPage();
    }

    public function setYear()
    {
        $this->year = $this->year;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'note' => 'numeric',
        ]);
    }

    private function insertNote($note, $numInscrit)
    {
        if($this->archive){
            switch ($this->niveau){
                case "L1":
                    $annee = ArchiveL1::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L2":
                    $annee = ArchiveL2::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L3":
                    $annee = ArchiveL3::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M1":
                    $annee = ArchiveM1::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2":
                    $annee = ArchiveM2::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2R":
                    $annee = ArchiveMR::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
            }
            $note = ArchiveNote::create([
                'noteSN' => $note,
                'niveau' => $this->niveau,
                'annee' => $annee,
                'createdBy' => Auth()->user()->name . ' ' . Auth()->user()->prenom,
            ]);
            return $note->idNote;
        }else{
            switch ($this->niveau){
                case "L1":
                    $annee = LicenceOne::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L2":
                    $annee = LicenceTwo::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L3":
                    $annee = LicenceThree::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M1":
                    $annee = MasterOne::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2":
                    $annee = MasterTwo::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2R":
                    $annee = MasterRecherche::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
            }
            $note = Note::create([
                'noteSN' => $note,
                'niveau' => $this->niveau,
                'annee' => $annee,
                'createdBy' => Auth()->user()->name . ' ' . Auth()->user()->prenom,
            ]);
            return $note->idNote;
        }
    }

    private function insertSR($note, $numInscrit)
    {
        if ($this->archive){
            switch ($this->niveau){
                case "L1":
                    $annee = ArchiveL1::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L2":
                    $annee = ArchiveL2::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L3":
                    $annee = ArchiveL3::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M1":
                    $annee = ArchiveM1::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2":
                    $annee = ArchiveM2::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2R":
                    $annee = ArchiveMR::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
            }
            $note = ArchiveNote::create([
                'noteSR' => $note,
                'niveau' => $this->niveau,
                'annee' => $annee,
                'createdBy' => Auth()->user()->name . ' ' . Auth()->user()->prenom,
            ]);
            return $note->idNote;
        }else{
            switch ($this->niveau){
                case "L1":
                    $annee = LicenceOne::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L2":
                    $annee = LicenceTwo::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "L3":
                    $annee = LicenceThree::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M1":
                    $annee = MasterOne::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2":
                    $annee = MasterTwo::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
                case "M2R":
                    $annee = MasterRecherche::where('numInscrit', $numInscrit)->first()->anneeUnivers;
                    break;
            }
            $note = Note::create([
                'noteSR' => $note,
                'niveau' => $this->niveau,
                'annee' => $annee,
                'createdBy' => Auth()->user()->name . ' ' . Auth()->user()->prenom,
            ]);
            return $note->idNote;
        }
    }

    public function setNumSelect($num){
        $this->numSelect = $num;
    }

    public function render()
    {
//      vider le formulaire a chaque changement
        $this->reset(['note']);
        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
        if($this->archive)
        {
            switch ($this->niveau) {
                case "L1":
                    $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL1::with('note', 'note.note', 'note.matiere')
                        ->where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);

                    $ue = UniteEnseignement::where('niveau', 'L1')->where('anneeUnivers', '=', "{$this->year}")->get();
                    $UE = UniteEnseignement::where('niveau', 'L1')->where('anneeUnivers', '=', "{$this->year}")->get();
                    break;
                case "L2":
                    $annees = ArchiveL2::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL2::with('note', 'note.note', 'note.matiere')
                        ->where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'L2')->where('anneeUnivers', '=', "{$this->year}")->get();
                    $UE = UniteEnseignement::where('niveau', 'L2')->where('anneeUnivers', '=', "{$this->year}")->get();
                    break;
                case "L3":
                    $annees = ArchiveL3::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveL3::with('note', 'note.note', 'note.matiere')
                        ->where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'L3')->where('anneeUnivers', '=', "{$this->year}")->get();
                    $UE = UniteEnseignement::where('niveau', 'L3')->where('anneeUnivers', '=', "{$this->year}")->get();
                    break;
                case "M1":
                    $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveM1::with('note', 'note.note', 'note.matiere')
                        ->where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    break;
                case "M2":
                    $annees = ArchiveM2::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveM2::with('note', 'note.note', 'note.matiere')
                        ->where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'M2')->where('anneeUnivers', '=', "{$this->year}")->get();
                    $UE = UniteEnseignement::where('niveau', 'M2')->where('anneeUnivers', '=', "{$this->year}")->get();
                    break;
                case "MR":
                    $annees = ArchiveMR::select('anneeUnivers')->distinct()->get();
                    $students = ArchiveMR::with('note', 'note.note', 'note.matiere')
                        ->where('anneeUnivers', '=', "{$this->year}")
                        ->where(function($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'M2')->where('anneeUnivers', '=', "{$this->year}")->get();
                    $UE = UniteEnseignement::where('niveau', 'M2')->where('anneeUnivers', '=', "{$this->year}")->get();
                    break;
                default:
                    if(Auth()->user()->role === "Licence"){
                        $annees = ArchiveL1::select('anneeUnivers')->distinct()->get();
                        $students = ArchiveL1::with('note', 'note.note', 'note.matiere')
                            ->where('anneeUnivers', '=', "{$this->year}")
                            ->where(function($query) {
                                if (!empty($this->search)) {
                                    $query->where('prenom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                                }
                            })
                            ->orderBy('numInscrit')
                            ->paginate(5);
                        $ue = UniteEnseignement::where('niveau', 'L1')->where('anneeUnivers', '=', "{$this->year}")->get();
                        $UE = UniteEnseignement::where('niveau', 'L1')->where('anneeUnivers', '=', "{$this->year}")->get();
                    }
                    if(Auth()->user()->role === "Master"){
                        $annees = ArchiveM1::select('anneeUnivers')->distinct()->get();
                        $students = ArchiveM1::with('note', 'note.note', 'note.matiere')
                            ->where('anneeUnivers', '=', "{$this->year}")
                            ->where(function($query) {
                                if (!empty($this->search)) {
                                    $query->where('prenom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                                }
                            })
                            ->orderBy('numInscrit')
                            ->paginate(5);
                        $ue = UniteEnseignement::where('niveau', 'M1')->where('anneeUnivers', '=', "{$this->year}")->get();
                        $UE = UniteEnseignement::where('niveau', 'M1')->where('anneeUnivers', '=', "{$this->year}")->get();
                    }
            }
        } else{
            switch ($this->niveau) {
                case "L1":
                    $students = LicenceOne::with('note', 'note.note', 'note.matiere')
                        ->where(function ($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                    break;
                case "L2":
                    $students = LicenceTwo::with('note', 'note.note', 'note.matiere')
                        ->where(function ($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'L2')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'L2')->where('statut', 1)->get();
                    break;
                case "L3":
                    $students = LicenceThree::with('note', 'note.note', 'note.matiere')
                        ->where(function ($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'L3')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'L3')->where('statut', 1)->get();
                    break;
                case "M1":
                    $students = MasterOne::with('note', 'note.note', 'note.matiere')
                        ->where(function ($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    break;
                case "M2":
                    $students = MasterTwo::with('note', 'note.note', 'note.matiere')
                        ->where(function ($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'M2')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'M2')->where('statut', 1)->get();
                    break;
                case "MR":
                    $students = MasterRecherche::with('note', 'note.note', 'note.matiere')
                        ->where(function ($query) {
                            if (!empty($this->search)) {
                                $query->where('prenom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                    ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                            }
                        })
                        ->orderBy('numInscrit')
                        ->paginate(5);
                    $ue = UniteEnseignement::where('niveau', 'M2')->where('statut', 1)->get();
                    $UE = UniteEnseignement::where('niveau', 'M2')->where('statut', 1)->get();
                    break;
                default:
                    if(Auth()->user()->role === "Licence"){
                        $students = LicenceOne::with('note', 'note.note', 'note.matiere')
                            ->where(function ($query) {
                                if (!empty($this->search)) {
                                    $query->where('prenom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                                }
                            })
                            ->orderBy('numInscrit')
                            ->paginate(5);
                        $ue = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                        $UE = UniteEnseignement::where('niveau', 'L1')->where('statut', 1)->get();
                    }
                    if(Auth()->user()->role === "Master"){
                        $students = MasterOne::with('note', 'note.note', 'note.matiere')
                            ->where(function ($query) {
                                if (!empty($this->search)) {
                                    $query->where('prenom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('nom', 'LIKE', "%{$this->search}%")
                                        ->orWhere('numInscrit', 'LIKE', "%{$this->search}%");
                                }
                            })
                            ->orderBy('numInscrit')
                            ->paginate(5);
                        $ue = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                        $UE = UniteEnseignement::where('niveau', 'M1')->where('statut', 1)->get();
                    }
            }
        }
        $ec = ElementConstitutif::where('idUE', $this->id_ue)->where('statut', 1)->get();
        $this->selectedUE = UniteEnseignement::find($this->id_ue);
        $this->selectedEC = ElementConstitutif::find($this->id_ec);

        return view('livewire.note-trans', [
            'students' => $students,
            'ue' => $ue,
            'ec' => $ec,
            'UE' => $UE,
            'annees' => $annees,
        ]);
    }

//*********************************************************************************************************
//**************************VERIFICATION IMPORT************************************************************
//*********************************************************************************************************

    public function verifyImport(){
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        switch ($this->niveau) {
            case "L1":
                if ($this->archive) $this->verifyArchiveL1();
                else $this->verifyL1();
                break;
            case "L2":
                if ($this->archive) $this->verifyArchiveL2();
                else $this->verifyL2();
                break;
            case "L3":
                if ($this->archive) $this->verifyArchiveL3();
                else $this->verifyL3();
                break;
            case "M1":
                if ($this->archive) $this->verifyArchiveM1();
                else $this->verifyM1();
                break;
            case "M2":
                if ($this->archive) $this->verifyArchiveM2();
                else $this->verifyM2();
                break;
            case "M2R":
                if ($this->archive) $this->verifyArchiveM2R();
                else $this->verifyM2R();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    if ($this->archive) $this->verifyArchiveL1();
                    else $this->verifyL1();
                }
                if(Auth()->user()->role === "Master"){
                    if ($this->archive) $this->verifyArchiveM1();
                    else $this->verifyM1();
                }
        }
    }

    private function verifyL1(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = NoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = NoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                        ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyArchiveL1(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = ArchiveNoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = ArchiveNoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyL2(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = NoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = NoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                        ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyArchiveL2(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = ArchiveNoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = ArchiveNoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyL3(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = NoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = NoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                        ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyArchiveL3(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = ArchiveNoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = ArchiveNoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyM1(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = NoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = NoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                        ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyArchiveM1(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = ArchiveNoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = ArchiveNoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyM2(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = NoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = NoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                        ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyArchiveM2(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = ArchiveNoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = ArchiveNoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyM2R(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = NoteMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = NoteMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                        ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

    private function verifyArchiveM2R(): void
    {
        if ($this->session === 'SN')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = 0;
            foreach ($data as $row) {
                $verify = ArchiveNoteMRS::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->count();
                if ($verify > 0) {
                    break;
                }
            }
            if ($verify > 0) {
                $this->emit('modalExcel', 'confirm');
            }
            if ($verify <= 0) {
                $this->import();
            }
        }
        elseif ($this->session === 'SR')
        {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            $verify = false;
            foreach ($data as $row) {
                $noteExistant = ArchiveNoteMRS::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                    ->where('idMatiereN', $this->id_ec)->with('note')->first();
                if ($noteExistant) {
                    if ($noteExistant->note->noteSR !== null) {
                        $verify = true;
                        break;
                    }
                }
            }
            if ($verify) {
                $this->emit('modalExcel', 'confirm');
            } else {
                $this->import();
            }
        }
    }

//*********************************************************************************************************
//**************************FIN VERIFICATION IMPORT********************************************************
//*********************************************************************************************************



//**********************************************************************************************************
//**************************************IMPORT DATA FROM EXCEL FILE*****************************************
//**********************************************************************************************************

    public function import(): void
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        switch ($this->niveau) {
            case "L1":
                if ($this->archive) $this->importArchiveL1();
                else $this->importL1();
                break;
            case "L2":
                if ($this->archive) $this->importArchiveL2();
                else $this->importL2();
                break;
            case "L3":
                if ($this->archive) $this->importArchiveL3();
                else $this->importL3();
                break;
            case "M1":
                if ($this->archive) $this->importArchiveM1();
                else $this->importM1();
                break;
            case "M2":
                if ($this->archive) $this->importArchiveM2();
                else $this->importM2();
                break;
            case "M2R":
                if ($this->archive) $this->importArchiveM2R();
                else $this->importM2R();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->niveau = "L1";
                    if ($this->archive) $this->importArchiveL1();
                    else $this->importL1();
                }
                if(Auth()->user()->role === "Master"){
                    $this->niveau = "M1";
                    if ($this->archive) $this->importArchiveM1();
                    else $this->importM1();
                }
                break;
        }
    }

    private function importL1(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        NoteL1::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => LicenceOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = NoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importArchiveL1()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        ArchiveNoteL1::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => ArchiveL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = ArchiveNoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importL2(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        NoteL2::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => LicenceTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = NoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importArchiveL2()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        ArchiveNoteL2::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => ArchiveL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = ArchiveNoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importL3(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        NoteL3::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => LicenceThree::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = NoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL3::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceThree::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        ArchiveNoteL3::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => ArchiveL3::where('numInscrit', $row['Numero'])->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = ArchiveNoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL3::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importM1(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        NoteM1::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => MasterOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = NoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteM1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        ArchiveNoteM1::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => ArchiveM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = ArchiveNoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteM1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importM2(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        NoteM2::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => MasterTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = NoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteM2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        ArchiveNoteM2::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => ArchiveM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = ArchiveNoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteM2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importM2R(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        NoteMR::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => MasterRecherche::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = NoteMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteMR::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterRecherche::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function importArchiveM2R()
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN'){
                    if (is_numeric($row[$this->selectedEC->matiere])){
                        $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                        ArchiveNoteMRS::create([
                            'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                            'idNote' => $currentIdNote,
                            'idMatiereN' => $this->id_ec,
                            'idEtdN' => ArchiveMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                        ]);
                    }
                } elseif ($this->session === 'SR'){
                    $noteExistant = ArchiveNoteMRS::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteMRS::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

//**********************************************************************************************************
//**************************************END IMPORT DATA FROM EXCEL FILE*************************************
//**********************************************************************************************************


//**********************************************************************************************************
//**************************************UPDATE DATA FROM EXCEL FILE*****************************************
//**********************************************************************************************************

    public function UpdateImport(){
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        switch ($this->niveau) {
            case "L1":
                if ($this->archive) $this->updateImportArchiveL1();
                else $this->updateImportL1();
                break;
            case "L2":
                if ($this->archive) $this->updateImportArchiveL2();
                else $this->updateImportL2();
                break;
            case "L3":
                if ($this->archive) $this->updateImportArchiveL3();
                else $this->updateImportL3();
                break;
            case "M1":
                if ($this->archive) $this->updateImportArchiveM1();
                else $this->updateImportM1();
                break;
            case "M2":
                if ($this->archive) $this->updateImportArchiveM2();
                else $this->updateImportM2();
                break;
            case "M2R":
                if ($this->archive) $this->updateImportArchiveM2R();
                else $this->updateImportM2R();
                break;
            default:
                if(Auth()->user()->role === "Licence"){
                    $this->niveau = "L1";
                    if ($this->archive) $this->updateImportArchiveL1();
                    else $this->updateImportL1();
                }
                if(Auth()->user()->role === "Master"){
                    $this->niveau = "M1";
                    if ($this->archive) $this->updateImportArchiveM1();
                    else $this->updateImportM1();
                }
                break;
        }
    }

    private function updateImportL1(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = NoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = NoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportArchiveL1(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = ArchiveNoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = ArchiveNoteL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportL2(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = NoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = NoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportArchiveL2(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = ArchiveNoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = ArchiveNoteL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportL3(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = NoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL3::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceThree::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = NoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteL3::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => LicenceThree::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportArchiveL3(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = ArchiveNoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL3::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = ArchiveNoteL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteL3::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveL3::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportM1(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = NoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteM1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = NoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteM1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterOne::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportArchiveM1(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = ArchiveNoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteM1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = ArchiveNoteM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteM1::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveM1::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportM2(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = NoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteM2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = NoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteM2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterTwo::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportArchiveM2(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = ArchiveNoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteM2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = ArchiveNoteM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteM2::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveM2::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportM2R(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = NoteMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteMR::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterRecherche::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = NoteMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                                            ->where('idMatiereN', $this->id_ec)
                                            ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            NoteMR::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => MasterRecherche::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

    private function updateImportArchiveM2R(): void
    {
        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());
            $rows = $reader->getRows();
            $data = $rows->toArray();
            foreach ($data as $row) {
                if($this->session === 'SN')
                {
                    $noteExistant = ArchiveNoteMRS::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSN = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertNote($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteMRS::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
                }
                elseif ($this->session === 'SR')
                {
                    $noteExistant = ArchiveNoteMRS::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))
                        ->where('idMatiereN', $this->id_ec)
                        ->with('note')->first();

                    if ($noteExistant){
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $noteExistant->note->noteSR = $row[$this->selectedEC->matiere];
                            $noteExistant->note->save();
                        }
                    } else{
                        if (is_numeric($row[$this->selectedEC->matiere])){
                            $currentIdNote = $this->insertSR($row[$this->selectedEC->matiere], preg_replace('/\s+/', '',strval($row['Numero'])));
                            ArchiveNoteMRS::create([
                                'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                                'idNote' => $currentIdNote,
                                'idMatiereN' => $this->id_ec,
                                'idEtdN' => ArchiveMR::where('numInscrit', preg_replace('/\s+/', '',strval($row['Numero'])))->first()->idEtd,
                            ]);
                        }
                    }
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

//**********************************************************************************************************
//**************************************END UPDATE DATA FROM EXCEL FILE*************************************
//**********************************************************************************************************



//*********************************************************************************************************
//*********************VERIFICATION SI NOTE EXISTE*********************************************************
//*********************************************************************************************************

    private function checkIfValide($note): bool {
        if(intval($note) >= 0 and intval($note) <= 20)
            return true;
        else
            return false;
    }

    public function noteValidation($studentArray)
    {
        $studentJSON = json_encode($studentArray);
        $student = json_decode($studentJSON);

        $this->validate([
            'note' => 'required|numeric',
            'id_ue' => 'required',
            'id_ec' => 'required',
        ]);

        if(!$this->checkIfValide($this->note)){
            return $this->emit('flash', 'La note doit être comprise entre 0 et 20.', 'error');
        }

        switch ($this->niveau) {
            case "L1":
                $this->validationL1($student);
                break;

            case "L2":
                $this->validationL2($student);
                break;

            case "L3":
                $this->validationL3($student);
                break;

            case "M1":
                $this->validationM1($student);
                break;

            case "M2":
                $this->validationM2($student);
                break;

            case "M2R":
                $this->validationM2R($student);
                break;

            default:
                if (Auth()->user()->role === "Licence") {
                    $this->niveau = 'L1';
                    $this->validationL1($student);
                }
                if (Auth()->user()->role === "Master") {
                    $this->niveau = 'M1';
                    $this->validationM1($student);
                }
        }
    }

    private function validationL1($student): void
    {
        if ($this->archive)
        {
            if ($this->session == 'SN') {
                $verify = ArchiveNoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = ArchiveNoteL1::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
        else
        {
            if ($this->session == 'SN') {
                $verify = NoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = NoteL1::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
    }

    private function validationL2($student): void
    {
        if ($this->archive)
        {
            if ($this->session == 'SN') {
                $verify = ArchiveNoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = ArchiveNoteL2::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
        else{
            if ($this->session == 'SN') {
                $verify = NoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = NoteL2::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
                    //$this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
    }

    private function validationL3($student): void
    {
        if ($this->archive)
        {
            if ($this->session == 'SN') {
                $verify = ArchiveNoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = ArchiveNoteL3::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
        else{
            if ($this->session == 'SN') {
                $verify = NoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = NoteL3::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
                    //$this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
    }

    private function validationM1($student): void
    {
        if ($this->archive)
        {
            if ($this->session == 'SN') {
                $verify = ArchiveNoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = ArchiveNoteM1::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
        else{
            if ($this->session == 'SN') {
                $verify = NoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = NoteM1::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
                    //$this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
    }

    private function validationM2($student): void
    {
        if ($this->archive)
        {
            if ($this->session == 'SN') {
                $verify = ArchiveNoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = ArchiveNoteM2::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
        else{
            if ($this->session == 'SN') {
                $verify = NoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = NoteM2::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
                    //$this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
    }

    private function validationM2R($student): void
    {
        if ($this->archive)
        {
            if ($this->session == 'SN') {
                $verify = ArchiveNoteMRS::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = ArchiveNoteMRS::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

                } catch (\Exception $e) {
//                $this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
        else{
            if ($this->session == 'SN') {
                $verify = NoteMR::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)->count();

                if ($verify > 0) {
                    $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                    $this->reset(['note']);
                } else {
                    $this->submit_Note($student);
                }

            } elseif ($this->session == 'SR') {
                try {
                    $noteEdit = NoteMR::where('numInscrit', $student->numInscrit)
                        ->where('idMatiereN', $this->id_ec)
                        ->where('idEtdN', $student->idEtd)->with('note')->first();

//                if(is_null($noteEdit->note->noteSN)){
//                    $this->reset(['note']);
//                    $this->emit('flash', 'Cet étudiant n\'a pas encore son note Session Normale ', 'error');
//                }
                } catch (\Exception $e) {
                    //$this->reset(['note']);
                }

                if($noteEdit){
                    if ($noteEdit->note->noteSR != null) {
                        $this->emit('modal', 'teste', 'confirm', json_encode($student), $this->note);
                        $this->reset(['note']);
                    } else {
                        $this->submit_Note($student);
                    }
                }else{
                    $this->submit_Note($student);
                }
            }
        }
    }

//*********************************************************************************************************
//********************FIN VERIFICATION SI NOTE EXISTE******************************************************
//*********************************************************************************************************



//*********************************************************************************************************
//********************SUBMIT NOTE**************************************************************************
//*********************************************************************************************************

    public function submit_Note($student)
    {
        switch ($this->niveau) {
            case "L1":
                $this->submitNoteL1($student);
                break;

            case "L2":
                $this->submitNoteL2($student);
                break;

            case "L3":
                $this->submitNoteL3($student);
                break;

            case "M1":
                $this->submitNoteM1($student);
                break;

            case "M2":
                $this->submitNoteM2($student);
                break;

            case "MR":
                $this->submitNoteM2R($student);
                break;
        }
    }

    private function submitNoteL1($student): void
    {
        if ($this->archive)
        {
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                ArchiveNoteL1::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = ArchiveNoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    ArchiveNoteL1::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => ArchiveL1::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }else{
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                NoteL1::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = NoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    NoteL1::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => LicenceOne::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }
    }

    private function submitNoteL2($student): void
    {
        if ($this->archive)
        {
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                ArchiveNoteL2::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = ArchiveNoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    ArchiveNoteL2::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => ArchiveL2::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }else{
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                NoteL2::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = NoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    NoteL2::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => LicenceTwo::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }
    }

    private function submitNoteL3($student): void
    {
        if ($this->archive)
        {
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                ArchiveNoteL3::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = ArchiveNoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    ArchiveNoteL3::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => ArchiveL3::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }else{
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                NoteL3::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = NoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    NoteL3::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => LicenceThree::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }
    }

    private function submitNoteM1($student): void
    {
        if ($this->archive)
        {
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                ArchiveNoteM1::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = ArchiveNoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    ArchiveNoteM1::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => ArchiveM1::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }else{
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                NoteM1::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = NoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    NoteM1::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => MasterOne::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }
    }

    private function submitNoteM2($student): void
    {
        if ($this->archive)
        {
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                ArchiveNoteM2::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = ArchiveNoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    ArchiveNoteM2::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => ArchiveM2::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }else{
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                NoteM2::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = NoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    NoteM2::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => MasterTwo::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }
    }

    private function submitNoteM2R($student): void
    {
        if ($this->archive)
        {
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                ArchiveNoteMRS::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = ArchiveNoteMRS::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    ArchiveNoteMRS::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => ArchiveMR::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }else{
            if($this->session == 'SN'){
                $idNote = $this->insertNote($this->note, $student->numInscrit);
                NoteMR::create([
                    'numInscrit' => $student->numInscrit,
                    'idNote'=> $idNote,
                    'idEtdN'=> $student->idEtd,
                    'idMatiereN' => $this->id_ec,
                ]);

            }elseif ($this->session == 'SR'){
                $noteEdit = NoteMR::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                if($noteEdit){
                    $noteEdit->note->noteSR = $this->note;
                    $noteEdit->note->save();
                }else{
                    $currentIdNote = $this->insertSR($this->note, $student->numInscrit);
                    NoteMR::create([
                        'numInscrit' => $student->numInscrit,
                        'idNote' => $currentIdNote,
                        'idMatiereN' => $this->id_ec,
                        'idEtdN' => MasterRecherche::where('numInscrit', $student->numInscrit)->first()->idEtd,
                    ]);
                }
            }
            $this->reset(['note']);
        }
    }

//*************************************************************************************************************
//********************FIN SUBMIT NOTE**************************************************************************
//*************************************************************************************************************


//*********************************************************************************************************
//********************UPDATE NOTE**************************************************************************
//*********************************************************************************************************

    public function updateNote($student, $note){

        $student = json_decode($student);

        switch ($this->niveau) {
            case "L1":
                $this->updateNoteL1($student, $note);
                break;

            case "L2":
                $this->updateNoteL2($student, $note);
                break;

            case "L3":
                $this->updateNoteL3($student, $note);
                break;
            case "M1":
                $this->updateNoteM1($student, $note);
                break;


            case "M2":
                $this->updateNoteM2($student, $note);
                break;

            case "M2R":
                $this->updateNoteM2R($student, $note);
                break;
        }
    }

    private function updateNoteL1($student, $note): void
    {
        if ($this->archive){
            if($this->session === 'SN'){
                $noteEdit = ArchiveNoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = ArchiveNoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        } else{
            if($this->session === 'SN'){
                $noteEdit = NoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = NoteL1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        }
    }

    private function updateNoteL2($student, $note): void
    {
        if ($this->archive){
            if($this->session === 'SN'){
                $noteEdit = ArchiveNoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = ArchiveNoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        } else{
            if($this->session === 'SN'){
                $noteEdit = NoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = NoteL2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        }
    }

    private function updateNoteL3($student, $note): void
    {
        if ($this->archive){
            if($this->session === 'SN'){
                $noteEdit = ArchiveNoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = ArchiveNoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        } else{
            if($this->session === 'SN'){
                $noteEdit = NoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = NoteL3::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        }
    }

    private function updateNoteM1($student, $note): void
    {
        if ($this->archive){
            if($this->session === 'SN'){
                $noteEdit = ArchiveNoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = ArchiveNoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        } else{
            if($this->session === 'SN'){
                $noteEdit = NoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = NoteM1::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        }
    }

    private function updateNoteM2($student, $note): void
    {
        if ($this->archive){
            if($this->session === 'SN'){
                $noteEdit = ArchiveNoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = ArchiveNoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        } else{
            if($this->session === 'SN'){
                $noteEdit = NoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = NoteM2::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        }
    }

    private function updateNoteM2R($student, $note): void
    {
        if ($this->archive){
            if($this->session === 'SN'){
                $noteEdit = ArchiveNoteMRS::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = ArchiveNoteMRS::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        } else{
            if($this->session === 'SN'){
                $noteEdit = NoteMR::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSN = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();

            }elseif ($this->session === 'SR'){
                $noteEdit = NoteMR::where('numInscrit', $student->numInscrit)
                    ->where('idMatiereN', $this->id_ec)
                    ->where('idEtdN', $student->idEtd)->with('note')->first();
                $noteEdit->note->noteSR = $note;
                $noteEdit->note->updatedBy = Auth()->user()->name . ' ' . Auth()->user()->prenom;
                $noteEdit->note->save();
            }
            $this->reset(['note']);
        }
    }

//*********************************************************************************************************
//********************FIN UPDATE NOTE**********************************************************************
//*********************************************************************************************************


/************************************************************************************************************
 ****************************************DELETE NOTE*********************************************************
 ************************************************************************************************************/

    public function deleteMessage($studentArray)
    {
        $studentJSON = json_encode($studentArray);
        $student = json_decode($studentJSON);
        $this->emit('modal', 'teste', 'delete', json_encode($student), $this->note);
    }

    public function deleteNote($student)
    {
        switch ($this->niveau){
            case "L1":
                $this->deleteL1($student['numInscrit']);
                break;
            case "L2":
                $this->deleteL2($student['numInscrit']);
                break;
            case "L3":
                $this->deleteL3($student['numInscrit']);
                break;
            case "M1":
                $this->deleteM1($student['numInscrit']);
                break;
            case "M2":
                $this->deleteM2($student['numInscrit']);
                break;
            case "M2R":
                $this->deleteM2R($student['numInscrit']);
                break;
            default:
                if (Auth()->user()->role === "Licence") {
                    $this->deleteL1($student['numInscrit']);
                }
                if (Auth()->user()->role === "Master") {
                    $this->deleteM1($student['numInscrit']);
                }
        }
    }

    private function deleteL1($numInscrit)
    {
        if ($this->archive){
            $noteDelete = ArchiveNoteL1::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteL1::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteL1::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }else{
            $noteDelete = NoteL1::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteL1::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteL1::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }
    }

    private function deleteL2($numInscrit)
    {
        if ($this->archive){
            $noteDelete = ArchiveNoteL2::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteL2::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteL2::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }else{
            $noteDelete = NoteL2::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteL2::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteL2::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }
    }

    private function deleteL3($numInscrit)
    {
        if ($this->archive){
            $noteDelete = ArchiveNoteL3::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteL3::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteL3::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }else{
            $noteDelete = NoteL3::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteL3::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteL3::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }
    }

    private function deleteM1($numInscrit)
    {
        if ($this->archive){
            $noteDelete = ArchiveNoteM1::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteM1::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteM1::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }else{
            $noteDelete = NoteM1::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteM1::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteM1::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }
    }

    private function deleteM2($numInscrit)
    {
        if ($this->archive){
            $noteDelete = ArchiveNoteM2::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteM2::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteM2::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }else{
            $noteDelete = NoteM2::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteM2::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteM2::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }
    }

    private function deleteM2R($numInscrit)
    {
        if ($this->archive){
            $noteDelete = ArchiveNoteMRS::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteMRS::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    ArchiveNoteMRS::destroy($noteDelete->id);
                    ArchiveNote::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }else{
            $noteDelete = NoteMR::where('numInscrit', $numInscrit)
                ->where('idMatiereN', $this->id_ec)
                ->with('note')->first();
            if ($noteDelete){
                if (!is_null($noteDelete->note->noteSN) & is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteMR::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (!is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)) {
                    if ($this->session === 'SN')
                        $noteDelete->note->noteSN = NULL;
                    if ($this->session === 'SR')
                        $noteDelete->note->noteSR = null;
                    $noteDelete->note->save();
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }

                if (is_null($noteDelete->note->noteSN) & !is_null($noteDelete->note->noteSR)){
                    $idNote = $noteDelete->idNote;
                    NoteMR::destroy($noteDelete->id);
                    Note::destroy($idNote);
                    return $this->emit('flash', 'Note supprimée avec succès! ', 'success');
                }


            }else{
                return $this->emit('flash', 'Note non existant! ', 'error');
            }
        }
    }

/************************************************************************************************************
****************************************END DELETE NOTE******************************************************
*************************************************************************************************************/
}
