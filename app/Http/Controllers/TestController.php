<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TestController extends Controller
{
    public function __construct()
    {
        // check if session expired for ajax request
        $this->middleware('ajax-session-expired');

        // check if user is autenticated for non-ajax request
        //$this->middleware('auth');
    }

    /**
     * show DatePicker
     *
     * @return Illuminate\View\View|Illuminate\Contracts\View\Factory
     */
    public function showDatePicker()
    {
        return view('datepicker');
    }

    public function sessionExpired()
    {
        return 'Hello';
    }

    public function ajaxSessionExpired()
    {
        return view('ajax-session-expired');
    }

    public function postSessionExpired(Request $request)
    {
        return response()->json(['data' => $request->all()]);
    }

    public function testCarbon()
    {
        $year = 2018;
        $month = 9;
        $oDate = Carbon::create($year, $month, 1);
        $workDays = [];
        $closestDates = [];
        $holidays = [1, 5, 14, 28, 31];
        $lastDayOfMonth = $oDate->daysInMonth; // last day of month
        //echo 'Last day of month: '.$lastDayOfMonth."<br>";
        for ($s = 1; $s <= $lastDayOfMonth; $s++) {
            $o = Carbon::create($year, $month, $s);

            if (in_array($o->dayOfWeek, [0, 6])) { // sunday or saturday
                if ($lastDayOfMonth === $s) { // last day of month falls in sunday or saturday
                    $closestDates[] = end($workDays);
                }
            } elseif ($o->dayOfWeek === 5) { // friday
                // weekNumberInMonth: if the month start with a sunday, then it considers as week 1
                // weekOfMonth: otherwise, for the 7 first days of the month
                if ($o->weekNumberInMonth === 3) { // 3th week of month (weekOfMonth)
                    // if holidays, get closest date
                    $closestDates[] = in_array($s, $holidays) ? end($workDays) : $s;
                } elseif ($lastDayOfMonth === $s) { // last day of month falls in friday
                    // if holidays, get closest date
                    $closestDates[] = in_array($s, $holidays) ? end($workDays) : $s;
                } elseif (!in_array($s, $holidays)) { // store work days except holidays
                    $workDays[] = $s;
                }
            } elseif ($lastDayOfMonth === $s) { // last day of month
                // if holidays, get closest date
                $closestDates[] = in_array($s, $holidays) ? end($workDays) : $s;
            } elseif (!in_array($s, $holidays)) { // store work days except holidays
                $workDays[] = $s;
            }
        }
        dd($workDays, $closestDates);
        return $closestDates;
    }

    private function getClosestDates($year, $month, $holidays = [])
    {
        $oDate = Carbon::create($year, $month, 1);
        $lastDayOfMonth = $oDate->daysInMonth; // last day of month
        $workDays = [];
        $closestDates = [];

        //echo 'Last day of month: '.$lastDayOfMonth."<br>";
        for ($s = 1; $s <= $lastDayOfMonth; $s++) {
            $o = Carbon::create($year, $month, $s);

            if (in_array($o->dayOfWeek, [0, 6])) { // sunday or saturday
                if ($lastDayOfMonth === $s) { // last day of month falls in sunday or saturday
                    $closestDates[] = end($workDays);
                }
            } elseif ($o->dayOfWeek === 5) { // friday
                // weekNumberInMonth: if the month start with a sunday, then it considers as week 1
                // weekOfMonth: otherwise, for the 7 first days of the month
                if ($o->weekNumberInMonth === 3) { // 3th week of month (weekOfMonth)
                    // if holidays, get closest date
                    $closestDates[] = in_array($s, $holidays) ? end($workDays) : $s;
                } elseif ($lastDayOfMonth === $s) { // last day of month falls in friday
                    // if holidays, get closest date
                    $closestDates[] = in_array($s, $holidays) ? end($workDays) : $s;
                } else { // store work days
                    $workDays[] = $s;
                }
            } elseif ($lastDayOfMonth === $s) { // last day of month
                // if holidays, get closest date
                $closestDates[] = in_array($s, $holidays) ? end($workDays) : $s;
            } elseif (!in_array($s, $holidays)) { // store work days except holidays
                $workDays[] = $s;
            }
        }
        return $closestDates;
    }
}
