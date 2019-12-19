<?php

use App\Projects\Gametech\GTNews;
use App\Nova\Projects\Gametech\GTPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/
Route::get('/calendars', function (Request $request) {
    $models = auth()->user()->flags['calendars'];
    $formatedCalendars = [];
    foreach($models as $model)
    {
        $resource = Nova::resourceForModel($model);
        $formatedCalendars[] =
            [
                'title' => $resource::label(),
                'url' => '/nova-vendor/fullcalendar/events/'.urlencode($model),
                'editUrl' => '/nova-vendor/fullcalendar/events/'.$resource::uriKey(),
                'resourceClass' => $resource,
                'modelClass' => $model,
            ];
    }
    $classes = get_declared_classes();
    $possibleCalendars = [];
    $allCalendars = [];


    foreach($classes as $resource)
    {
        if(is_subclass_of($resource, GTPublication::class)) {
            $model = $resource::getModelName();
           $possibleCalendars[] =
               [
                   'title' => $resource::label(),
                   'url' => '/nova-vendor/fullcalendar/events/'.urlencode($model),
                   'editUrl' => '/nova-vendor/fullcalendar/events/'.$resource::uriKey(),
                   'resourceClass' => $resource,
                   'modelClass' => $model,
               ];
        }
    }
    $allCalendars[] = ['resource' => 'Gametech', 'calendars' => $possibleCalendars ];

    return response()->json(['calendars' => $formatedCalendars, 'allcalendars' => $allCalendars] );
});

Route::get('/events/{type}', function (Request $request, $type = 'App\Projects\Gametech\GTNews') {

    //$type = auth()->user()->flags['calendar'] ?: 'App\Projects\Gametech\GTNews';
    $startDate = \Carbon\Carbon::parse($request->start)->timestamp;
    $endDate = \Carbon\Carbon::parse($request->end)->timestamp;


    $events = $type::select('id', 'title', 'pubdatetime as start', 'publish')->whereBetween('pubdatetime', [$startDate,$endDate ])->get();

    return response()->json($events);
});
// Route::get('/endpoint', function (Request $request) {
//     //
// });
