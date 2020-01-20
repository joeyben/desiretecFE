<?php

namespace App\Services\Contracts;

Interface ApiServiceInterface
{
    public function getAll(string $endpoint);

    public function create(string $endpoint, array $data);

    public function read(string $endpoint);

    public function update(string $endpoint, array $data);

    public function delete(string $endpoint);
}
