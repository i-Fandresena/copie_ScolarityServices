<?php

namespace App\Models\Candidats;

use App\Models\Bordereau;
use App\Models\Droit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class CandidatM2R extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'parcours',
        'universite',
        'statut',
        'etablissement',
        'email',
        'profession',
        'cursus',
        'situationMat',
        'observation',
        'idDroitC',
        'idBrdC',
    ];

    protected $primaryKey = 'idEtd';

    public function bordereau(){
        return $this->hasOne(Bordereau::class, 'idBrd', 'idBrdC');
    }

    public function droit(){
        return $this->hasOne(Droit::class, 'idDroit', 'idDroitC');
    }
}
