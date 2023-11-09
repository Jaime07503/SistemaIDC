<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Subject extends Model
    {
        use HasFactory;

        protected $table = 'subject';
        protected $primaryKey = 'subjectId'; 

        protected $fillable = [
            'subjectId',
            'nameSubject',
            'section',
            'career',
            'subjectCycle',
            'subjectYear',
            'idTeacher',
        ];

        //Relationships with other tables
        public function teacher()
        {
            return $this->belongsTo(Teacher::class, 'idTeacher');
        }

        public function studentSubject()
        {
            return $this->hasMany(StudentSubject::class);
        }

        public function researchTopic()
        {
            return $this->hasMany(ResearchTopic::class);
        }
    }
?>