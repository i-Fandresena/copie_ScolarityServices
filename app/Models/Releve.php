<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Releve extends Model
{
    use HasFactory;
    protected $fillable = [
        'numReleve',
        'nom',
        'prenom',
        'numInscrit',
        'dateNaissance',
        'lieuNaissance',
        'anneeUnivers',
        'dateDelivrance',
        'niveau',
        'parcours',
    ];
}
