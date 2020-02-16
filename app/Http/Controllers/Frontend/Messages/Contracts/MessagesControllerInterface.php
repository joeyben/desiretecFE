<?php

namespace App\Http\Controllers\Frontend\Messages\Contracts;

use Illuminate\Http\Request;

Interface MessagesControllerInterface {

	public function list(string $subdomain, int $wishId, int $groupId);

	public function create(string $subdomain, Request $request);

	public function delete(string $subdomain, int $id);

	public function update(string $subdomain, int $id, Request $request);
}
