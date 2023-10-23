<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;

        protected $table = 'users';
        protected $primaryKey = 'userId'; 

        protected $fillable = [
            'userId',
            'name',
            'email',
            'avatar',
            'role',
            'first_login_present_cycle',
            'first_login_at',
            'last_login_at',
            'state',
            'external_id',
            'external_auth',
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
            return $this->hasOne(Student::class);
        }

        public function opinionFormProcess()
        {
            return $this->hasOne(OpinionFormProcess::class);
        }

        public function idc()
        {
            return $this->hasMany(IDC::class);
        }
    }
?>