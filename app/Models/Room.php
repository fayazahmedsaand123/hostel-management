<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model {

    protected $table = 'room';

    protected $primaryKey = 'room_id';

    protected $fillable = [
        'hostel_id',
        'room_no',
        'capacity',
        'room_type',
        'rent_per_month',
    ];

    public function hostel() {
        return $this->belongsTo(Hostel::class,'hostel_id','hostel_id');
    }

    public function allocations() {
        return $this->hasMany(allocation::class, 'room_id','room_id');
    }
}
