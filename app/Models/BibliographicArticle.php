<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class BibliographicArticle extends Model
    {
        use HasFactory;

        protected $table = 'bibliographic_articles';
        protected $primaryKey = 'bibliographicArticleId'; 

        protected $fillable = [
            'bibliographicArticleId',
            'spanishSummary',
            'englishSummary',
            'keywords',
            'introduction',
            'methodology',
            'development',
            'conclusion',
            'bibliographicReferences',
            'numberOfWords',
            'deadLine',
            'storagePath',
            'state,'
        ];

        //Relationships with other tables
        public function idc()
        {
            return $this->hasOne(IDC::class);
        }
    }
?>