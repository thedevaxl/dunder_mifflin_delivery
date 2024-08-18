<?php

namespace App\Repositories;

use App\Models\Museum;

class MuseumRepository implements MuseumRepositoryInterface
{
    public function create(array $data): Museum
    {
        return Museum::create($data);
    }
}
