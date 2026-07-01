<?php

namespace App\Models\Archives;

use App\Models\Bordereau;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveCandidatM1 extends Model
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
        'idBrdC',
    ];

    protected $primaryKey = 'idEtd';

    public function bordereau(){
        return $this->hasOne(Bordereau::class, 'idBrd', 'idBrdC');
    }
}
