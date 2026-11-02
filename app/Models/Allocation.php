<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model {
    
    protected $table = 'allocation';

    protected $primaryKey = 'allocation_id';

    protected $fillable = [
        'student_id',
        'room_id',
        'allot_date',
        'leave_date',
        'status',
    ];

    public function student() {
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function room() {
        return $this->belongsTo(Room::class,'student_id','student_id');
    }
}
