<?php

namespace App\Models\Notes;

use App\Models\ElementConstitutif;
use App\Models\Students\MasterTwo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteM2 extends Model
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
        return $this->belongsToMany(MasterTwo::class, 'idEtd', 'idEtdN');
    }
}
