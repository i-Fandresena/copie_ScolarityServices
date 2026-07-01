<?php

namespace App\Models\Notes;

use App\Models\ElementConstitutif;
use App\Models\Students\LicenceThree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteL3 extends Model
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
        return $this->belongsToMany(LicenceThree::class, 'idEtd', 'idEtdN');
    }
}
