<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warden extends Model {
    protected $table = 'warden';

    protected $primaryKey = 'warden_id';

    protected $fillable = [
        'warden_name',
        'phone',
        'email',
    ];

    public function hostels() {
        return $this->hasMany(Hostel::class,'warden_id','warden_id');
    }
}
