<?php

namespace App\Http\Controllers\Frontend\Agents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiService;
use App\Models\Agents\Agent;

/**
 * Class AgentsController
 */
class AgentsController extends Controller
{
    const BODY_CLASS = 'agent';

    protected $agent;
    protected $apiService;

    public function __construct(ApiService $apiService, Agent $agent)
    {
        $this->apiService = $apiService;
        $this->agent = $agent;
    }

    public function index()
    {
        $response = $this->apiService->getAll('/agents');

        $this->apiService->validate($response->getStatusCode());

        $agents = json_decode($response->getBody())->data;

        return view('frontend.agents.index')->with([
            'body_class' => $this::BODY_CLASS,
            'agents'     => $agents,
        ]);
    }

    public function profile()
    {
        return view('frontend.agents.profile');
    }

    public function create()
    {
        return view('frontend.agents.create')->with([
            'body_class'  => $this::BODY_CLASS,
            'agent'       => $this->agent,
        ]);
    }

    public function store(Request $request, Agent $agent)
    {
        $response = $this->apiService->create('/agents/create', $agent);

        $this->apiService->validate($response->getStatusCode());

        return redirect()
            ->route('frontend.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.created'));
    }

    public function edit()
    {
        return view('frontend.agents.edit')->with([
            'body_class'  => $this::BODY_CLASS,
            'agent'       => $this->agent,
        ]);
    }

    public function update(Request $request, Agent $agent)
    {
        $response = $this->apiService->update('/agents/update/' . $agent->id, $agent);

        $this->apiService->validate($response->getStatusCode());

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.updated'));
    }

    public function delete($id)
    {
        $this->apiService->delete('/agents/delete/' . $id);

        $this->apiService->validate($response->getStatusCode());

        return redirect()
            ->route('frontend.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.deleted'));
    }

    public function uploadImage($input)
    {
        if (!\is_array($input)) {
            $input = [];
        }

        if (isset($input['avatar']) && !empty($input['avatar'])) {
            $avatar = $input['avatar'];

            $fileName = time() . $avatar->getClientOriginalName();

            $this->storage->put($this->upload_path . $fileName, file_get_contents($avatar->getRealPath()), 'public');

            $input = array_merge($input, ['avatar' => $fileName]);

            return $input;
        }
        $fileName = 'avatar_default';

        $this->storage->put($this->upload_path . $fileName, file_get_contents('https://desiretec.s3.eu-central-1.amazonaws.com/img/agent/1570145950wAvatarCallCenter2.png'), 'public');

        $input = array_merge($input, ['avatar' => $fileName]);

        return $input;
    }
}
