<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Reference extends Model
    {
        use HasFactory;
        protected $table = 'Reference';
        protected $primaryKey = 'referenceId'; 

        protected $fillable = [
            'referenceId',
            'reference',
            'studentContribute',
            'state'
        ];

        //Relationships with other tables
        public function articleReference()
        {
            return $this->hasMany(ArticleReference::class);
        }
    }
?>