<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class NextIdcTopicsForm extends Model
    {
        use HasFactory;

        protected $table = 'next_idc_topics_forms';
        protected $primaryKey = 'nextIdcTopicFormId'; 

        protected $fillable = [
            'nextIdcTopicFormId',
            'subject',
            'lastUpdate',
            'regionalImportance',
            'globalImportance',
            'justificationKnoeledge',
            'state',
            'idStudent',
        ];

        //Relationships with other tables
        public function student()
        {
            return $this->belongsTo(Student::class, 'idStudent');
        }
    }
?>