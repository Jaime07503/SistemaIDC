<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ArticleConclusion extends Model
    {
        use HasFactory;
        protected $table = 'Article_Conclusion';
        protected $primaryKey = 'articleConclusionId'; 

        protected $fillable = [
            'articleConclusionId',
            'idScientificArticleReport',
            'idConclusion'
        ];

        //Relationships with other tables
        public function scientificArticleReport()
        {
            return $this->belongsTo(ScientificArticleReport::class, 'idScientificArticleReport');
        }

        public function conclusion()
        {
            return $this->belongsTo(Conclusion::class, 'idConclusion');
        }
    }
?>