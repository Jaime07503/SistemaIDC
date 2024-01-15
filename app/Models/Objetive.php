<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Objetive extends Model
    {
        use HasFactory;
        protected $table = 'Objetive';
        protected $primaryKey = 'objetiveId'; 

        protected $fillable = [
            'objetiveId',
            'objetive',
            'type',
            'studentContribute',
            'state'
        ];

        //Relationships with other tables
        public function sourceObjetive()
        {
            return $this->hasMany(SourceObjetive::class);
        }
    }
?>