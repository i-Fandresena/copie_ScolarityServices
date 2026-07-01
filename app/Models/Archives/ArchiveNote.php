<?php

namespace App\Models\Archives;

use App\Models\ElementConstitutif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'idNote',
        'noteSN',
        'noteSR',
        'annee',
        'updatedBy',
        'createdBy',
    ];

    protected $primaryKey = 'idNote';


    public function matiere(){
        return $this->hasOne(ElementConstitutif::class, 'idMatiere', 'idMatiereN');
    }

    public function noteL1(){
        return $this->belongsTo(ArchiveNoteL1::class, 'idNote', 'idNote');
    }

    public function noteL2(){
        return $this->belongsTo(ArchiveNoteL2::class, 'idNote', 'idNote');
    }

    public function noteL3(){
        return $this->belongsTo(ArchiveNoteL3::class, 'idNote', 'idNote');
    }

    public function noteM1(){
        return $this->belongsTo(ArchiveNoteM1::class, 'idNote', 'idNote');
    }

    public function noteM2(){
        return $this->belongsTo(ArchiveNoteM2::class, 'idNote', 'idNote');
    }
}
