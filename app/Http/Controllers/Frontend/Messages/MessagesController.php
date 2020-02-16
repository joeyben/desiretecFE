<?php

namespace App\Http\Controllers\Frontend\Messages;


use App\Http\Controllers\Frontend\Messages\Contracts\MessagesControllerInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\ApiService;
use Log;

class MessagesController extends Controller implements MessagesControllerInterface
{
    protected $apiSevice;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function list(string $subdomain, int $wishId, int $groupId)
    {
        try {
            $response = $this->apiService->get('/messages'.'/'.$wishId.'/'. $groupId);

            return $response->formatResponse('array');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function create(string $subdomain, Request $request)
    {
        try {
            $response = $this->apiService->post('/messages', $request->all());

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function delete(string $subdomain, int $id)
    {
        try {
            $response = $this->apiService->delete('/messages'.'/'.$id);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function update(string $subdomain, int $id, Request $request)
    {
        try {
            $response = $this->apiService->put('/messages'.'/'.$id, $request->all());

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
