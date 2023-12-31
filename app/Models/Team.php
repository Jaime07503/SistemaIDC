<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Team extends Model
    {
        use HasFactory;

        protected $table = 'Team';
        protected $primaryKey = 'teamId';

        protected $fillable = [
            'teamId',
            'creationDate',
            'integrantQuantity',
            'state',
            'idResearchTopic',
            'idTeacher',
        ];

        //Relationships with other tables
        public function teacher()
        {
            return $this->belongsTo(Teacher::class, 'idTeacher');
        }

        public function researchTopic()
        {
            return $this->hasOne(ResearchTopic::class, 'idResearchTopic');
        }

        public function studentTeam()
        {
            return $this->hasMany(StudentTeam::class, 'idTeam');
        }

        public function IDC()
        {
            return $this->hasOne(IDC::class);
        }
    }
?>