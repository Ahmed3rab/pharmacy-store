<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('activities.index')->with('activities', Activity::latest()->paginate(10));
    }

    public function show(Activity $activity)
    {
        return view('activities.show')->with('activity', $activity);
    }
}
