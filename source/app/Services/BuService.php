<?php

namespace App\Services;

use App\Repositories\BuRepository;

class BuService extends BaseService
{
    protected $repository;

    public function __construct(BuRepository $buRepository)
    {
        $this->repository = $buRepository;
    }
}
