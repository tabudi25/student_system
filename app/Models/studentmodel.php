<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class studentmodel extends Model
{
    protected $table = 'student';
    protected $fillable = ['student_id', 'profile_image', 'f_name', 'l_name', 'email', 'phone', 'address', 'course', 'year'];
    public $timestamps = false;

    public function getStudentById($id)
    {
        return $this->where('student_id', $id)->first();
    }

    public function getStudentByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
