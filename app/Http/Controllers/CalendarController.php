<?php

namespace App\Http\Controllers;

use App\SpaiClass;
use App\SpaiLesson;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function calendar(Request $request)
    {
        $selected_class1 = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('class1'));
        $selected_class2 = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('class2'));

        $databaseEvents = SpaiLesson::where('classe',$selected_class1)->orWhere('classe',$selected_class2)->get();
        $classes = SpaiClass::all();

        $sortedclass = [];
        foreach ($classes as $cla)
        {
            array_push($sortedclass,$cla->class);
        }
        array_multisort($sortedclass);

        $calendar = \Calendar::addEvents($databaseEvents);

        return view('calendar_parts/calendar_body', compact('calendar','sortedclass','selected_class1','selected_class2'));
    }
}
