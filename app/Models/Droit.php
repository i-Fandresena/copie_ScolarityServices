<?php

namespace App\Models;

use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterTwo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Droit extends Model
{
    use HasFactory;

    protected $fillable = [
        'idDroit',
        'typeDroit',
        'montantDroit',
        'designation',
        'role',
        'createdBy',
        'udatedBy',
    ];

    protected $primaryKey = 'idDroit';

    public function licenceOne()
    {
        return $this->belongsTo(LicenceOne::class, 'idDroit', 'idEtd');
    }

    public function licenceTwo()
    {
        return $this->belongsTo(LicenceTwo::class, 'idDroit', 'idEtd');
    }

    public function licenceThree()
    {
        return $this->belongsTo(LicenceThree::class, 'idDroit', 'idEtd');
    }

    public function masterOne()
    {
        return $this->belongsTo(MasterOne::class, 'idDroit', 'idEtd');
    }

    public function masterTwo()
    {
        return $this->belongsTo(MasterTwo::class, 'idDroit', 'idEtd');
    }
}
