<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SourceSearch extends Model
    {
        use HasFactory;

        protected $table = 'Source_Search';
        protected $primaryKey = 'sourceSearchId'; 

        protected $fillable = [
            'sourceSearchId',
            'idTopicSearchReport',
            'idBibliographicSource',
        ];

        //Relationships with other tables
        public function topicSearchReport()
        {
            return $this->belongsTo(Student::class, 'topicSearchReportId');
        }

        public function bibliographicSource()
        {
            return $this->belongsTo(BibliographicSource::class, 'bibliographicSourceId');
        }
    }
?>