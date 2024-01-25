<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Career extends Model
    {
        use HasFactory;
        protected $table = 'Career';
        protected $primaryKey = 'careerId'; 

        protected $fillable = [
            'careerId',
            'nameCareer',
            'idFaculty'
        ];

        //Relationships with other tables
        public function subject()
        {
            return $this->hasMany(Subject::class, 'idCareer');
        }
        
        public function faculty()
        {
            return $this->belongsTo(Faculty::class, 'idFaculty');
        }
    }
?>