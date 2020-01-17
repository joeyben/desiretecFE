<?php

namespace App\Http\Controllers\Frontend\Agents;

use App\Models\Agents\Agent;
use App\Http\Controllers\Controller;

/**
 * Class AgentsController.
 */
class AgentsController extends Controller
{
    const BODY_CLASS = 'agent';

    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    public function __construct()
    {
    }

    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://mvp.desiretec.com/api/v1/agents',
            [
                'headers' => [
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL212cC5kZXNpcmV0ZWMuY29tL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNTc5MjQ4NjI3LCJleHAiOjE1ODE5MjcwMjcsIm5iZiI6MTU3OTI0ODYyNywianRpIjoiR2lLa2VRTUJwS3dDcUUwNSIsInN1YiI6MjQ3NywicHJ2IjoiOTRkYmQ5NjFhYWVmMGUzY2U2NmFkN2Q1MGU2NDc3MTc2MDlkZGEyNCIsImlkIjoyNDc3fQ.Yv3OHye9B6gW1TgOjJspjB_jsNp4kFif2Z6_HfRI9Ps'
                ]
            ]
        );
        $response_json = json_decode($response->getBody());
        $agents = $response_json->data;

        return view('frontend.agents.index')->with([
            'status'     => $this->status,
            'body_class' => $this::BODY_CLASS,
            'agents'     => $agents
        ]);
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function profile()
    {
        return view('frontend.agents.profile');
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     * @param type                                                   $id
     *
     * @return mixed
     */
    public function create()
    {
        return view('frontend.agents.create')->with([
            'status'         => $this->status,
            'body_class'     => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\StoreAgentsRequest $request
     *
     * @return mixed
     */
    public function store()
    {
        $this->agent->create($request->except('_token'));

        return redirect()
            ->route('frontend.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.created'));
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function edit()
    {
        return view('frontend.agents.edit')->with([
            // 'agent'               => $agent,
            'status'              => $this->status,
            'body_class'          => $this::BODY_CLASS,
        ]);
    }

    public function editAgent()
    {
        // $agent = DB::table('agents')->where('id', $id)->first();

        return view('frontend.agents.edit')->with([
            // 'agent'               => $agent,
            'status'              => $this->status,
            'body_class'          => 'agent',
        ]);
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\UpdateAgentsRequest $request
     *
     * @return mixed
     */
    public function update()
    {
        // $input = $request->all();

        // $this->agent->update($agent, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.updated'));
    }

    public function updateAgent()
    {
        // $this->agent->doUpdate($id, $request);

        return redirect()
            ->route('frontend.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.updated'));
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function destroy()
    {
        // $this->agent->delete($agent);

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.deleted'));
    }

    public function status()
    {
        // $this->agent->updateStatus($id);
        // $this->session->put('agent_id', $id);

        return redirect()->back();
    }

    public function delete()
    {
        /**** Delete Agent and Assign offers/messages to another agent ****/
        // $this->agent->deleteAgent($id);

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
