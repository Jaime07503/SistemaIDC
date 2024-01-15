<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Cycle extends Model
    {
        use HasFactory;
        protected $table = 'Cycle';
        protected $primaryKey = 'cycleId'; 

        protected $fillable = [
            'cycleId',
            'cycle',
            'state'
        ];

        //Relationships with other tables
        public function subject()
        {
            return $this->hasMany(Subject::class);
        }
    }
?>