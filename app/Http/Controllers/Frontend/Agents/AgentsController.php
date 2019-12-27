<?php

namespace App\Http\Controllers\Frontend\Agents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Agents\ManageAgentsRequest;
use App\Http\Requests\Frontend\Agents\UpdateAgentsRequest;
use App\Models\Agents\Agent;
use App\Repositories\Frontend\Agents\AgentsRepository;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class AgentsController.
 */
class AgentsController extends Controller
{
    const BODY_CLASS = 'agent';
    /**
     * Agent Status.
     */
    protected $status = [
        'Active'       => 'Active',
        'Inactive'     => 'Inactive',
        'Deleted'      => 'Deleted',
    ];

    /**
     * @var AgentsRepository
     */
    protected $agent;

    protected $upload_path;

    protected $storage;
    /**
     * @var \Illuminate\Session\Store
     */
    private $session;

    /**
     * @param \App\Repositories\Frontend\Agents\AgentsRepository $agent
     * @param \Illuminate\Session\Store                          $session
     */
    public function __construct(AgentsRepository $agent, Store $session)
    {
        $this->agent = $agent;
        $this->upload_path = 'img' . \DIRECTORY_SEPARATOR . 'agent' . \DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('s3');
        $this->session = $session;
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function index(ManageAgentsRequest $request)
    {
        return view('frontend.agents.index')->with([
            'status'     => $this->status,
            'body_class' => $this::BODY_CLASS,
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
    public function create(ManageAgentsRequest $request)
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
    public function store(Request $request)
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
    public function edit(Agent $agent, ManageAgentsRequest $request)
    {
        return view('frontend.agents.edit')->with([
            'agent'               => $agent,
            'status'              => $this->status,
            'body_class'          => $this::BODY_CLASS,
        ]);
    }

    public function editAgent($id)
    {
        $agent = DB::table('agents')->where('id', $id)->first();

        return view('frontend.agents.edit')->with([
            'agent'               => $agent,
            'status'              => $this->status,
            'body_class'          => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Agents\Agent                               $agent
     * @param \App\Http\Requests\Frontend\Agents\UpdateAgentsRequest $request
     *
     * @return mixed
     */
    public function update(Agent $agent, UpdateAgentsRequest $request)
    {
        $input = $request->all();

        $this->agent->update($agent, $request->except(['_token', '_method']));

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.updated'));
    }

    public function updateAgent($id, Request $request)
    {
        $this->agent->doUpdate($id, $request);

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
    public function destroy(Agent $agent, ManageAgentsRequest $request)
    {
        $this->agent->delete($agent);

        return redirect()
            ->route('admin.agents.index')
            ->with('flash_success', trans('alerts.frontend.agents.deleted'));
    }

    public function status($id)
    {
        $this->agent->updateStatus($id);
        $this->session->put('agent_id', $id);

        return redirect()->back();
    }

    public function delete($id)
    {
        /**** Delete Agent and Assign offers/messages to another agent ****/
        $this->agent->deleteAgent($id);

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
