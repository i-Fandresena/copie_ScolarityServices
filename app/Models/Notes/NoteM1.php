<?php

namespace App\Models\Notes;

use App\Models\ElementConstitutif;
use App\Models\Students\MasterOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteM1 extends Model
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
        return $this->belongsToMany(MasterOne::class, 'idEtd', 'idEtdN');
    }
}
