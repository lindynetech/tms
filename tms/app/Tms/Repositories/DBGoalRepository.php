<?php

namespace Tms\Repositories;

use Tms\Repositories\GoalRepositoryInterface;
use Tms\Goal;
use Tms\Task;
use Tms\Subtask;
use Illuminate\Http\Request;
use DB;

class DBGoalRepository implements GoalRepositoryInterface
{
    public function listAll(Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('rows');
        $sidx = $request->input('sidx');
        $sord = $request->input('sord');
        if (!$sidx) {
            $sidx = 1;
        }

        $where = "WHERE NOT (status = 'Complete' or status = 'Cancelled')";
        if ($request->input('_search') === 'true') {
            $status = $request->input('status');
            $type = $request->input('type');

            if ($type && !$status) {
                $where = "WHERE type = '$type' AND NOT (status = 'Complete' or status = 'Cancelled')";
            } elseif ($status && !$type) {
                $where = ($status === 'All') ? "" : "WHERE status = '$status'";
            } elseif ($type && $status) {
                $where = "WHERE type = '$type'";
                $where .= ($status === 'All') ? "" : " AND status = '$status'";
            }
        }

        $count = DB::select("SELECT COUNT(*) AS count FROM goals " . $where);
        $count = $count[0]->count;

        if ($count > 0 && $limit > 0) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $start = $limit*$page - $limit;
        if ($start <0) {
            $start = 0;
        }

        $s = ["total" => $total_pages,
              "page" => $page,
              "records" => $count,
              "rows" => []];
        $s["rows"] = DB::select("SELECT * FROM goals " . $where . "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit);

        $data = [];
        $rows =[];

        foreach ($s["rows"] as $row) {
            $gid = $row->id;
            $progress = $this->getProgress($gid);
            $data["id"] = $row->id;
            $data["created_at"] = $row->created_at;
            $data["goal"] = $row->goal;
            $data["type"] = $row->type;
            $data["priority"] = $row->priority;
            $data["urgency"] = $row->urgency;
            $data["deadline"] = $row->deadline;
            $data["stage"] =  $row->stage;
            $data["status"] = $row->status;
            $data["smart"] = $row->smart;
            $data["progress"] = '<div class="progress progress-xs"><div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="'.$progress.'%" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%"><span class="sr-only">'.$progress.'% Complete</span></div></div>';
            array_push($rows, $data);
        }

        $s["rows"] = $rows;

        return $s;
    }

    public function listSingle($id)
    {
        $s = ["total" => 1,
              "page" => 1,
              "records" => 1,
              "rows" => []];
        $s["rows"] = DB::select("SELECT * FROM goals WHERE id = $id");

        $data = [];
        $rows =[];
        $row = $s["rows"][0];

        $gid = $row->id;
        $progress = $this->getProgress($gid);
        $data["id"] = $row->id;
        $data["created_at"] = $row->created_at;
        $data["goal"] = $row->goal;
        $data["type"] = $row->type;
        $data["priority"] = $row->priority;
        $data["urgency"] = $row->urgency;
        $data["deadline"] = $row->deadline;
        $data["stage"] =  $row->stage;
        $data["status"] = $row->status;
        $data["smart"] = $row->smart;
        $data["progress"] = '<div class="progress progress-xs"><div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="'.$progress.'%" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%"><span class="sr-only">'.$progress.'% Complete</span></div></div>';
        array_push($rows, $data);

        $s["rows"] = $rows;

        return $s;

    }

    public function edit($id, $params)
    {
        $goals = Goal::findOrFail($id);
        extract($params);
        $goals->goal = $goal;
        $goals->type = $type;
        $goals->priority = $priority;
        $goals->urgency = $urgency;
        $goals->deadline = $deadline;
        $goals->stage = $stage;
        $goals->status = $status;
        $goals->smart = $smart;

        $goals->save();

    }

    public function add($params)
    {
        $goals = new Goal();
        extract($params);
        $goals->goal = $goal;
        $goals->type = $type;
        $goals->priority = $priority;
        $goals->urgency = $urgency;
        $goals->deadline = $deadline;
        $goals->stage = $stage;
        $goals->status = $status;
        $goals->smart = $smart;

        $goals->save();
    }

    public function delete($id)
    {
        //subtasks
        $ids = DB::select("SELECT id FROM goals_tasks WHERE gid = " . $id);
        foreach ($ids as $row) {
            $tid = $row->id;
            $subtask = Subtask::where('tid', $tid)->delete();
        }
        //tasks
        $tasksDelete = Task::where('gid', $id)->delete();

        //goal
        $goal = Goal::findOrFail($id);
        $goal->delete();
    }

    public function getProperties($gid, $value)
    {
        $goal = Goal::findOrFail($gid);
        return $goal->$value;
    }

    public function getProgress($gid)
    {

        $totalCount = DB::select("SELECT COUNT(*) AS count FROM goals_tasks WHERE gid = " . $gid);
        $totalTasks = $totalCount[0]->count;
        if ($totalTasks == 0) {
            return 0;
        }

        $completeCount = DB::select("SELECT COUNT(*) AS count FROM goals_tasks WHERE gid = $gid AND status = 'Complete'");
        $completeTasks = $completeCount[0]->count;
        if ($completeTasks == 0) {
            return 0;
        }

        if ($totalTasks > 0) {
            return round($percentage = ($completeTasks/$totalTasks)*100);
        }
        return 0;
    }

    public function getFrogGoal()
    {
        $q = Goal::where('priority', 'A')
            ->where('urgency', '1')
            ->where('stage', 'Execution')
            ->where('status', 'In Progress')
            ->where('status', '!=', 'Complete')
            ->first();

        $fig = $q->id;

        if ($fig) {
            return $fig;
        }

        throw new \Exception;
    }
}
