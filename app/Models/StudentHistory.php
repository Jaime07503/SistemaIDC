<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class StudentHistory extends Model
    {
        use HasFactory;

        protected $table = 'Student_History';
        protected $primaryKey = 'studentHistoryId'; 

        protected $fillable = [
            'studentHistoryId',
            'cum',
            'studentCycle',
            'studentYear',
            'enrolledSubject',
            'subjectApply',
            'previousIdc',
            'idStudent',
        ];

        //Relationships with other tables
        public function student()
        {
            return $this->belongsTo(Student::class, 'idStudent');
        }
    }
?>