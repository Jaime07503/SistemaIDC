<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ScientificArticleReport extends Model
    {
        use HasFactory;
        protected $table = 'Scientific_Article_Report';
        protected $primaryKey = 'scientificArticleReportId'; 

        protected $fillable = [
            'scientificArticleReportId',
            'code',
            'numberOfWords',
            'storagePath',
            'nameDocumentImage',
            'documentImageStoragePath',
            'nameCorrectDocument',
            'correctDocumentStoragePath ',
            'nameCorrectedDocument',
            'correctedDocumentStoragePath',
            'state',
            'previousState',
            'idIdc'
        ];

        //Relationships with other tables
        public function articleConclusion()
        {
            return $this->hasMany(ArticleConclusion::class);
        }

        public function articleReference()
        {
            return $this->hasMany(ArticleReference::class);
        }

        public function idc()
        {
            return $this->belongsTo(IDC::class, 'idIdc');
        }
    }
?>