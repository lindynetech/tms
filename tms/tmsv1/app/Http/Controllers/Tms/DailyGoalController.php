<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\DailyGoalRepositoryInterface;

class DailyGoalController extends Controller
{
    public function __construct(DailyGoalRepositoryInterface $goal, Request $request)
    {
        $this->goal = $goal;
        $this->request = $request;
    }
    public function index()
    {
        return view('tms.dailygoals');
    }

    public function listAll()
    {
        return $this->goal->listAll();
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

        $params = ['goal' => $goal,
                   'type' => $type,
                   'priority' => $priority,
                   'urgency' => $urgency,
                   'deadline' => $deadline,
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

    public function flush()
    {
        $this->goal->flush();
    }
}
