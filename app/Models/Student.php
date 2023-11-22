<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Student extends Model
    {
        use HasFactory;

        protected $table = 'student';
        protected $primaryKey = 'studentId'; 

        protected $fillable = [
            'studentId',
            'carnet',
            'career',
            'studentCycle',
            'studentYear',
            'enrolledSubject',
            'previousIDC',
            'state',
            'idUser',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class, 'idUser');
        }

        public function studentSubject()
        {
            return $this->hasMany(StudentSubject::class);
        }

        public function studentResearchTopic()
        {
            return $this->hasMany(StudentResearchTopic::class, 'studentId');
        }

        public function studentTeam()
        {
            return $this->hasMany(StudentTeam::class, 'idStudent');
        }

        public function nextIdcTopicsForm()
        {
            return $this->hasOne(NextIdcTopicsForm::class);
        }
    }
?>