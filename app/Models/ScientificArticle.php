<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ScientificArticle extends Model
    {
        use HasFactory;

        protected $table = 'Scientific_Article';
        protected $primaryKey = 'scientificArticleId'; 

        protected $fillable = [
            'scientificArticleId',
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