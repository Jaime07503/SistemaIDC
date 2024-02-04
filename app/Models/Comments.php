<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Comments extends Model
    {
        use HasFactory;
        protected $table = 'Comment';
        protected $primaryKey = 'commentId'; 

        protected $fillable = [
            'commentId',
            'commentsIdc',
            'opportunityForImprovements',
            'whoContributes',
            'idUser'
        ];

        //Relationships with other tables
        public function idcComment()
        {
            return $this->hasMany(IDCComments::class);
        }
    }
?>