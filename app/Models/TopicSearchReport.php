<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class TopicSearchReport extends Model
    {
        use HasFactory;
        protected $table = 'Topic_Search_Report';
        protected $primaryKey = 'topicSearchReportId'; 

        protected $fillable = [
            'topicSearchReportId',
            'code',
            'orientation',
            'induction',
            'searchPlan',
            'meetings',
            'teamValoration',
            'teamComment',
            'finalComment',
            'storagePath',
            'nameCorrectedDocument',
            'correctedDocumentStoragePath',
            'state',
            'previousState',
            'idIdc'
        ];

        //Relationships with other tables     
        public function sourceSearch()
        {
            return $this->hasMany(SourceSearch::class);
        }

        public function sourceObjetive()
        {
            return $this->hasMany(SourceObjetive::class);
        }

        public function idc()
        {
            return $this->belongsTo(IDC::class, 'idIdc');
        }
    }
?>