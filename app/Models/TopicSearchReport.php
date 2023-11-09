<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class TopicSearchReport extends Model
    {
        use HasFactory;

        protected $table = 'topic_search_report';
        protected $primaryKey = 'topicSearchReportId'; 

        protected $fillable = [
            'topicSearchReportId',
            'teamOrientation',
            'searchPlan',
            'meetingReport',
            'generalObjetive',
            'specificsObjetives',
            'criteria',
            'coordinatorAssessment',
            'evaluationRubric',
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