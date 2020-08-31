<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;
use Tms\Readinglist;
use Tms\ReadinglistNotes;
use DB;

class DBReadinglistRepository implements ReadinglistRepositoryInterface
{
    public function listAll($userID, Request $request)
    {
        $page = $request->input('page');
        $limit = $request->input('rows');
        $sidx = $request->input('sidx');
        $sord = $request->input('sord');
        if (!$sidx) {
            $sidx = 1;
        }

        $where = "WHERE (status = 'Reading' OR status = 'Pending')";
        if ($request->input('_search') === 'true') {
            $status = $request->input('status');
            $where = ($status === 'All') ? "" : " WHERE status = '$status' ";
        }

        if(!$where) {
            $where .= "WHERE user_id = '$userID'";
        } else {
            $where .= " AND user_id = '$userID'";
        }

        //$where .= " AND user_id = '$userID'";

        $count = DB::select("SELECT COUNT(*) AS count FROM readinglist " . $where);
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
        $s["rows"] = DB::select("SELECT * FROM readinglist " . $where . "ORDER BY " . $sidx . " " . $sord . " LIMIT " . $start . ", " . $limit);

        return response()->json($s);
        // return $s;
    }

    public function edit($id, $params)
    {
        $readinglist = Readinglist::findOrFail($id);
        extract($params);
        $readinglist->title = $title;
        $readinglist->category = $category;
        $readinglist->priority = $priority;
        $readinglist->status = $status;

        $readinglist->save();
    }

    public function add($params)
    {
        $readinglist = new Readinglist();
        extract($params);
        $readinglist->title = $title;
        $readinglist->category = $category;
        $readinglist->priority = $priority;
        $readinglist->status = $status;
        $readinglist->user_id = $user_id;

        $readinglist->save();
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @todo delete notes on title removal
     */
    public function delete($id)
    {
        $readinglist = Readinglist::findOrFail($id);
        $notes = ReadingListNotes::where('bid', $id)->delete();
        $readinglist->delete();
    }

    public function getTitle($id)
    {
        $readinglist = ReadingList::findOrFail($id);
        return $readinglist->title;
    }
}
