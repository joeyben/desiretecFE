<?php

namespace App\Http\Controllers\Frontend\Users\Contracts;

use App\Http\Requests\Users\UpdateAccountRequest;

Interface AccountControllerInterface
{
    public function index(string $subdomain);

    public function update(string $subdomain, UpdateAccountRequest $request, int $id);
}
