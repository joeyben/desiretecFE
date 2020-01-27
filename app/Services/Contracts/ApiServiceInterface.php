<?php

namespace App\Services\Contracts;

Interface ApiServiceInterface
{
    public function get(string $endpoint, array $data);

    public function post(string $endpoint, array $data);

    public function put(string $endpoint, array $data);

    public function delete(string $endpoint);
}
