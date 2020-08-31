<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use Tms\Traits\CommonTrait;
use App\Http\Controllers\Controller;
use Tms\Repositories\GoalRepositoryInterface;

class GoalController extends Controller
{
    use CommonTrait;

    public function __construct(GoalRepositoryInterface $goal, Request $request)
    {
        $this->goal = $goal;
        $this->request = $request;
    }
    public function index()
    {
        return view('tms.goals');
    }

    public function listAll()
    {
        return $this->goal->listAll($this->getUserID(), $this->request);
    }

    public function listSingle($id)
    {
        return $this->goal->listSingle($id);
    }

    public function edit()
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $gid = $this->request->input('id');

        $goal = $this->request->input('goal');
        $type = $this->request->input('type');
        $priority = $this->request->input('priority');
        $urgency = $this->request->input('urgency');
        $deadline = $this->request->input('deadline');
        $stage = $this->request->input('stage');
        $status = $this->request->input('status');
        $smart = $this->request->input('smart');
        $user_id = $this->getUserID();

        $params = ['goal' => $goal,
                   'type' => $type,
                   'priority' => $priority,
                   'urgency' => $urgency,
                   'deadline' => $deadline,
                   'stage' => $stage,
                   'status' => $status,
                   'smart' => $smart,
                   'user_id' => $user_id
        ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->goal->add($params);
                    break;
                case "edit":
                    $this->goal->edit($gid, $params);
                    break;
                case "del":
                    $this->goal->delete($gid);
                    break;
            }
        } else {
            return null;
        }
    }

    public function getProperties($gid, $value)
    {
        return $this->goal->getProperties($gid, $value);
    }
}
