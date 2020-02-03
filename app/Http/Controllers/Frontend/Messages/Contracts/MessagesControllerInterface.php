<?php

namespace App\Http\Controllers\Frontend\Messages\Contracts;

use Illuminate\Http\Request;

Interface MessagesControllerInterface {

	public function list(int $wishId, int $groupId);

	public function create(Request $request);

	public function delete(int $id);

	public function update(int $id, Request $request);
}
