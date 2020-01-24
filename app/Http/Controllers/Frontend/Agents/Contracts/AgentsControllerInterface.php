<?php

namespace App\Http\Controllers\Frontend\Agents\Contracts;

use App\Models\Agents\Agent;
use App\Http\Requests\Agents\UpdateAgentsRequest;
use App\Http\Requests\Agents\CreateAgentsRequest;

Interface AgentsControllerInterface
{
    public function index();

    public function profile();

    public function create();

    public function store(CreateAgentsRequest $request, Agent $agent);

    public function edit(int $id);

    public function update(int $id, UpdateAgentsRequest $request);

    public function delete($id);

    public function uploadImage($input);

    function deleteOldImage(string $fileName);
}
