<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Task\UpdateOnlyTwoInOneDay;
use App\Http\Requests\Task\CreateRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
 

class TasksController extends Controller
{


    public function __construct()
    {
        $this->middleware(UpdateOnlyTwoInOneDay::class)->only('update');   
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $tasks = Task::all();
        return inertia('Tasks', ['tasks' => TaskResource::collection($tasks)->resolve()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $task = Task::create(array_merge(
            $request->validated(),
            ['user_id' => 1]
        ));
        return  TaskResource::make($task)->resolve();
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task)
    {
        $task->update($request->validated());
        return  TaskResource::make($task)->resolve();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
