<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    protected $table = ('devices');

    protected $fillable = [
        'user_id',
        'device_name',
        'api_key',
    ];
}
