<?php

namespace App\Models\Archives;

use App\Models\Bordereau;
use App\Models\Droit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveMR extends Model
{
    use HasFactory;

    protected $fillable = [
        'idEtd',
        'numInscrit',
        'nom',
        'prenom',
        'dateNaissance',
        'lieuNaissance',
        'telCandidat',
        'cin',
        'nationalite',
        'anneeUnivers',
        'genre',
        'email',
        'situationMat',
        'profession',
        'statut',
        'RAD',
        'observation',
        'idBrdE',
        'idDroitE'
    ];

    protected $primaryKey = 'idEtd';

    public function bordereau(){
        return $this->hasOne(Bordereau::class, 'idBrd', 'idBrdE');
    }

    public function droit(){
        return $this->hasOne(Droit::class, 'idDroit', 'idDroitE');
    }

    public function note(){
        return $this->hasMany (ArchiveNoteMRS::class, 'idEtdN');
    }
}
