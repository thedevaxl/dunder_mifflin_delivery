<?php
namespace App\Http\Controllers;

use App\Models\Museum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class MuseumController extends Controller
{

    /**
     * @OA\Schema(
     *     schema="Museum",
     *     type="object",
     *     title="Museum",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Museo nazionale di Capodimonte"),
     *     @OA\Property(property="lat", type="number", format="float", example=40.9458663),
     *     @OA\Property(property="long", type="number", format="float", example=14.3715925),
     *     @OA\Property(property="region", type="string", example="Campania"),
     *     @OA\Property(property="province", type="string", example="NA"),
     *     @OA\Property(property="municipality", type="string", example="Napoli"),
     *     @OA\Property(property="distance", type="number", format="float", example=100.0)
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/museum",
     *     summary="Create Museum",
     *     description="Register a new museum",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","lat","long","region","province","municipality"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="lat", type="number", format="float"),
     *             @OA\Property(property="long", type="number", format="float"),
     *             @OA\Property(property="region", type="string"),
     *             @OA\Property(property="province", type="string"),
     *             @OA\Property(property="municipality", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="resource", ref="#/components/schemas/Museum"),
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function store(Request $request)
    {
        // Your implementation here...
    }

    /**
     * @OA\Get(
     *     path="/api/museum",
     *     summary="Search for Nearest Museums",
     *     description="List museums by proximity in a given municipality",
     *     @OA\Parameter(
     *         name="m",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Municipality"
     *     ),
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Latitude"
     *     ),
     *     @OA\Parameter(
     *         name="long",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Longitude"
     *     ),
     *     @OA\Parameter(
     *         name="r",
     *         in="query",
     *         @OA\Schema(type="number", format="float"),
     *         description="Radius (optional)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Museum"))
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function search(Request $request)
    {
        // Your implementation here...
    }
}
