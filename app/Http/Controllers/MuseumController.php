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
     *             required={"name","latitude","longitude","region","province","municipality"},
     *             @OA\Property(property="name", type="string", example="Museo nazionale di Capodimonte"),
     *             @OA\Property(property="latitude", type="number", format="float", example=40.9458662999999),
     *             @OA\Property(property="longitude", type="number", format="float", example=14.3715925),
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
     *     path="/api/museums",
     *     summary="List all museums",
     *     description="Retrieve a list of all museums in the database.",
     *     tags={"Museum"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Museum"))
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function index(): JsonResponse
    {
        $museums = $this->museumRepository->getAll();
        return response()->json($museums, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/museum",
     *     summary="Search for Nearest Museums",
     *     description="List museums by proximity in a given municipality. Filters can be applied for latitude, longitude, and radius.",
     *     tags={"Museum"},
     *     @OA\Parameter(
     *         name="m",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Municipality"
     *     ),
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Latitude"
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="number", format="float"),
     *         description="Longitude"
     *     ),
     *     @OA\Parameter(
     *         name="r",
     *         in="query",
     *         @OA\Schema(type="number", format="float"),
     *         description="Radius (optional, in kilometers)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Museum"))
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function search(Request $request): JsonResponse
    {
        // Validate the request parameters
        $request->validate([
            'm' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'r' => 'nullable|numeric',
        ]);

        // Extract query parameters
        $municipality = $request->input('m');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('r', null); // Default to null if not provided

        // Use the repository to get the list of museums
        $museums = $this->museumRepository->searchByProximity($municipality, $latitude, $longitude, $radius);

        return response()->json($museums, 200);
    }
}
