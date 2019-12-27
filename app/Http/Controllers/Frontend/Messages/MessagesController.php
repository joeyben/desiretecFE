<?php

namespace App\Http\Controllers\Frontend\Messages;

use App\Events\Frontend\Messages\MessageCreated;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Agents\Agent;
use App\Models\Messages\Message;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{
    /**
     * @var \Illuminate\Session\Store
     */
    private $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function index($wish_id)
    {
        $id = Auth::id();

        $messages = Message::where('user_id', '=', $id)
                    ->where('wish_id', '=', $wish_id)
                    ->get();

        $userName = User::where('id', '=', $id)->first()->first_name;

        $response = [
            'data'      => $messages,
            'user_name' => $userName
        ];

        return response()->json($response);
    }

    public function sendMessage(Request $request)
    {
        $consumerId = $request->user_id;
        $message = $request->input('message');
        $id = Auth::id();

        $agent = $this->session->get('agent_id');

        if (!$this->session->has('agent_id')) {
            $agent = Agent::where('user_id', $id)->where('status', 'Active')->value('id');
        }

        $message = Message::create([
            'user_id' => $consumerId,
            'wish_id' => $request->wish_id,
            'message' => $message,
            'agent_id'=> $agent
        ]);

        if ($message) {
            event(new MessageCreated($message));
        }

        return ['status' => 'Message Sent!'];
    }

    public function getMessages($wish, $group)
    {
        $sellers = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                        ->join('groups', 'group_user.group_id', '=', 'groups.id')
                        ->where('group_user.group_id', '=', $group)
                        ->pluck('user_id');

        $ids = $sellers->toArray();

        $agents = Agent::whereIn('user_id', $ids)->pluck('id');
        $agentsId = $agents->toArray();

        $id = Auth::id();

        if (\in_array($id, $ids, true)) {
            $user = Agent::where('user_id', '=', $id)
                            ->where('status', 'Active')
                            ->value('display_name');
        } else {
            $user = User::where('id', '=', $id)->first()->first_name;
        }

        $userMessages = User::join('message', 'users.id', '=', 'message.user_id')
                        ->whereNotIn('user_id', $ids)
                        ->where('wish_id', '=', $wish)
                        ->get();

        $agentMessages = Agent::join('message', 'agents.id', '=', 'message.agent_id')
                                ->whereIn('agent_id', $agentsId)
                                ->where('wish_id', '=', $wish)
                                ->get();

        $path = Storage::disk('s3')->url('img/agent/');
        foreach ($agentMessages as $agentMessage) {
            $agentMessage['avatar'] = $path . $agentMessage['avatar'];
        }

        $messages = array_merge($userMessages->toArray(), $agentMessages->toArray());
        array_multisort(array_column($messages, 'created_at'), SORT_ASC, $messages);
        $response = [
            'data'   => $messages,
            'user'   => $user,
        ];

        return response()->json($response);
    }

    public function deleteMessage($id)
    {
        Message::find($id)->delete();
    }

    public function editMessage(Request $request)
    {
        $m = Message::find($request->input('id'));

        $m->message = $request->input('message');

        $m->save();
    }
}
