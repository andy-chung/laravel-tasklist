<?php

/*
|--------------------------------------------------------------------------
| added dev
*/
use App\Models\Task;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
/*--------------------------------------------------------------------------*/


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*********
Route::get('/', function () {
    return view('welcome');
});
********/


Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });

    /**
     * Add New Task
     */
    Route::post('/task', function (Request $request) {
        // $validator = Validator::make($request->all(), [
        $validator = $request->validate([
            'name' => 'required|max:255',
        ]);

    /**---------------------------------------
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
     ---------------------------------*/

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/');
    });

    /**
     * Delete Task
     */
    Route::delete('/task/{id}', function ($id) {
        Task::findOrFail($id)->delete();

        return redirect('/');
    });
});
