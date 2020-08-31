<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\MindstormRepositoryInterface;
use Tms\Repositories\MindstormIdeasRepositoryInterface;
use Tms\Traits\CommonTrait;

class MindstormController extends Controller
{
    use CommonTrait;

    public function __construct(
        MindstormRepositoryInterface $mindstorm,
        MindstormIdeasRepositoryInterface $ideas,
        Request $request
    ) {
        $this->mindstorm = $mindstorm;
        $this->ideas = $ideas;
        $this->request = $request;
    }
    public function index()
    {
        return view('tms.mindstorm');
    }

    public function listAll()
    {
        return $this->mindstorm->listAll($this->getUserID(), $this->request);
    }

    public function edit()
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $id = $this->request->input('id');

        $question = $this->request->input('question');
        $smart = $this->request->input('smart');
        $status = $this->request->input('status');
        $user_id = $this->getUserID();

        $params = ['question' => $question,
                   'smart' => $smart,
                   'status' => $status,
                   'user_id' => $user_id
        ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->mindstorm->add($params);
                    break;
                case "edit":
                    $this->mindstorm->edit($id, $params);
                    break;
                case "del":
                    $this->mindstorm->delete($id);
                    break;
            }
        } else {
            return null;
        }
    }

    public function listIdeas()
    {
        $rid = $this->request->input('id');
        $question = $this->mindstorm->getQuestionName($rid);
        return view('tms.mindstorm_ideas', compact('rid', 'question'));
    }

    public function listAllIdeas($id)
    {
        return $this->ideas->listAll($id);
    }

    public function editIdeas($gid)
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $id = $this->request->input('id');

        $idea = $this->request->input('idea');
        $priority = $this->request->input('priority');
        $urgency = $this->request->input('urgency');

        $params = ['gid' => $gid,
                   'idea' => $idea,
                   'priority' => $priority,
                   'urgency' => $urgency
        ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->ideas->add($params);
                    break;
                case "edit":
                    $this->ideas->edit($id, $params);
                    break;
                case "del":
                    $this->ideas->delete($id);
                    break;
            }
        } else {
            return null;
        }
    }
}
