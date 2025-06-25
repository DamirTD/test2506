<?php
namespace App\Application\Command;

class UpdateTaskCommand
{
    public int $id;
    public ?string $name;
    public ?string $description;
    public ?string $status;

    public function __construct(int $id, ?string $name, ?string $description, ?string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }
} 