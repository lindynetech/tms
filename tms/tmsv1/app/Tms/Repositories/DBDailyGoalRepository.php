<?php

namespace Tms\Repositories;

use Tms\Repositories\DailyGoalRepositoryInterface;
use Tms\DailyGoal;

class DBDailyGoalRepository implements DailyGoalRepositoryInterface
{
    public function listAll()
    {
        return DailyGoal::orderBy('priority', 'asc')
                        ->orderBy('urgency', 'asc')
                        ->get();
    }

    public function edit($id, $params)
    {
        $dailygoal = DailyGoal::findOrFail($id);
        extract($params);
        $dailygoal->type = $type;
        $dailygoal->goal = $goal;
        $dailygoal->priority = $priority;
        $dailygoal->urgency = $urgency;
        $dailygoal->deadline = $deadline;

        $dailygoal->save();
    }

    public function add($params)
    {
        $dailygoal = new DailyGoal();
        extract($params);
        $dailygoal->type = $type;
        $dailygoal->goal = $goal;
        $dailygoal->priority = $priority;
        $dailygoal->urgency = $urgency;
        $dailygoal->deadline = $deadline;

        $dailygoal->save();
    }

    public function delete($id)
    {
        $dailygoal = DailyGoal::findOrFail($id);
        $dailygoal->delete();
    }

    public function flush()
    {
        DailyGoal::truncate();
    }
}
