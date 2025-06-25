<?php
namespace App\Application\Handler;

use App\Application\Command\DeleteTaskCommand;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteTaskHandler
{
    private TaskRepository $taskRepository;
    private EntityManagerInterface $em;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $em)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $em;
    }

    public function handle(DeleteTaskCommand $command)
    {
        $task = $this->taskRepository->find($command->id);
        
        if (!$task) {
            throw new NotFoundHttpException('Task not found');
        }

        $this->em->remove($task);
        $this->em->flush();
    }
} 