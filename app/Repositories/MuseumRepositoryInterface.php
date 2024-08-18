<?php

namespace App\Repositories;

use App\Models\Museum;

interface MuseumRepositoryInterface
{
    public function create(array $data): Museum;
}
