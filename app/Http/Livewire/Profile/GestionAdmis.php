<?php

namespace App\Http\Livewire\Profile;

use App\Models\Admis;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\SimpleExcel\SimpleExcelReader;

class GestionAdmis extends Component
{
    use WithFileUploads;

    public $excelFile;
    public $selectedLevel;
    public $ue;

    protected $listeners = ['deleteAdmis' => 'deleteAdmis'];

    public function confirmDeleteAdmis()
    {
        $this->emit('modal', null, 'deleteAdmis', null, null);
    }
    public function render()
    {
        return view('livewire.profile.gestion-admis');
    }

    public function import()
    {
        $this->emit('startProcess');
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv'
        ]);
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

        try {
            $reader = SimpleExcelReader::create($this->excelFile->getRealPath());

            // On récupère le contenu (les lignes) du fichier
            $rows = $reader->getRows();

            // 4. On insère toutes les lignes dans la base de données
            $data = $rows->toArray();

            foreach ($data as $row) {
                if($row['Numero'] == "")
                    continue;

                Admis::create([
                    'numInscrit' => preg_replace('/\s+/', '',strval($row['Numero'])),
                    'nom' => $row['Nom'],
                    'prenom' => $row['Prenoms'],
                    'niveau' => $niveau,
                ]);
            }
            $status = true;

        }catch (\Exception $e){
            $status = false;
        }

        if ($status) {
            $reader->close();
            $this->emit('endProcess');
            $this->emit('flash', 'Les données ont été importées avec succès.', 'success');
        } else {
            $this->emit('endProcess');
            $this->emit('flash', 'Une erreur est survenue lors de l\'importation des données.', 'error');
        }
    }

    public function deleteAdmis(){
        if (Admis::count() > 0){
            if($this->selectedLevel){
                Admis::where('niveau', $this->selectedLevel)->delete();
            }
            else{
                if(Auth()->user()->role === "Licence"){
                    Admis::where('niveau', 'L1')->delete();
                }
                if(Auth()->user()->role === "Master"){
                    Admis::where('niveau', 'M1')->delete();
                }
            }
            $this->emit('flash', 'Liste effacée avec succès!', 'success');
        } else{
            $this->emit('flash', 'Il n\'y a pas de liste admis pour ce niveau!', 'info');
        }
    }



}
