<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Conclusion extends Model
    {
        use HasFactory;
        protected $table = 'Conclusion';
        protected $primaryKey = 'conclusionId'; 

        protected $fillable = [
            'conclusionId',
            'conclusion',
            'studentContribute',
            'state'
        ];

        //Relationships with other tables
        public function articleConclusion()
        {
            return $this->hasMany(ArticleConclusion::class);
        }
    }
?>