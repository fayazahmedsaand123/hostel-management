<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model {
    
    protected $table = 'complaint';

    protected $primaryKey = 'complaint_id';

    protected $fillable = [
        'student_id',
        'complaint_type',
        'description',
        'complaint_date',
        'status',
    ];

    public function student() {
        return $this->belongsTo(Student::class,'student_id','student_id');
    }
}
