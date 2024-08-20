<?php

namespace App\Repositories;

use App\Models\Museum;

interface MuseumRepositoryInterface
{
    /**
     * Create a new museum record.
     *
     * @param array $data
     * @return Museum
     */
    public function create(array $data): Museum;

    /**
     * Search museums by proximity within a given municipality, latitude, longitude, and optional radius.
     *
     * @param string $municipality The municipality to search within.
     * @param float $latitude The latitude for proximity calculation.
     * @param float $longitude The longitude for proximity calculation.
     * @param float|null $radius The radius within which to search, in kilometers. Null for no radius limitation.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByProximity(string $municipality, float $latitude, float $longitude, ?float $radius = null);

    /**
     * Retrieve all museum records.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();
}
