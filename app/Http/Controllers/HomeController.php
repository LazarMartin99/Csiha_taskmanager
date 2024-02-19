<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Inertia\Inertia;

class HomeController extends Controller
{

    protected $taskService;


    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return Inertia::render('Dashboard', ['tasks' => $tasks]);
    }

    public function home()
    {
        $tasks = $this->taskService->getAllTasks();
        return Inertia::render('Welcome', [
            'tasks' => $tasks,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

}
