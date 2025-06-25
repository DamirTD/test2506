<?php
namespace App\Application\Handler;

use App\Application\Command\CreateTaskCommand;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class CreateTaskHandler
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(CreateTaskCommand $command): Task
    {
        $task = new Task();
        $task->setName($command->name);
        $task->setDescription($command->description);
        $task->setStatus($command->status);
        $this->em->persist($task);
        $this->em->flush();
        
        return $task;
    }
} 