<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class IDC extends Model
    {
        use HasFactory;

        protected $table = 'idcs';
        protected $primaryKey = 'idcId'; 

        protected $fillable = [
            'idcId',
            'cicle',
            'year',
            'endDate',
            'badgeProcessCompleted',
            'state',
            'idResearchTopic',
            'idTeam',
            'idUser',
            'idTopicSearchReport',
            'idBibliographicArticle',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class, 'idUser');
        }

        public function researchTopic(){
            return $this->belongsTo(ResearchTopic::class, 'idResearchTopic');
        }

        public function team()
        {
            return $this->belongsTo(Team::class, 'idTeam');
        }

        public function topicSearchReport(){
            return $this->belongsTo(TopicSearchReport::class, 'idTopicSearchReport');
        }

        public function bibliographicArticle(){
            return $this->belongsTo(BibliographicArticle::class, 'idBibliographicArticle');
        }
    }
?>