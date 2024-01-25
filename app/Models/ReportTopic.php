<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ReportTopic extends Model
    {
        use HasFactory;
        protected $table = 'Report_Topic';
        protected $primaryKey = 'reportTopicId'; 

        protected $fillable = [
            'reportTopicId',
            'idNextIdcTopicReport',
            'idTopic'
        ];

        //Relationships with other tables
        public function nextIdcTopicReport()
        {
            return $this->belongsTo(NextIdcTopicReport::class, 'IdNextIdcTopicReport');
        }

        public function topic()
        {
            return $this->belongsTo(Topic::class, 'idTopic');
        }
    }
?>