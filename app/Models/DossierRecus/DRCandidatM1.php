<?php

namespace App\Models\DossierRecus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRCandidatM1 extends Model
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
        'centreExamen',
        'statut',
        'etablissement',
        'email',
        'profession',
        'situationMat',
        'observation',
        'idDroitE'
    ];

    protected $primaryKey = 'idEtd';
}
