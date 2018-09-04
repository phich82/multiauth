<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * show DatePicker
     *
     * @return Illuminate\View\View|Illuminate\Contracts\View\Factory
     */
    public function showDatePicker()
    {
        return view('datepicker');
    }
}
