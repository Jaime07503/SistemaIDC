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
            'themeName',
            'description',
            'avatar',
            'importanceRegional',
            'importanceGlobal',
            'state',
            'idSubject',
        ];

        //Relationships with other tables
        public function subject()
        {
            return $this->belongsTo(Subject::class, 'idSubject');
        }

        public function team()
        {
            return $this->belongsTo(Team::class);
        }

        public function studentResearchTopic()
        {
            return $this->hasMany(StudentResearchTopic::class, 'idResearchTopic', 'researchTopicId');
        }
    }
?>