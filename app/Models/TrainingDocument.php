<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class TrainingDocument extends Model
    {
        use HasFactory;
        protected $table = 'Training_Document';
        protected $primaryKey = 'trainingDocumentId'; 

        protected $fillable = [
            'trainingDocumentId',
            'nameDocument',
            'documentType',
            'type',
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