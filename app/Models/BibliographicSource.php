<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class BibliographicSource extends Model
    {
        use HasFactory;
        protected $table = 'Bibliographic_Source';
        protected $primaryKey = 'bibliographicSourceId'; 

        protected $fillable = [
            'bibliographicSourceId',
            'theme',
            'author',
            'year',
            'averageType',
            'source',
            'studentContribute',
            'link',
            'state'
        ];

        //Relationships with other tables
        public function sourceSearch()
        {
            return $this->hasMany(SourceSearch::class);
        }
    }
?>