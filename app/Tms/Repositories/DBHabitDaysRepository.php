<?php

namespace Tms\Repositories;

use Illuminate\Http\Request;
use Tms\HabitDays;
use Tms\Repositories\HabitRepositoryInterface;

class DBHabitDaysRepository
{
    public function __construct(HabitRepositoryInterface $habit)
    {
        $this->habit = $habit;
    }

    public function getHabitDays($id)
    {
        return HabitDays::where('hid', $id)
                        ->orderBy('date', 'asc')
                        ->get();
    }

    public function populateHabit($id, $start)
    {
        $freq = $this->habit->getHabitValue($id, 'freq');
        $date = \DateTime::createFromFormat('Y-m-d', $start);
        for ($i = 1; $i <= 21; $i++) {
            $day = $date->format('Y-m-d');
            $habitDays = new HabitDays;
            $habitDays->hid = $id;
            $habitDays->date = $day;
            $habitDays->day = $i;

            $habitDays->save();

            switch ($freq) {
                case "Daily":
                    $day = $date->modify('+1 day');
                    break;
                case "Weekly":
                    $day = $date->modify('+7 day');
                    break;
                case "Monthly":
                    $day = $date->modify('+30 day');
                    break;
                default:
                    $day = $date->modify('+1 day');
                    break;
            }
        }
    }

    public function resetHabit($id)
    {
        HabitDays::where('hid', $id)->delete();
       /* $freq = $this->habit->getHabitValue($id, 'freq');*/
        /*$start = $this->habit->getHabitValue($id, 'start');
        $this->populateHabit($id, $start);
        return $this->getHabitDays($id);*/
    }

    public function saveHabit($dayId, $timeSet, $chkVal)
    {
        $habitDays = HabitDays::find($dayId);
        $habitDays->time = $timeSet;
        $habitDays->check = $chkVal;
        $habitDays->save();
        return json_encode(['dayId' => $dayId, 'timeSet' => $timeSet, 'chkVal' => $chkVal, 'status' => 'Saved']);
    }
}
