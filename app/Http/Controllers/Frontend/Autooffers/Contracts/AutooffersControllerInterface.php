<?php

namespace App\Http\Controllers\Frontend\Autooffers\Contracts;

use Illuminate\Http\Request;

Interface AutooffersControllerInterface
{
	public function list(string $subdomain, int $wishId);

    public function listTt(string $subdomain, int $wishId);
}
