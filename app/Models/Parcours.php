<?php

namespace App\Models;

use App\Models\Students\LicenceThree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
    ];

    public function licenceThree(){
        return $this->belongsTo(LicenceThree::class);
    }
}
