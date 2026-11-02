<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model {
    
    protected $table = 'fee';

    protected $primaryKey = 'fee_id';

    protected $fillable = [
        'student_id',
        'amount',
        'pay_date',
        'month_for',
        'payment_mode',
    ];

    public function student() {
        return $this->belongsTo(Student::class,'student_id','student_id');
    }
}
