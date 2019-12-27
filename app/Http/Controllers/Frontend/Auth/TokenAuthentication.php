<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Access\User\User;
use Illuminate\Http\Request;

class TokenAuthentication
{
    protected $request;
    protected $identifier = 'email';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function requestLink()
    {
        $user = $this->getUserByIdentifier($this->request->get($this->identifier));
        $user->storeToken()->sendTokenLink([
            'email' => trim($user->email),
        ]);
    }

    protected function getUserByIdentifier($value)
    {
        return User::where($this->identifier, $value)->firstOrFail();
    }
}
