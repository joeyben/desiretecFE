<?php

namespace App\Http\Controllers\Frontend\Agents\Contracts;

use App\Models\Agents\Agent;
use App\Http\Requests\Agents\UpdateAgentsRequest;
use App\Http\Requests\Agents\CreateAgentsRequest;

Interface AgentsControllerInterface
{
    public function index();

    public function create();

    public function store(CreateAgentsRequest $request, Agent $agent);

    public function edit(string $subdomain, int $id);

    public function update(string $subdomain, int $id, UpdateAgentsRequest $request);

    public function delete($id);

    public function uploadImage($input);

    public function deleteOldImage(string $fileName);
}
