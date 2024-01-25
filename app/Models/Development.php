<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Development extends Model
    {
        use HasFactory;
        protected $table = 'Development';
        protected $primaryKey = 'developmentId'; 

        protected $fillable = [
            'developmentId',
            'title',
            'content',
            'image',
            'studentContribute',
            'state'
        ];

        //Relationships with other tables
        public function articleDevelopment()
        {
            return $this->hasMany(ArticleDevelopment::class);
        }
    }
?>