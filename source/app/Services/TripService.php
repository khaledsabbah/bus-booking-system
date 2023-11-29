<?php

namespace App\Services;

use App\Repositories\TripRepository;

class TripService extends BaseService
{
    protected $repository;

    public function __construct(TripRepository $tripRepository)
    {
        $this->repository = $tripRepository;
    }
}
