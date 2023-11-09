<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class BibliographicSource extends Model
    {
        use HasFactory;

        protected $table = 'bibliographic_source';
        protected $primaryKey = 'bibliographicSourceId'; 

        protected $fillable = [
            'bibliographicSourceId',
            'bibliographicSourceType',
            'author',
            'year',
            'averageType',
            'link',
        ];

        //Relationships with other tables
        public function sourceSearch()
        {
            return $this->hasMany(SourceSearch::class);
        }
    }
?>