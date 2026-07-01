<?php

namespace App\Models\Students;

use App\Models\Bordereau;
use App\Models\Droit;
use App\Models\Notes\NoteL3;
use App\Models\Parcours;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class LicenceThree extends Model
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
        'centreExamen',
        'email',
        'situationMat',
        'profession',
        'statut',
        'RAD',
        'observation',
        'idBrdE',
        'idDroitE',
        'idParcours',
    ];

    protected $primaryKey = 'idEtd';

    public function bordereau(){
        return $this->hasOne(Bordereau::class, 'idBrd', 'idBrdE');
    }

    public function droit(){
        return $this->hasOne(Droit::class, 'idDroit', 'idDroitE');
    }

    public function parcours(){
        return $this->hasOne(Parcours::class, 'id', 'idParcours');
    }

    public function note(){
        return $this->hasMany (NoteL3::class, 'idEtdN');
    }
}
