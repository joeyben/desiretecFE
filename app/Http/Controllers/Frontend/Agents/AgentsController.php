<?php

namespace App\Http\Controllers\Frontend\Agents;

use App\Http\Controllers\Frontend\Agents\Contracts\AgentsControllerInterface;
use App\Http\Requests\Agents\UpdateAgentsRequest;
use App\Http\Requests\Agents\CreateAgentsRequest;
use App\Models\Agents\Agent;
use App\Http\Controllers\Controller;
use App\Services\Api\ApiService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * Class AgentsController
 */
class AgentsController extends Controller implements AgentsControllerInterface
{
    const BODY_CLASS = 'agent';

    protected $apiService;
    protected $agent;
    protected $upload_path;
    protected $storage;

    public function __construct(ApiService $apiService, Agent $agent)
    {
        $this->apiService = $apiService;
        $this->agent = $agent;
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'agent' . \DIRECTORY_SEPARATOR ?? '';
        $this->storage = Storage::disk('s3');
    }

    public function index(string $subdomain)
    {
        try {
            $response = $this->apiService->get('/agents');

            $agents = $response->formatResponse('object')->data;

            return view('frontend.agents.index')->with([
                'body_class'    => $this::BODY_CLASS,
                'avatar_path'   => $this->storage->url('img/agent/'),
                'agents'        => $agents,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function create(string $subdomain)
    {
        return view('frontend.agents.create')->with([
            'body_class'  => $this::BODY_CLASS,
            'agent'       => $this->agent,
        ]);
    }

    public function store(CreateAgentsRequest $request, Agent $agent)
    {
        try {
            $data = $request->all();

            $data['avatar'] = $this->uploadImage(['avatar' => $request->avatar]);

            $response = $this->apiService->post('/agents/create', $data);

            return redirect()
                ->route('frontend.agents.index')
                ->with('flash_success', trans('alerts.frontend.agents.created'));

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function edit(string $subdomain, int $id)
    {
        try {
            $response = $this->apiService->get('/agents' . '/' . $id);

            $agent = $response->formatResponse('object')->data;

            return view('frontend.agents.edit')->with([
                'body_class'  => $this::BODY_CLASS,
                'agent'       => $agent,
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function update(string $subdomain, int $id, UpdateAgentsRequest $request)
    {
        try {
            $data = $request->all();

            if (\array_key_exists('avatar', $data)) {
                $data['avatar'] = $this->uploadImage(['avatar' => $request->avatar]);
            }

            $response = $this->apiService->put('/agents/update/' . $id, $data);

            return redirect()
                ->route('frontend.agents.index')
                ->with('flash_success', trans('alerts.frontend.agents.updated'));

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function delete(string $subdomain, $id)
    {
        try {
           $response = $this->apiService->delete('/agents/delete/' . $id);

            return redirect()
                ->route('frontend.agents.index')
                ->with('flash_success', trans('alerts.frontend.agents.deleted'));

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function uploadImage($input)
    {
        try {
            if (!\is_array($input)) {
                $input = [];
            }

            if (isset($input['avatar']) && !empty($input['avatar'])) {
                $avatar = $input['avatar'];
                $fileName = time() . $avatar->getClientOriginalName();

                $this->storage->put($this->upload_path . $fileName, file_get_contents($avatar->getRealPath()), 'public');

                return $fileName;
            }

            $fileName = 'avatar_default';

            $this->storage->put($this->upload_path . $fileName, file_get_contents('https://desiretec.s3.eu-central-1.amazonaws.com/img/agent/1570145950wAvatarCallCenter2.png'), 'public');

            return $fileName;

        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    function deleteOldImage(string $fileName)
    {
        // TODO:
    }
}
