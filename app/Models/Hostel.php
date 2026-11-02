<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model {
    
    protected $table = 'hostel';

    protected $primaryKey = 'hostel_id';

    protected $fillable = [
        'hostel_name',
        'hostel_type',
        'warden_id',
    ];

    public function warden() {
        return $this->belongsTo(Warden::class,'warden_id','warden_id');
    }

    public function rooms() {
        return $this->hasMany(Room::class,'hostel_id','hostel_id');
    }
}