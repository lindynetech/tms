<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;
use Tms\Repositories\MindstormRepositoryInterface;
use Tms\Mindstorm;
use Tms\MindstormIdea;
use DB;

class DBMindstormRepository implements MindstormRepositoryInterface
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

        $where = "WHERE NOT (status = 'Complete')";
        if ($request->input('_search') === 'true') {
            $status = $request->input('status');
            $where = ($status === 'All') ? "" : " WHERE status = '$status' ";
        }

        $count = DB::select("SELECT COUNT(*) AS count FROM mindstorms " . $where);
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
        $s["rows"] = DB::select("SELECT * FROM mindstorms " . $where . "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit);

        return $s;
    }

    public function edit($id, $params)
    {
        $mindstorm = Mindstorm::findOrFail($id);
        extract($params);
        $mindstorm->question = $question;
        $mindstorm->smart = $smart;
        $mindstorm->status = $status;

        $mindstorm->save();
    }

    public function add($params)
    {
        $mindstorm = new Mindstorm();
        extract($params);
        $mindstorm->question = $question;
        $mindstorm->smart = $smart;
        $mindstorm->status = $status;

        $mindstorm->save();
    }

    public function delete($id)
    {
        $mindstorm = Mindstorm::findOrFail($id);
        $ideas = MindstormIdea::where('gid', $id)->delete();
        $mindstorm->delete();
    }

    public function getQuestionName($id)
    {
        $mindstorm = Mindstorm::findOrFail($id);
        return $mindstorm->question;
    }
}
