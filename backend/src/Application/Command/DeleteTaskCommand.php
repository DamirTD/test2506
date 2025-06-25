<?php
namespace App\Application\Command;

class DeleteTaskCommand
{
    public int $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }
} 