<?php

namespace App\Services\Api;

use GuzzleHttp;
use GuzzleHttp\Client;
use App\Services\Contracts\ApiServiceInterface;

class ApiService implements ApiServiceInterface
{
    const HOST_LOCAL = "http://localhost:8000";
    const HOST_DEV = "https://mvp.desiretec.com";
    const HOST_PROD = "";
    const API_PATH = "/api/v1";
    const TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE1Nzk0NTMwMDgsImV4cCI6MTU4MDY2MjYwOCwibmJmIjoxNTc5NDUzMDA4LCJqdGkiOiIycTBKMkczRzhiSUZnOU1KIiwic3ViIjoxLCJwcnYiOiI5NGRiZDk2MWFhZWYwZTNjZTY2YWQ3ZDUwZTY0NzcxNzYwOWRkYTI0IiwiaWQiOjF9.HPwWzEEGtGAeEVxR67TpqhoMqlsUChzPsMbD9Cm9H_I";

    protected $apiUrl;
    protected $client;

    public function __construct()
    {
        $this->apiUrl = $this::HOST_LOCAL . $this::API_PATH;
        $this->client = new Client(["headers" => [
            "Authorization" => "Bearer " . $this::TOKEN,
            "Content-type" => "application/json"
        ]]);
    }

    public function getAll(string $endpoint) {
        return $this->client->get($this->apiUrl . $endpoint);
    }

    public function create(string $endpoint, array $data) {
        return $this->client->post($this->apiUrl . $endpoint, [
            GuzzleHttp\RequestOptions::JSON => $data
        ]);
    }

    public function read(string $endpoint) {
        return $this->client->get($this->apiUrl . $endpoint);
    }

    public function update(string $endpoint, array $data) {
        return $this->client->put($this->apiUrl . $endpoint, [
            GuzzleHttp\RequestOptions::JSON => $data
        ]);
    }

    public function delete(string $endpoint) {
        return $this->client->delete($this->apiUrl . $endpoint);
    }

    public function validate(int $statusCode) {
        // TODO:
    }
}
