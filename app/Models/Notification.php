<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Notification extends Model
    {
        use HasFactory;
        protected $table = 'Notification';
        protected $primaryKey = 'notificationId'; 

        protected $fillable = [
            'notificationId',
            'notification',
            'state',
            'idUser',
        ];

        //Relationships with other tables
        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }
?>