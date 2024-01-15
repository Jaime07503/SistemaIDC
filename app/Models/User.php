<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;
        protected $table = 'User';
        protected $primaryKey = 'userId'; 

        protected $fillable = [
            'userId',
            'name',
            'email',
            'avatar',
            'role',
            'firstLoginPresentCycle',
            'firstLogin',
            'lastLogin',
            'externalId',
            'externalAuth',
            'state'
        ];

        protected $hidden = [
            'remember_token',
        ];

        //Relationships with other tables
        public function teacher()
        {
            return $this->hasOne(Teacher::class);
        }

        public function student()
        {
            return $this->hasOne(Student::class, 'idUser');
        }

        public function idc()
        {
            return $this->hasMany(IDC::class);
        }
    }
?>