<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $primaryKey = 'teacherId'; 
    protected $foreignKey = 'idUser';

    protected $fillable = [
        'teacherId',
        'contractType',
        'specialty',
        'idUser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->hasMany(Subject::class, 'idTeacher');
    }
}
