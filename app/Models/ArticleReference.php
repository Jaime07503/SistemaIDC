<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ArticleReference extends Model
    {
        use HasFactory;
        protected $table = 'Article_Reference';
        protected $primaryKey = 'articleReferenceId'; 

        protected $fillable = [
            'articleReferenceId',
            'idScientificArticleReport',
            'idReference'
        ];

        //Relationships with other tables
        public function scientificArticleReport()
        {
            return $this->belongsTo(ScientificArticleReport::class, 'idScientificArticleReport');
        }

        public function reference()
        {
            return $this->belongsTo(Reference::class, 'idReference');
        }
    }
?>