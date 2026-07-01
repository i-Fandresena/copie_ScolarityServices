<?php

namespace App\Models\Notes;

use App\Models\ElementConstitutif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
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
        return $this->belongsTo(NoteL1::class, 'idNote', 'idNote');
    }

    public function noteL2(){
        return $this->belongsTo(NoteL2::class, 'idNote', 'idNote');
    }

    public function noteL3(){
        return $this->belongsTo(NoteL3::class, 'idNote', 'idNote');
    }

    public function noteM1(){
        return $this->belongsTo(NoteM1::class, 'idNote', 'idNote');
    }

    public function noteM2(){
        return $this->belongsTo(NoteM2::class, 'idNote', 'idNote');
    }

}
