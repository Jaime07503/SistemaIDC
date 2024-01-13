<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Subject extends Model
    {
        use HasFactory;
        protected $table = 'Subject';
        protected $primaryKey = 'subjectId'; 

        protected $fillable = [
            'subjectId',
            'code',
            'nameSubject',
            'section',
            'approvedIdc',
            'state',
            'avatar',
            'idCycle',
            'idCareer',
            'idTeacher',
        ];

        //Relationships with other tables
        public function researchTopic()
        {
            return $this->hasMany(ResearchTopic::class);
        }

        public function studentSubject()
        {
            return $this->hasMany(StudentSubject::class);
        }

        public function cycle()
        {
            return $this->belongsTo(Cycle::class, 'idCycle');
        }

        public function career()
        {
            return $this->belongsTo(Career::class, 'idCareer');
        }

        public function teacher()
        {
            return $this->belongsTo(Teacher::class, 'idTeacher');
        }
    }
?>