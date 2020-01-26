<?php

namespace App\Models\Agents;

use App\Models\BaseModel;

class Agent extends BaseModel
{
    protected $fillable = ['name', 'display_name', 'status', 'avatar', 'user_id', 'telephone', 'email'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
