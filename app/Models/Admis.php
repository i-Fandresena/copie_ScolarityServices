<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admis extends Model
{
    use HasFactory;

    protected $fillable = [
        'numInscrit',
        'nom',
        'prenom',
        'niveau',
    ];

    protected $primaryKey = 'idAdmis';
}
