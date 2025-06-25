<?php
namespace App\Application\Query;

class ListTasksQuery
{
    public ?string $status;
    public int $page;
    public int $limit;
    public function __construct(?string $status = null, int $page = 1, int $limit = 10)
    {
        $this->status = $status;
        $this->page = $page;
        $this->limit = $limit;
    }
} 