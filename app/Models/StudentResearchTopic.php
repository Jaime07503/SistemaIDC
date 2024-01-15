<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class StudentResearchTopic extends Model
    {
        use HasFactory;
        protected $table = 'Student_Research_Topic';
        protected $primaryKey = 'studentResearchTopicId'; 

        protected $fillable = [
            'studentResearchTopicId',
            'state',
            'idStudent',
            'idResearchTopic',
        ];

        //Relationships with other tables
        public function student()
        {
            return $this->belongsTo(Student::class, 'idStudent');
        }

        public function researchTopic()
        {
            return $this->belongsTo(ResearchTopic::class, 'idResearchTopic');
        }
    }
?>