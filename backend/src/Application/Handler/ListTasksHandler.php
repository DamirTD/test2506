<?php
namespace App\Application\Handler;

use App\Application\Query\ListTasksQuery;
use App\Repository\TaskRepository;

class ListTasksHandler
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    
    public function handle(ListTasksQuery $query)
    {
        $qb = $this->taskRepository->createQueryBuilder('t');
        if ($query->status) {
            $qb->where('t.status = :status')
               ->setParameter('status', $query->status);
        }
        $qb->setFirstResult(($query->page - 1) * $query->limit)
           ->setMaxResults($query->limit);
        return $qb->getQuery()->getResult();
    }
} 