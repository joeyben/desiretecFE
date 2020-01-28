<?php

namespace App\Models\Users;

use App\Models\BaseModel;

class User extends BaseModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'zip_code',
        'city',
        'country',
        'status',
        'confirmation_code',
        'confirmed',
        'password',
        'created_by',
        'updated_by',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];

    protected static $logAttributes = [
        'first_name',
        'last_name',
        'email',
    ];
}
