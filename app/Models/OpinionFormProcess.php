<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class OpinionFormProcess extends Model
    {
        use HasFactory;

        protected $table = 'opinion_form_processes';
        protected $primaryKey = 'opinionFormProcessId';

        protected $fillable = [
            'opinionFormProcessId',
            'opinionIdcProcess',
            'improvementOpportunity',
            'state',
            'idUser',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class, 'idUser');
        }
    }
?>