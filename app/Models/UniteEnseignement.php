<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniteEnseignement extends Model
{
    use HasFactory;

    protected $fillable = [
        'idUE',
        'designation',
        'credit',
        'niveau',
        'session',
        'statut',
        'anneeUnivers'
    ];

    protected $primaryKey = 'idUE';

    public function element()
    {
        return $this->hasMany(ElementConstitutif::class, 'idUE', 'idUE');
    }

}
