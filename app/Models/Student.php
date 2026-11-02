<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    
    protected $table = 'student';

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'name',
        'gender',
        'dob',
        'phone',
        'email',
        'department',
        'city',
        'join_date',
    ];

    public function allocations() {
        return $this->hasMany(Allocation::class,'student_id','student_id');
    }

    public function fees() {
        return $this->hasMany(Fee::class,'student_id','student_id');
    }

    public function visitors() {
        return $this->hasMany(Visitor::class,'student_id','student_id');
    }

    public function complaints() {
        return $this->hasMany(Complaint::class,'student_id','student_id');
    }
}
