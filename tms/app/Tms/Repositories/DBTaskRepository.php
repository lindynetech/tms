<?php

namespace Tms\Repositories;

use Tms\Task;
use Tms\Subtask;
use Tms\Repositories\VendorRepositoryInterface;
use Illuminate\Http\Request;
use DB;

class DBTaskRepository implements TaskRepositoryInterface
{
    public function listAll($id, VendorRepositoryInterface $vendor, Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('rows');
        $sidx = $request->input('sidx');
        $sord = $request->input('sord');
        if (!$sidx) {
            $sidx = 1;
        }

        $where = " AND NOT (status = 'Cancelled')";
        if ($request->input('_search') === 'true') {
            $status = $request->input('status');
            $where = ($status === 'All') ? "" : " AND status = '$status' ";
        }

        $count = DB::select("SELECT COUNT(*) AS count FROM goals_tasks WHERE gid = $id " . $where);
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
        $s["rows"] = DB::select("SELECT * FROM goals_tasks WHERE gid = $id " . $where . " ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit);

        $data = [];
        $rows =[];

        foreach ($s["rows"] as $row) {
            $data["id"] = $row->id;
            $data["created_at"] = $row->created_at;
            $data["task"] = $row->task;
            $data["type"] = $row->type;
            $data["priority"] = $row->priority;
            $data["urgency"] = $row->urgency;
            $data["start"] = $row->start;
            $data["deadline"] = $row->deadline;
            $data["vid"] =  $vendor->getVendorName($row->vid);
            $data["status"] = $row->status;
            array_push($rows, $data);
        }

        $s["rows"] = $rows;

        return $s;
    }

    public function edit($id, $params)
    {
        $tasks = Task::findOrFail($id);
        extract($params);
        $tasks->task = $task;
        $tasks->type = $type;
        $tasks->priority = $priority;
        $tasks->urgency = $urgency;
        $tasks->deadline = $deadline;
        $tasks->start = $start;
        $tasks->status = $status;
        $tasks->vid = $vid;

        $tasks->save();
    }

    public function add($params)
    {
        $tasks = new Task();
        extract($params);
        $tasks->gid = $gid;
        $tasks->task = $task;
        $tasks->type = $type;
        $tasks->priority = $priority;
        $tasks->urgency = $urgency;
        $tasks->deadline = $deadline;
        $tasks->start = $start;
        $tasks->status = $status;
        $tasks->vid = $vid;

        $tasks->save();
    }

    public function delete($id)
    {
        $tasks = Task::findOrFail($id);
        $tasks->delete();

        $subtasks = SubTask::where('tid', $id)->delete();
    }

    public function listSubtasks($id)
    {
        return Subtask::where('tid', $id)
                        ->orderBy('priority', 'asc')
                        ->orderBy('urgency', 'asc')
                        ->get();
    }

    public function editSubtask($id, $params)
    {
        $tasks = Subtask::findOrFail($id);
        extract($params);
        $tasks->subtask = $subtask;
        $tasks->priority = $priority;
        $tasks->urgency = $urgency;
        $tasks->deadline = $deadline;
        $tasks->start = $start;
        $tasks->status = $status;

        $tasks->save();
    }

    public function addSubtask($params)
    {
        $tasks = new Subtask();
        extract($params);
        $tasks->tid = $tid;
        $tasks->subtask = $subtask;
        $tasks->priority = $priority;
        $tasks->urgency = $urgency;
        $tasks->deadline = $deadline;
        $tasks->start = $start;
        $tasks->status = $status;

        $tasks->save();
    }

    public function deleteSubtask($id)
    {
        $subtask = Subtask::findOrFail($id);
        $subtask->delete();
    }

    public function listUncompleted($gid)
    {
        return Task::where('gid', $gid)
                    ->where('status', '!=', 'Complete')
                    ->where('status', '!=', 'Cancelled')
                    ->get();
    }
}
