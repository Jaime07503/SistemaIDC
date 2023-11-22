<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class StudentResearchTopic extends Model
    {
        use HasFactory;
        protected $table = 'student_research_topic';
        protected $primaryKey = 'idStudentResearchTopic'; 

        protected $fillable = [
            'idStudentResearchTopic',
            'idStudent',
            'idResearchTopic',
            'state',
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