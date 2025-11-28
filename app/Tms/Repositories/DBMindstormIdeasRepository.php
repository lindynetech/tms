<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;
use Tms\Repositories\MindstormIdeasRepositoryInterface;
use Tms\MindstormIdea;
use DB;

class DBMindstormIdeasRepository implements MindstormIdeasRepositoryInterface
{
    public function listAll($id)
    {
        return MindstormIdea::where('gid', $id)
                            ->orderBy('priority', 'asc')
                            ->orderBy('urgency', 'asc')
                            ->get();
    }

    public function edit($id, $params)
    {
        $ideaE = MindstormIdea::findOrFail($id);
        extract($params);
        $ideaE->idea = $idea;
        $ideaE->priority = $priority;
        $ideaE->urgency = $urgency;

        $ideaE->save();
    }

    public function add($params)
    {
        $ideaA = new MindstormIdea();
        extract($params);
        $ideaA->gid = $gid;
        $ideaA->idea = $idea;
        $ideaA->priority = $priority;
        $ideaA->urgency = $urgency;

        $ideaA->save();
    }

    public function delete($id)
    {
        $idea = MindstormIdea::findOrFail($id);
        $idea->delete();
    }
}
