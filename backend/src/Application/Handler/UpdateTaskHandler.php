<?php
namespace App\Application\Handler;

use App\Application\Command\UpdateTaskCommand;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateTaskHandler
{
    private TaskRepository $taskRepository;
    private EntityManagerInterface $em;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $em)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $em;
    }

    public function handle(UpdateTaskCommand $command)
    {
        $task = $this->taskRepository->find($command->id);
        
        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }

        if ($command->name !== null) $task->setName($command->name);
        if ($command->description !== null) $task->setDescription($command->description);
        if ($command->status !== null) $task->setStatus($command->status);

        $this->em->flush();

        return $task;
    }
} 