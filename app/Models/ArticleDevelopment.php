<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ArticleDevelopment extends Model
    {
        use HasFactory;
        protected $table = 'Article_Development';
        protected $primaryKey = 'articleDevelopmentId'; 

        protected $fillable = [
            'articleDevelopmentId',
            'idScientificArticleReport',
            'idDevelopment'
        ];

        //Relationships with other tables
        public function scientificArticleReport()
        {
            return $this->belongsTo(ScientificArticleReport::class, 'idScientificArticleReport');
        }

        public function development()
        {
            return $this->belongsTo(Development::class, 'idDevelopment');
        }
    }
?>