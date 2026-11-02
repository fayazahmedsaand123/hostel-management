<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model {
    
    protected $table = 'visitor';

    protected $primaryKey = 'visitor_id';

    protected $fillable = [
        'student_id',
        'visitor_name',
        'relation',
        'visit_date',
        'in_time',
        'out_time',
    ];

    public function student() {
        return $this->belongsTo(Student::class,'student','student');
    }
}
