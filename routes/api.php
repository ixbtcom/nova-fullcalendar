<?php

use App\Projects\Gametech\GTNews;
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
Route::get('/events', function (Request $request) {

    $type = auth()->user()->flags['calendar'] ?: 'App\Projects\Gametech\GTNews';
    $config = ['resourceBaseUrl' => Nova::resourceForModel($type)::uriKey()];
    $events = $type::select('id','title','pubdatetime')->whereBetween('pubdatetime',[\Carbon\Carbon::now()->startOfYear()->timestamp, \Carbon\Carbon::now()->endOfYear()->addMonths(3)->timestamp])->get();
    return response()->json(['events' => $events, 'config' => $config]);
});
Route::get('/events/{type}', function (Request $request, $type = 'App\Projects\Gametech\GTNews') {

    $events = $type::whereBetween('pubdatetime',[\Carbon\Carbon::now()->startOfMonth()->timestamp, \Carbon\Carbon::now()->endOfMonth()->timestamp])->get();
    return response()->json($events);
});
// Route::get('/endpoint', function (Request $request) {
//     //
// });
