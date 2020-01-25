<?php

namespace App\Http\Controllers\Frontend\Users\Contracts;

use App\Http\Requests\Users\UpdateAccountRequest;

Interface AccountControllerInterface
{
    public function index();

    public function update(UpdateAccountRequest $request, int $id);
}
