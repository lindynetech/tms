<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\ReadinglistRepositoryInterface;
use Tms\Repositories\ReadinglistNotesRepositoryInterface;
use Tms\Traits\CommonTrait;

class ReadingListController extends Controller
{
    use CommonTrait;

    public function __construct(
        Request $request,
        ReadinglistRepositoryInterface $readinglist,
        ReadinglistNotesRepositoryInterface $notes
    ) {
        $this->request = $request;
        $this->readinglist = $readinglist;
        $this->notes = $notes;
    }
    public function index()
    {
        return view('tms.readinglist');
    }

    public function listAll()
    {
        return $this->readinglist->listAll($this->getUserID(), $this->request);
    }

    public function edit()
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $id = $this->request->input('id');

        $title = $this->request->input('title');
        $category = $this->request->input('category');
        $priority = $this->request->input('priority');
        $status = $this->request->input('status');
        $user_id = $this->getUserID();

        $params = ['title' => $title,
                   'category' => $category,
                   'priority' => $priority,
                   'status' => $status,
                   'user_id' => $user_id
        ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->readinglist->add($params);
                    break;
                case "edit":
                    $this->readinglist->edit($id, $params);
                    break;
                case "del":
                    $this->readinglist->delete($id);
                    break;
            }
        } else {
            return null;
        }
    }

    public function viewNotes()
    {
        $bid = $this->request->input('id');
        $title = $this->readinglist->getTitle($bid);
        $notes = $this->notes->listAll($bid);
        return view('tms.readinglist_notes', compact('bid', 'title', 'notes'));
    }

    public function editNotes()
    {
        if (!filter_has_var(INPUT_POST, 'mode')) {
            exit();
        }
        $mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
        $nid = filter_input(INPUT_POST, 'nid', FILTER_VALIDATE_INT, array('min_range' => 1));
        $bid = filter_input(INPUT_POST, 'bid', FILTER_VALIDATE_INT, array('min_range' => 1));

        $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
        $description = (isset($_POST['description'])) ? trim($_POST['description']) : '';

        switch ($mode) {
            case 'deleteNote':
                $this->notes->delete($nid);
                break;
            case 'editNote':
                $params = [
                            'nid' => $nid,
                            'note' => $note,
                            'description' => $description
                            ];
                $this->notes->edit($params);
                break;
            case 'addNote':
                $params = [
                            'bid' => $bid,
                            'note' => $note,
                            'description' => $description
                            ];
                $this->notes->add($params);
                break;
        }
    }
}
