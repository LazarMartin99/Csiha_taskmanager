<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks()
    {
        return $this->taskRepository->getAll();
    }

    public function getTaskById($id)
    {
        return $this->taskRepository->findById($id);
    }

    public function createTask(array $data)
    {
        return $this->taskRepository->create($data);
    }

    public function updateTask($id, array $data)
    {
        $task = $this->taskRepository->findById($id);
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask($id)
    {
        $task = $this->taskRepository->findById($id);
        return $this->taskRepository->delete($task);
    }

    public function updateStatus($id)
    {
        $task = $this->taskRepository->findById($id);
        return $this->taskRepository->markAsCompleted($task);
    }
}