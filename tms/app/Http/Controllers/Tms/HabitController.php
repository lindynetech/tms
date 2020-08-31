<?php

namespace App\Http\Controllers\Tms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tms\Repositories\HabitRepositoryInterface;
use Tms\Repositories\DBHabitDaysRepository;

class HabitController extends Controller
{
    public function __construct(
        HabitRepositoryInterface $habit,
        DBHabitDaysRepository $habitdays,
        Request $request
    ) {
        $this->habit = $habit;
        $this->habitdays = $habitdays;
        $this->request = $request;
    }
    public function index()
    {
        return view('tms.habits');
    }

    public function listAll()
    {
        return $this->habit->listAll($this->request);
    }

    public function edit()
    {
        if ($this->request->has('oper')) {
            $action = $this->request->input('oper');
        } else {
            $action = null;
        }

        $id = $this->request->input('id');

        $start = $this->request->input('start');
        $name = $this->request->input('name');
        $freq = $this->request->input('freq');
        $status = $this->request->input('status');

        $params = ['start' => $start,
                   'name' => $name,
                   'freq' => $freq,
                   'status' => $status
                   ];

        if ($action !== null) {
            switch ($action) {
                case "add":
                    $this->habit->add($params);
                    break;
                case "edit":
                    $this->habit->edit($id, $params);
                    break;
                case "del":
                    $this->habit->delete($id);
                    break;
            }
        } else {
            return null;
        }
    }

    public function getHabitInfo()
    {
        $hid = $this->request->input('hid');
        return $this->habit->getHabitInfo($hid);
    }

    public function getHabitDays()
    {
        $hid = $this->request->input('hid');
        return $this->habitdays->getHabitDays($hid);
    }

    public function populateHabit()
    {
        $hid = $this->request->input('hid');
        $start = $this->request->input('start');
        $this->habitdays->populateHabit($hid, $start);
        return $this->habitdays->getHabitDays($hid);
    }

    public function resetHabit()
    {
        $hid = $this->request->input('hid');
        $this->habitdays->resetHabit($hid);
    }

    public function saveHabit()
    {
        $dayId = $this->request->input('dayId');
        $timeSet = $this->request->input('timeSet');
        $chkVal = $this->request->input('chkVal');

        return $this->habitdays->saveHabit($dayId, $timeSet, $chkVal);
    }
}
