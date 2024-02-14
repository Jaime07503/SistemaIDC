<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Topic extends Model
    {
        use HasFactory;
        protected $table = 'Topic';
        protected $primaryKey = 'topicId'; 

        protected $fillable = [
            'topicId',
            'nameTopic',
            'subjectRelevance',
            'globalUpdateImg',
            'localUpdateImg',
            'updatedInformation',
            'localRelevance',
            'globalRelevance',
            'subject',
            'studentContribute',
            'state'
        ];

        //Relationships with other tables
        public function reportTopic()
        {
            return $this->hasMany(ReportTopic::class);
        }
    }
?>