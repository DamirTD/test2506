<?php
namespace App\Application\Handler;

use App\Application\Query\GetTaskQuery;
use App\Repository\TaskRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetTaskHandler
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(GetTaskQuery $query)
    {
        $task = $this->taskRepository->find($query->id);

        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }
        
        return $task;
    }
} 