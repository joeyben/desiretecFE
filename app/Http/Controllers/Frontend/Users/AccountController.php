<?php

namespace App\Http\Controllers\Frontend\Users;

use App\Http\Controllers\Frontend\Users\Contracts\AccountControllerInterface;
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

    public function index()
    {
        try {
            $response = $this->apiService->post('/auth' . '/me');

            $this->user = $response->formatResponse('object');

            return view('frontend.user.account')->with([
                'logged_in_user'  => $this->user,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function update(UpdateAccountRequest $request, int $id)
    {
        try {
            $response = $this->apiService->put('/account/update/' . $id, $request->all());

            return redirect()
                ->route('frontend.user.account')
                ->with('flash_success', trans('alerts.frontend.user.updated'));

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
