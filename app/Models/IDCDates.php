<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class IDCDates extends Model
    {
        use HasFactory;
        protected $table = 'Idc_Date';
        protected $primaryKey = 'dateId'; 

        protected $fillable = [
            'dateId',
            'startDateSearchReport',
            'endDateSearchReport',
            'startDateScientificArticleReport',
            'endDateScientificArticleReport',
            'startDateNextIdcTopic',
            'endDateNextIdcTopic',
            'idCycle'
        ];

        // Relationships with other tables
        public function cycle() 
        {
            return $this->belongsTo(Cycle::class);    
        }
    }
?>