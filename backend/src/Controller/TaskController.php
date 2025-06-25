<?php

namespace App\Controller;

use App\Application\Command\CreateTaskCommand;
use App\Application\Command\UpdateTaskCommand;
use App\Application\Command\DeleteTaskCommand;
use App\Application\Query\GetTaskQuery;
use App\Application\Query\ListTasksQuery;
use App\Application\Handler\CreateTaskHandler;
use App\Application\Handler\UpdateTaskHandler;
use App\Application\Handler\DeleteTaskHandler;
use App\Application\Handler\GetTaskHandler;
use App\Application\Handler\ListTasksHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\HttpStatusCode;
use App\Request\CreateTaskRequest;
use App\Request\UpdateTaskRequest;
use App\Service\TaskService;

#[Route('/api/tasks')]
class TaskController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(Request $request, TaskService $service): JsonResponse
    {
        $status = $request->query->get('status');
        $page = (int)($request->query->get('page', 1));
        $limit = (int)($request->query->get('limit', 10));
        $tasks  = $service->list($status, $page, $limit);
        $data = array_map(fn($task) => [
            'id'          => $task->getId(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus()
        ], $tasks);
        return $this->json($data, HttpStatusCode::OK);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, TaskService $service): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $req  = new CreateTaskRequest($data);
        $task = $service->create($req);

        return $this->json([
            'id'          => $task->getId(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        ], HttpStatusCode::CREATED);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getTask(int $id, TaskService $service): JsonResponse
    {
        $task = $service->get($id);

        return $this->json([
            'id'          => $task->getId(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        ], HttpStatusCode::OK);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, TaskService $service): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $req = new UpdateTaskRequest($data);
        $task = $service->update($id, $req);

        return $this->json([
            'id'          => $task->getId(),
            'name'        => $task->getName(),
            'description' => $task->getDescription(),
            'status'      => $task->getStatus(),
        ], HttpStatusCode::OK);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id, TaskService $service): JsonResponse
    {
        $service->delete($id);

        return $this->json(null, HttpStatusCode::NO_CONTENT);
    }
}
