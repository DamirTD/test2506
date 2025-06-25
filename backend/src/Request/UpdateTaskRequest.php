<?php
namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateTaskRequest
{
    public ?string $name        = null;
    public ?string $description = null;
    public ?string $status      = null;

    public function __construct(array $data)
    {
        $this->name        = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->status      = $data['status'] ?? null;
    }
} 