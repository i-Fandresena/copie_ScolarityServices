<?php

namespace App\Models\DossierRecus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRCandidatL1 extends Model
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
        'serieBacc',
        'anneeBacc',
        'mentionBacc',
        'observation',
        'idDroitE'
    ];

    protected $primaryKey = 'idEtd';
}
