<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Idc extends Model
    {
        use HasFactory;

        protected $table = 'Idc';
        protected $primaryKey = 'idcId'; 

        protected $fillable = [
            'idcId',
            'cycle',
            'year',
            'endDate',
            'badgeProcessCompleted',
            'state',
            'idTeam',
            'idUser',
            'idTopicSearchReport',
            'idScientificArticle',
            'idNextIdcTopicReport',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class, 'idUser');
        }

        public function team()
        {
            return $this->hasOne(Team::class, 'idTeam');
        }

        public function topicSearchReport()
        {
            return $this->belongsTo(TopicSearchReport::class, 'idTopicSearchReport');
        }

        public function scientificArticle()
        {
            return $this->belongsTo(ScientificArticle::class, 'idScientificArticle');
        }

        public function nextIdcTopicReport()
        {
            return $this->belongsTo(NextIdcTopicReport::class, 'idNextIdcTopicReport');
        }
    }
?>