<?php

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Frontend\Admin\CacheController;
use App\Http\Controllers\Frontend\Users\Contracts\AccountControllerInterface;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Models\Users\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateAccountRequest;
use App\Services\Api\ApiService;
use Illuminate\Support\Facades\Log;

/**
 * Class AccountController.
 */
class AccountController extends Controller implements AccountControllerInterface
{
    protected $apiService;
    protected $user;

    public function __construct(ApiService $apiService, User $user)
    {
        $this->apiService = $apiService;
        $this->user = $user;
    }

    public function index(string $subdomain)
    {
        try {
            $response = $this->apiService->post('/auth' . '/me');

            $this->user = $response->formatResponse('object');

            return view('frontend.user.account')->with([
                'user'  => $this->user->user
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function update(string $subdomain, UpdateAccountRequest $request, int $id)
    {
        try {
            $response = $this->apiService->put('/account/update/' . $id, $request->all());
            $message = $response->formatResponse('object')->success->message;
            CacheController::flush();

            return redirect()
                ->route('frontend.user.account', [$subdomain])
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function changePassword(string $subdomain, ChangePasswordRequest $request)
    {
        try {
            $response = $this->apiService->put('/account/changePassword', $request->all());
            $message = $response->formatResponse('object')->success->message;

            return redirect()
                ->route('frontend.user.account', [$subdomain])
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
