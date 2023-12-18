<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class StudentTeam extends Model
    {
        use HasFactory;

        protected $table = 'Student_Team';
        protected $primaryKey = 'studentTeamId'; 

        protected $fillable = [
            'studentTeamId',
            'idStudent',
            'idTeam',
        ];

        //Relationships with other tables
        public function student()
        {
            return $this->belongsTo(Student::class, 'idStudent');
        }

        public function team()
        {
            return $this->belongsTo(Team::class, 'idTeam');
        }
    }
?>