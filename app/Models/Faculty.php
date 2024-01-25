<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Faculty extends Model
    {
        use HasFactory;
        protected $table = 'Faculty';
        protected $primaryKey = 'facultyId'; 

        protected $fillable = [
            'facultyId',
            'nameFaculty',
        ];

        //Relationships with other tables
        public function career()
        {
            return $this->hasMany(Career::class, 'idFaculty');
        }
    }
?>