<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchTopic extends Model
{
    use HasFactory;

    protected $table = 'research_topics';
    protected $primaryKey = 'researchTopicId'; 
    protected $foreignKey = 'idSubject';

    protected $fillable = [
        'researchTopicId',
        'themeName',
        'description',
        'importanceRegional',
        'importanceGlobal',
        'state',
        'idSubject',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
