<?php
namespace App\Application\Command;

class CreateTaskCommand
{
    public string $name;
    public ?string $description;
    public string $status;

    public function __construct(string $name, ?string $description, string $status = 'new')
    {
        $this->name        = $name;
        $this->description = $description;
        $this->status      = $status;
    }
} 