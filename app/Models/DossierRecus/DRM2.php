<?php

namespace App\Models\DossierRecus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRM2 extends Model
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
        'idDroitE'
    ];

    protected $primaryKey = 'idEtd';
}
