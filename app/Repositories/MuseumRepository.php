<?php

namespace App\Repositories;

use App\Models\Museum;

class MuseumRepository implements MuseumRepositoryInterface
{
    public function create(array $data): Museum
    {
        return Museum::create($data);
    }

    public function searchByProximity(string $municipality, float $latitude, float $longitude, ?float $radius = null)
    {
        $query = Museum::where('municipality', $municipality);

        $query->selectRaw("
            *,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )->orderBy('distance');

        if ($radius) {
            $query->having('distance', '<=', $radius);
        }

        return $query->get();
    }

    public function getAll()
    {
        return Museum::all();
    }
}
