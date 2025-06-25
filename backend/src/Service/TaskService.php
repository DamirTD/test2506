<?php
namespace App\Service;

use App\Request\CreateTaskRequest;
use App\Request\UpdateTaskRequest;
use App\Application\Handler\CreateTaskHandler;
use App\Application\Handler\UpdateTaskHandler;
use App\Application\Handler\DeleteTaskHandler;
use App\Application\Handler\GetTaskHandler;
use App\Application\Handler\ListTasksHandler;
use App\Application\Command\CreateTaskCommand;
use App\Application\Command\UpdateTaskCommand;
use App\Application\Command\DeleteTaskCommand;
use App\Application\Query\GetTaskQuery;
use App\Application\Query\ListTasksQuery;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class TaskService
{
    public function __construct(
        private ValidatorInterface $validator,
        private CreateTaskHandler $createHandler,
        private UpdateTaskHandler $updateHandler,
        private DeleteTaskHandler $deleteHandler,
        private GetTaskHandler $getHandler,
        private ListTasksHandler $listHandler
    ) {}

    public function list(?string $status = null, int $page = 1, int $limit = 10): array
    {
        $query = new ListTasksQuery($status, $page, $limit);
        
        return $this->listHandler->handle($query);
    }

    public function get(int $id)
    {
        return $this->getHandler->handle(new GetTaskQuery($id));
    }

    public function create(CreateTaskRequest $request)
    {
        $violations = $this->validator->validate($request);

        if (count($violations) > 0) {
            throw new ValidationFailedException($request, $violations);
        }

        $name = trim($request->name) !== '' ? $request->name : 'Без названия';
        $command = new CreateTaskCommand($name, $request->description, 'new');

        return $this->createHandler->handle($command);
    }

    public function update(int $id, UpdateTaskRequest $request)
    {
        $violations = $this->validator->validate($request);

        if (count($violations) > 0) {
            throw new ValidationFailedException($request, $violations);
        }

        $command = new UpdateTaskCommand($id, $request->name, $request->description, $request->status);

        return $this->updateHandler->handle($command);
    }

    public function delete(int $id)
    {
        $command = new DeleteTaskCommand($id);

        $this->deleteHandler->handle($command);
    }
} 