<?php

namespace App\Models\Notes;

use App\Models\ElementConstitutif;
use App\Models\Students\LicenceOne;
use App\Models\Students\MasterRecherche;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteMR extends Model
{
    use HasFactory;
    protected $fillable = [
        'numInscrit',
        'idNote',
        'idMatiereN',
        'idEtdN',
    ];

    public function note(){
        return $this->hasOne(Note::class, 'idNote', 'idNote');
    }

    public function matiere(){
        return $this->hasOne(ElementConstitutif::class, 'idMatiere', 'idMatiereN');
    }

    public function etudiant(){
        return $this->belongsToMany(MasterRecherche::class, 'idEtd', 'idEtdN');
    }
}
