<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreMuseumRequest;
use App\Repositories\MuseumRepositoryInterface;

class MuseumController extends Controller
{
    protected $museumRepository;

    public function __construct(MuseumRepositoryInterface $museumRepository)
    {
        $this->museumRepository = $museumRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/museum",
     *     summary="Create Museum",
     *     description="Register a new museum. Requires user authentication.",
     *     operationId="storeMuseum",
     *     tags={"Museum"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","lat","long","region","province","municipality"},
     *             @OA\Property(property="name", type="string", example="Museo nazionale di Capodimonte"),
     *             @OA\Property(property="lat", type="number", format="float", example=40.9458662999999),
     *             @OA\Property(property="long", type="number", format="float", example=14.3715925),
     *             @OA\Property(property="region", type="string", example="Campania"),
     *             @OA\Property(property="province", type="string", example="NA"),
     *             @OA\Property(property="municipality", type="string", example="Napoli"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="resource", ref="#/components/schemas/Museum")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function store(StoreMuseumRequest $request): JsonResponse
    {
        $museum = $this->museumRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'resource' => $museum
        ], 200);
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
