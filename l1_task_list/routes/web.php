<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use App\Http\Requests\TaskRequest;


Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function (){
    // $tasks = Task::latest()->get();

    // 10 elements per page
    $tasks = Task::latest()->paginate(10);
    return view('index',['tasks'=>$tasks]);
})->name('tasks.index');
Route::view('/tasks/create','create')->name('tasks.create');

// For Task model it will automatically seach the value from database
Route::get('/tasks/{task}/edit',function(Task $task){
    return view('edit',['task'=>$task]);
})->name('tasks.edit');

Route::get('/tasks/{id}',function($id){
    $task = Task::findOrFail($id);
    return view('show',['task'=>$task]);
})->name('tasks.show');

Route::put('/tasks/{task}', function(Task $task, TaskRequest $request){
    $data = $request->validated();
    // $task = Task::findOrFail($task);
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    $task->update($data);
                                                                    // Flash messages
    return redirect()->route('tasks.show',['id'=>$task->id])->with('success','Task Updated Successfully!');
})->name('tasks.update');

Route::post('/tasks', function(TaskRequest $request){
    $data = $request->validated();
    // $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    $task = Task::create($data);

                                                                    // Flash messages
    return redirect()->route('tasks.show',['id'=>$task->id])->with('success','Task Created Successfully!');
})->name('tasks.store');

Route::delete('/tasks/{task}',function(Task $task){
    $task->delete();
    return redirect()->route('tasks.index')->with('success','Task deleted successfully');
})->name('tasks.delete');

Route::put('/tasks/{task}/toggle-complete', function (Task $task){
    $task->toggleComplete();
    // back means previous router
    return redirect()->back()->with('success','Task updated successfully');
})->name('tasks.toggle-complete');
