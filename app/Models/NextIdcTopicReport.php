<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class NextIdcTopicReport extends Model
    {
        use HasFactory;
        protected $table = 'Next_Idc_Topic_Report';
        protected $primaryKey = 'nextIdcTopicReportId'; 

        protected $fillable = [
            'nextIdcTopicReportId',
            'code',
            'introduction',
            'continueTopic',
            'proposeTopics',
            'storagePath',
            'state',
            'idIdc'
        ];

        //Relationships with other tables
        public function idc()
        {
            return $this->belongsTo(Idc::class, 'idIdc');
        }
    }
?>