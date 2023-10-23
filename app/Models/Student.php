<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Student extends Model
    {
        use HasFactory;

        protected $table = 'students';
        protected $primaryKey = 'studentId'; 

        protected $fillable = [
            'studentId',
            'carnet',
            'career',
            'studentCycle',
            'studentYear',
            'enrolledSubject',
            'previousIDC',
            'idUser',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class, 'idUser');
        }

        public function studentTeam()
        {
            return $this->hasMany(StudentTeam::class);
        }

        public function nextIdcTopicsForm()
        {
            return $this->hasOne(NextIdcTopicsForm::class);
        }
    }
?>