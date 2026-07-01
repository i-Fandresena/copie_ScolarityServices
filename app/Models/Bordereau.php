<?php

namespace App\Models;

use App\Models\Candidats\CandidatL;
use App\Models\Candidats\CandidatM;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterTwo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bordereau extends Model
{
    use HasFactory;

    protected $fillable = [
        'idBrd',
        'referenceBrd1',
        'referenceBrd2',
        'montantBrd1',
        'montantBrd2',
        'dateBrd1',
        'dateBrd2',
        'agenceBrd1',
        'agenceBrd2',
        'createdBy',

    ];

    protected $primaryKey = 'idBrd';

    public function candidatL()
    {
        return $this->belongsTo(CandidatL::class, 'idBrd', 'numCL');
    }

    public function candidatM()
    {
        return $this->belongsTo(CandidatM::class,   'idBrd', 'numCM');
    }

    public function licenceOne()
    {
        return $this->belongsTo(LicenceOne::class, 'idBrd', 'idEtd');
    }

    public function licenceTwo()
    {
        return $this->belongsTo(LicenceTwo::class, 'idBrd', 'idEtd');
    }

    public function licenceThree()
    {
        return $this->belongsTo(LicenceThree::class, 'idBrd', 'idEtd');
    }

    public function masterOne()
    {
        return $this->belongsTo(MasterOne::class, 'idBrd', 'idEtd');
    }

    public function masterTwo()
    {
        return $this->belongsTo(MasterTwo::class, 'idBrd', 'idEtd');
    }
}
