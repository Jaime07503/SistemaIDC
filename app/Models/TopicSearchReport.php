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
            'teamOrientation',
            'searchPlan',
            'meetings',
            'generalObjetive',
            'specificsObjetives',
            'coordinatorAssessment',
            'deadLine',
            'storagePath',
            'state',
        ];

        //Relationships with other tables
        public function idc()
        {
            return $this->hasOne(IDC::class);
        }

        public function sourceSearch()
        {
            return $this->hasMany(SourceSearch::class);
        }
    }
?>