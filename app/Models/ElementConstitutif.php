<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementConstitutif extends Model
{
    use HasFactory;

    protected $fillable = [
        'idMatiere',
        'matiere',
        'poids',
        'enseignant',
        'idUE',
        'idEns',
        'parcours',
        'statut',
    ];

    protected $primaryKey = 'idMatiere';

    public function uniteEnseignement(){
        return $this->belongsToMany(UniteEnseignement::class, 'idUE', 'idUE');
    }

    public function enseignant(){
        return $this->hasOne(Enseignant::class, 'idEns', 'idEns');
    }
}
