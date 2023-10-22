<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';
    protected $primaryKey = 'subjectId'; 
    protected $foreignKey = 'idTeacher';

    protected $fillable = [
        'subjectId',
        'nameSubject',
        'section',
        'career',
        'subjectCycle',
        'subjectYear',
        'idTeacher',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'idTeacher');
    }

    public function researchTopic(){
        return $this->hasMany(ResearchTopic::class);
    }
}