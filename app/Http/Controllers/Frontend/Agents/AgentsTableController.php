<?php

namespace App\Http\Controllers\Frontend\Agents;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Frontend\Agents\ManageAgentsRequest;
// use App\Repositories\Frontend\Agents\AgentsRepository;
// use Illuminate\Support\Facades\Storage;
// use Yajra\DataTables\Facades\DataTables;

/**
 * Class AgentsTableController.
 */
class AgentsTableController extends Controller
{
    protected $agents;

    /**
     * @param \App\Repositories\Frontend\Agents\AgentsRepository $cmspages
     */
    public function __construct()
    {
        // $this->agents = $agents;
    }

    /**
     * @param \App\Http\Requests\Frontend\Agents\ManageAgentsRequest $request
     *
     * @return mixed
     */
    public function __invoke()
    {
        $hardcoded = array('
            {
              "id": "108",
              "name": "Johanna Eder",
              "avatar": "<img src=\"https://desiretec.s3.eu-central-1.amazonaws.com/img/agent/1569506944wAvatarCallCenter2.png\"/>",
              "display_name": "",
              "status": "Active",
              "user_id": "1891",
              "created_at": "Sep 26, 2019 16:09:04",
              "actions": "<a href=\"/agents/edit\">Ändern</a> / <a href=\"/agents/delete\">Löschen</a>"
            }
        ');

        foreach ($hardcoded as $item) {
            $data[] = json_decode($item);
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
