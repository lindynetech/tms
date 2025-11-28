<?php
/**
 * Home Controller
 */

namespace App\Http\Controllers;

use Tms\Repositories\GoalRepositoryInterface;
use Tms\Repositories\TaskRepositoryInterface;
use Tms\Traits\CommonTrait;

class HomeController extends Controller
{
    use CommonTrait;

    public function __construct(
        GoalRepositoryInterface $goal,
        TaskRepositoryInterface $tasks
    ) {
        $this->middleware('auth');
        $this->goal = $goal;
        $this->tasks = $tasks;
    }

    public function index()
    {
        try {
            $frogId = $this->goal->getFrogGoal($this->getUserID());
            $frogTasks = $this->tasks->listUncompleted($frogId);
            return view('tms.dashboard', compact('frogId', 'frogTasks'));
        } catch (\Exception $e) {
            $frogId = 0;
            $frogTasks = null;
            $frogMessage = "Please define at least one goal with: priority = A, urgency = 1 | <a href=\"/goals\">Go to goals</a>";
            return view('tms.dashboard', compact('frogId', 'frogTasks'))->with('frogMessage', $frogMessage);
        }
    }

    public function requestSupport()
    {
        return view('tms.support');
    }

    public function help(){
        return view('tms.help');
    }
    
}
