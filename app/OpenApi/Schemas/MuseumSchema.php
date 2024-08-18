<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Museum",
 *     type="object",
 *     title="Museum",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Museo nazionale di Capodimonte"),
 *     @OA\Property(property="latitude", type="number", format="float", example=40.9458663),
 *     @OA\Property(property="longitude", type="number", format="float", example=14.3715925),
 *     @OA\Property(property="region", type="string", example="Campania"),
 *     @OA\Property(property="province", type="string", example="NA"),
 *     @OA\Property(property="municipality", type="string", example="Napoli"),
 *     @OA\Property(property="distance", type="number", format="float", example=100.0)
 * )
 */
class MuseumSchema
{
    // This class is used only for the Swagger annotations
}
