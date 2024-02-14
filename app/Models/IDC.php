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
            'badgeProcessCompleted',
            'state',
            'idTeam'
        ];

        //Relationships with other tables
        public function team()
        {
            return $this->belongsTo(Team::class, 'idTeam');
        }

        public function trainingDocument() 
        {
            return $this->hasMany(TrainingDocument::class);    
        }

        public function topicSearchReport()
        {
            return $this->hasMany(TopicSearchReport::class);
        }

        public function scientificArticleReport()
        {
            return $this->hasMany(ScientificArticleReport::class);
        }

        public function nextIdcTopicReport()
        {
            return $this->hasMany(NextIdcTopicReport::class);
        }

        public function idcComment() 
        {
            return $this->hasMany(IDCComments::class);
        }
    }
?>