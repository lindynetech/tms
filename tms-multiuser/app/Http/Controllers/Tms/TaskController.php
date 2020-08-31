<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\GoalRepositoryInterface;
use Tms\Repositories\TaskRepositoryInterface;
use Tms\Repositories\VendorRepositoryInterface;
use Tms\Traits\CommonTrait;

class TaskController extends Controller
{
    use CommonTrait;

    public function __construct(
        TaskRepositoryInterface $tasks,
        GoalRepositoryInterface $goal,
        VendorRepositoryInterface $vendor,
        Request $request
    ) {
        $this->tasks = $tasks;
        $this->goal = $goal;
        $this->request = $request;
        $this->vendor = $vendor;
    }

    public function index($gid = null)
    {
        //dd($this->getUserID());
        if (empty($this->vendor->getVendorsList($this->getUserID()))) {
            return redirect('/vendors')->with('vendorStatus', 'Please add at least one vendor/assignee before adding tasks, you can start by adding yourself first.');
        }

        $gid = ($gid === null ) ? $this->request->input('id') : $gid;
        $vendors_list = $this->vendor->getVendorsList($this->getUserID());
        $goalName = $this->goal->getProperties($gid, "goal");
        $goalStage = $this->goal->getProperties($gid, "stage");
        $goalStatus = $this->goal->getProperties($gid, "status");
        $goalDeadline = $this->goal->getProperties($gid, "deadline");
        $goalSmart = $this->goal->getProperties($gid, "smart");
        $goalProgress = $this->goal->getProgress($gid);

        return view('tms.tasks', compact('gid', 'progress', 'vendors_list', 'goalName', 'goalStage', 'goalStatus', 'goalDeadline', 'goalSmart', 'goalProgress'));
    }

    public function listAll($id)
    {
        //dd($this->tasks->listAll($id, $this->vendor, $this->request));
        return $this->tasks->listAll($id, $this->vendor, $this->request);
    }

    public function edit($id)
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $tid = $this->request->input('id');

        $task = $this->request->input('task');
        $type = $this->request->input('type');
        $priority = $this->request->input('priority');
        $urgency = $this->request->input('urgency');
        $deadline = $this->request->input('deadline');
        $start = $this->request->input('start');
        $status = $this->request->input('status');
        $vid = $this->request->input('vid');

        $params = ['gid' => $id,
                   'task' => $task,
                   'type' => $type,
                   'priority' => $priority,
                   'urgency' => $urgency,
                   'deadline' => $deadline,
                   'start' => $start,
                   'status' => $status,
                   'vid' => $vid
        ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->tasks->add($params);
                    break;
                case "edit":
                    $this->tasks->edit($tid, $params);
                    break;
                case "del":
                    $this->tasks->delete($tid);
                    break;
            }
        } else {
            return null;
        }
    }

    public function listSubtasks($tid)
    {
        return $this->tasks->listSubtasks($tid);
    }

    public function editSubtasks($tid)
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $sid = $this->request->input('id');

        $subtask = $this->request->input('subtask');
        $priority = $this->request->input('priority');
        $urgency = $this->request->input('urgency');
        $deadline = $this->request->input('deadline');
        $start = $this->request->input('start');
        $status = $this->request->input('status');

        $params = ['tid' => $tid,
                   'subtask' => $subtask,
                   'priority' => $priority,
                   'urgency' => $urgency,
                   'deadline' => $deadline,
                   'start' => $start,
                   'status' => $status
        ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->tasks->addSubtask($params);
                    break;
                case "edit":
                    $this->tasks->editSubtask($sid, $params);
                    break;
                case "del":
                    $this->tasks->deleteSubtask($sid);
                    break;
            }
        } else {
            return null;
        }
    }

    public function viewFrogGoal()
    {
        try {
            $frogId = $this->goal->getFrogGoal($this->getUserID());
            return $this->index($frogId);
        } catch (\Exception $e) {
            $message = "<b>Please define at least one goal with:<br> priority - A, urgency - 1 | <a href=\"/goals\">Go to goals</a></b>";
            return view('errors.404')->with('message', $message);
        }
    }
}
