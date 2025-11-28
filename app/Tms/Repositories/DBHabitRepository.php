<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;
use Tms\Repositories\HabitRepositoryInterface;
use Tms\Habit;
use Tms\HabitDays;

class DBHabitRepository implements HabitRepositoryInterface
{
    public function listAll($userID, Request $request)
    {
        $status = ["All", "Developed"];
        if ($request->input('_search') === 'true') {
            $status = $request->input('status');
            return ($status === 'All' ) ? Habit::orderBy('created_at', 'asc')->get() : Habit::where('status', $status)->orderBy('created_at', 'asc')->get();
        }

        return Habit::where('user_id', $userID)
                    ->whereNotIn('status', $status)->orderBy('created_at', 'asc')->get();
    }

    public function edit($id, $params)
    {
        $habit = Habit::findOrFail($id);
        extract($params);
        $habit->start = $start;
        $habit->name = $name;
        $habit->freq = $freq;
        $habit->status = $status;

        $habit->save();
    }

    public function add($params)
    {
        $habit = new Habit();
        extract($params);
        $habit->start = $start;
        $habit->name = $name;
        $habit->freq = $freq;
        $habit->status = $status;
        $habit->user_id = $user_id;
        
        $habit->save();
    }

    public function delete($id)
    {
        $habit = Habit::findOrFail($id);
        $habits = HabitDays::where('hid', $id)->delete();
        $habit->delete();
    }

    public function getHabitValue($id, $value)
    {
        $habit = Habit::findOrFail($id);
        return $habit->$value;
    }

    public function getHabitInfo($id)
    {
        return Habit::where('id', $id)->get();
    }
}
