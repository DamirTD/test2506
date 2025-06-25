<?php
namespace App\Application\Query;

class GetTaskQuery
{
    public int $id;
    public function __construct(int $id)
    {
        $this->id = $id;
    }
} 