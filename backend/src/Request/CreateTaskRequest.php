<?php
namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskRequest
{
    #[Assert\NotBlank]
    public string $name;

    public ?string $description = null;

    public function __construct(array $data)
    {
        $this->name        = $data['name'] ?? '';
        $this->description = $data['description'] ?? null;
    }
} 