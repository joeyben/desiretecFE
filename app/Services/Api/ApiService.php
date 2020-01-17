<?php

namespace App\Services\Api;

use App\Services\Contracts\ApiServiceInterface;
use GuzzleHttp\Client;

class ApiService implements ApiServiceInterface
{
    const HOST_LOCAL = "http://localhost:8000";
    const HOST_DEV = "https://mvp.desiretec.com";
    const HOST_PROD = "";
    const API_PATH = "/api/v1";
    const TOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE1NzkyNTYyODUsImV4cCI6MTU4MDQ2NTg4NSwibmJmIjoxNTc5MjU2Mjg1LCJqdGkiOiJXRjlsTXpUN2hNcXlWOTB3Iiwic3ViIjoxLCJwcnYiOiI5NGRiZDk2MWFhZWYwZTNjZTY2YWQ3ZDUwZTY0NzcxNzYwOWRkYTI0IiwiaWQiOjF9.oSxXU_TWYRrPgH4EwUwmrkNxCIybS9xOR9d4Ig0FKPY";

    protected $apiUrl;
    protected $client;

    public function __construct()
    {
        $this->apiUrl = $this::HOST_LOCAL . $this::API_PATH;
        $this->client = new Client(["headers" => [
            "Authorization" => "Bearer " . $this::TOKEN
        ]]);
    }

    public function hitApi(string $method, string $endpoint, array $data = null)
    {
        switch ($method) {
            case 'get':
                $response = $this->client->get($this->apiUrl . $endpoint);
                return $response;
            case 'delete':
                $response = $this->client->delete($this->apiUrl . $endpoint);
                return $response;
            case 'post':
                $response = $this->client->post(
                    $this->apiUrl . $endpoint,
                    array(
                        'data' => $data
                    )
                );
                return $response;
            case 'put':
                $response = $this->client->put(
                    $this->apiUrl . $endpoint,
                    array(
                        'data' => $data
                    )
                );
                return $response;
            default:
                return null;
        }
    }

    public function getAll(string $endpoint) {
        $response = $this->client->get($this->apiUrl . $endpoint);
        return $response;
    }

    public function create(string $endpoint, array $data) {
        $response = $this->client->post(
            $this->apiUrl . $endpoint,
            array(
                'data' => $data
            )
        );

        return $response;
    }

    public function read(string $endpoint) {
        $response = $this->client->get($this->apiUrl . $endpoint);
        return $response;
    }

    public function update(string $endpoint, array $data) {
        $response = $this->client->put(
            $this->apiUrl . $endpoint,
            array(
                'data' => $data
            )
        );

        return $response;
    }

    public function delete(string $endpoint) {
        $response = $this->client->delete($this->apiUrl . $endpoint);
        return $response;
    }

    public function validate(int $statusCode) {
        // TODO:
    }
}
