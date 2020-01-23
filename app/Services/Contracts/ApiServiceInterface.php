<?php

namespace App\Services\Contracts;

Interface ApiServiceInterface
{
    public function setAuthorization(?string $token);

    public function setHeader(string $key, string $value);

    public function get(string $endpoint, array $data);

    public function post(string $endpoint, array $data);

    public function put(string $endpoint, array $data);

    public function delete(string $endpoint);

    public function formatResponse(string $format);
}
