<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use App\Services\UserService;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;
    protected $userService;


    public function __construct(TaskService $taskService, UserService $userService)
    {
        $this->taskService = $taskService;
        $this->userService = $userService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return Inertia::render('Dashboard', ['tasks' => $tasks]);
    }

    public function create()
    {
        $users = $this->userService->getAllUsers();
        return Inertia::render('Tasks/CreateTask', ['users' => $users]);
    }
    
    public function edit($id)
    {
        $task = $this->taskService->getTaskById($id);
        $users = $this->userService->getAllUsers();
    
        return Inertia::render('Tasks/UpdateTask', ['task' => $task, 'users'=> $users]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated());
        return redirect()->route('tasks.index');
    }


    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->updateTask($id, $request->validated());
        return redirect()->route('tasks.index');
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return redirect()->route('tasks.index');
    }

    public function markAsCompleted($id)
    {
        $this->taskService->updateStatus($id);
        return redirect()->route('tasks.index');
 
    }
}
