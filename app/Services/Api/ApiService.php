<?php

namespace App\Services\Api;

use GuzzleHttp;
use GuzzleHttp\Client;
use App\Services\Contracts\ApiServiceInterface;
use GuzzleHttp\Cookie\CookieJar;

class ApiService implements ApiServiceInterface
{
    const API_PATH = "/api/v1";

    protected $apiUrl;

    protected $headers = [];

    protected $client;

    private $response;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'https://mvp.desiretec.com') . $this::API_PATH;
        $this->client = new Client();
        $this->setHeader('Content-type', 'application/json');
        $this->setAuthorization(resolve('token'));
        $this->setHeader('c-agent', session()->get('c-agent', null));
    }

    public function setHeader(string $key, string $value = null): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function getWlInfo(string $name)
    {
        $result = $this->get('/whitelabel' . '/' . urlencode($name));

        return $result->formatResponse('object')->data;
    }

    public function getWlFromHost(string $host)
    {
        $result = $this->get('/whitelabelfromhost' . '/' . $host);

        return $result->formatResponse('object')->data;
    }


    public function setAuthorization(?string $token): self
    {
        if ($token) {
            $this->setHeader('Authorization', 'Bearer ' . $token);
        }

        return $this;
    }


    public function get(string $endpoint, array $data = [])
    {
        $this->setAuthorization(resolve('token'));
        $this->setHeader('c-agent', session()->get('c-agent', null));

        $this->response = $this->client->get($this->apiUrl . $endpoint . '?' . http_build_query($data),
            [
                'headers' => $this->headers
            ]
        );

        return $this;
    }

    public function post(string $endpoint, array $data = [])
    {
        $this->setAuthorization(resolve('token'));
        $this->setHeader('c-agent', session()->get('c-agent', null));

        $this->response = $this->client->post($this->apiUrl . $endpoint,
            [
                'headers' => $this->headers,
                GuzzleHttp\RequestOptions::JSON => $data
            ]
        );

        return $this;
    }

    public function put(string $endpoint, array $data)
    {
        $this->setAuthorization(resolve('token'));
        $this->setHeader('c-agent', session()->get('c-agent', null));

        $this->response = $this->client->put($this->apiUrl . $endpoint,
            [
                'headers' => $this->headers,
                GuzzleHttp\RequestOptions::JSON => $data
            ]
        );

        return $this;
    }

    public function delete(string $endpoint)
    {
        $this->setAuthorization(resolve('token'));
        $this->setHeader('c-agent', session()->get('c-agent', null));

        $this->response = $this->client->delete($this->apiUrl . $endpoint,
            [
                'headers' => $this->headers
            ]
        );

        return $this;
    }

    public function formatResponse(string $format = null)
    {
        switch ($format) {
            case 'array':
                return json_decode($this->response->getBody(), true);
            case 'object':
                return json_decode($this->response->getBody());
            default:
                return $this->response->getBody();
        }
    }
}
