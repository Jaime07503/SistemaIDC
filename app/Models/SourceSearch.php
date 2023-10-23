<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SourceSearch extends Model
    {
        use HasFactory;

        protected $table = 'source_searches';
        protected $primaryKey = ['idTopicSearchReport' ,'idSourceSearch']; 

        protected $fillable = [
            'idTopicSearchReport',
            'idBibliographicSource',
        ];

        //Relationships with other tables
        public function topicSearchReport()
        {
            return $this->belongsTo(Student::class, 'idTopicSearchReport');
        }

        public function bibliographicSource()
        {
            return $this->belongsTo(BibliographicSource::class, 'idBibliographicSource');
        }
    }
?>