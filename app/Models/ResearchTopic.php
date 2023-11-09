<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ResearchTopic extends Model
    {
        use HasFactory;

        protected $table = 'research_topic';
        protected $primaryKey = 'researchTopicId'; 

        protected $fillable = [
            'researchTopicId',
            'themeName',
            'description',
            'importanceRegional',
            'importanceGlobal',
            'state',
            'avatar',
            'idSubject',
        ];

        //Relationships with other tables
        public function subject()
        {
            return $this->belongsTo(Subject::class, 'idSubject');
        }

        public function team()
        {
            return $this->hasOne(Team::class);
        }
    }
?>