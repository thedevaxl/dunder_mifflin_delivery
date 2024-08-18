<?php


namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Dunder Mifflin Delivery API",
 *     description="API documentation for the Dunder Mifflin delivery service",
 *     @OA\Contact(
 *         email="support@dundermifflin.com"
 *     ),
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */
class SwaggerController extends Controller
{
    // This class can remain empty. It's just here to hold the Swagger annotations.
}
