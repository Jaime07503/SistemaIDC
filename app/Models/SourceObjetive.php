<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class SourceObjetive extends Model
    {
        use HasFactory;
        protected $table = 'Source_Objetive';
        protected $primaryKey = 'sourceObjetiveId'; 

        protected $fillable = [
            'sourceObjetiveId',
            'idTopicSearchReport',
            'idObjetive'
        ];

        //Relationships with other tables
        public function topicSearchReport()
        {
            return $this->belongsTo(TopicSearchReport::class, 'idTopicSearchReport');
        }

        public function objetive()
        {
            return $this->belongsTo(Objetive::class, 'idObjetive');
        }
    }
?>