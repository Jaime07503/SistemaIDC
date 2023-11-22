<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class StudentSubject extends Model
    {
        use HasFactory;
        protected $table = 'student_subject';
        protected $primaryKey = 'idStudentSubject'; 

        protected $fillable = [
            'idStudentSubject',
            'idStudent',
            'idSubject',
            'applicationCount',
        ];

        //Relationships with other tables
        public function student()
        {
            return $this->belongsTo(Student::class, 'idStudent');
        }

        public function subject()
        {
            return $this->belongsTo(Subject::class, 'idSubject');
        }
    }
?>