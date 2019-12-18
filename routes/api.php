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
    $events = GTNews::all();
    return response()->json($events);
});
// Route::get('/endpoint', function (Request $request) {
//     //
// });
