<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'activity' => ['required', 'string'],
            'uuid' => ['required'],
        ]);

        $this->recordActivity($request->activity, $request->uuid);
        return response()->json(['message' => 'Activity has been recorded'], 201);
    }

    protected function recordActivity($activity, $uuid)
    {
        $activities = [
            'view_category' => 'App\Models\Category',
            'view_product' => 'App\Models\Product',
            'add_to_cart' => 'App\Models\Product',
            'remove_from_cart' => 'App\Models\Product',
        ];

        if (! array_key_exists($activity, $activities)) {
            return response()->json(['message' => 'Activity not found!'], 404);
        }

        activity()->by(auth()->user())
                  ->on($subject = $activities[$activity]::whereUuid($uuid)->firstOrFail())
                  ->withProperties(['activity_type' => $activity])
                ->log(__("activity_logs.{$activity}", ['user' => auth()->user()->name, 'subject' => $subject->name]));
    }
}
