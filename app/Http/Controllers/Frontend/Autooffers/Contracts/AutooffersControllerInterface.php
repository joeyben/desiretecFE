<?php

namespace App\Http\Controllers\Frontend\Autooffers\Contracts;

use Illuminate\Http\Request;

Interface AutooffersControllerInterface
{
	public function list(int $wishId);

    public function listTt(int $wishId);
}
