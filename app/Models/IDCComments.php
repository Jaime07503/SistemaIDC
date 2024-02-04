<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class IDCComments extends Model
    {
        use HasFactory;
        protected $table = 'Idc_Comment';
        protected $primaryKey = 'idcCommentId'; 

        protected $fillable = [
            'idcCommentId',
            'idIdc',
            'idComment'
        ];

        //Relationships with other tables
        public function idc()
        {
            return $this->belongsTo(Idc::class, 'idIdc');
        }

        public function comment()
        {
            return $this->belongsTo(Development::class, 'idComment');
        }
    }
?>