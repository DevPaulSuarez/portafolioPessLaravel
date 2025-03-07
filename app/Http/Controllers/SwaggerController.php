<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Portfolio API",
 *         version="1.0.0",
 *         description="API documentation for the portfolio project.",
 *         @OA\Contact(
 *             email="your-email@example.com"
 *         ),
 *         @OA\License(
 *             name="MIT",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000/api",
 *         description="Local server"
 *     )
 * )
 */

 /**
 * @OA\Schema(
 *     schema="Project",
 *     type="object",
 *     required={"id", "code_url", "demo_url"},
 *     @OA\Property(property="id", type="integer", description="The unique identifier of the project"),
 *     @OA\Property(property="code_url", type="string", description="The URL of the project code"),
 *     @OA\Property(property="demo_url", type="string", description="The demo URL of the project"),
 *     @OA\Property(property="translations", type="array", 
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="language_code", type="string", description="Language code of the translation"),
 *             @OA\Property(property="name", type="string", description="Project name in the specific language"),
 *             @OA\Property(property="description", type="string", description="Project description in the specific language")
 *         )
 *     )
 * )
 */


class SwaggerController extends Controller
{
    // Este archivo solo contiene anotaciones y no requiere métodos.
}
