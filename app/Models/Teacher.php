<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Teacher extends Model
    {
        use HasFactory;
        protected $table = 'Teacher';
        protected $primaryKey = 'teacherId'; 

        protected $fillable = [
            'teacherId',
            'contractType',
            'specialty',
            'idcQuantity',
            'idUser',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class, 'idUser');
        }

        public function subject()
        {
            return $this->hasMany(Subject::class, 'idTeacher');
        }

        public function team()
        {
            return $this->hasMany(Team::class);
        }
    }
?>