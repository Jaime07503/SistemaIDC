<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ResearchTopic extends Model
    {
        use HasFactory;
        protected $table = 'Research_Topic';
        protected $primaryKey = 'researchTopicId'; 

        protected $fillable = [
            'researchTopicId',
            'code',
            'themeName',
            'description',
            'avatar',
            'currentInformation',
            'importanceRegional',
            'importanceGlobal',
            'state',
            'idSubject',
        ];

        //Relationships with other tables
        public function studentResearchTopic()
        {
            return $this->hasMany(StudentResearchTopic::class);
        }

        public function team()
        {
            return $this->hasMany(Team::class);
        }
        
        public function subject()
        {
            return $this->belongsTo(Subject::class, 'idSubject');
        }
    }
?>