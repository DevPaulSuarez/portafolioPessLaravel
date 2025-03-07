<?php
//app/Http/Controllers/TechnologieController.php




namespace App\Http\Controllers;

use App\Models\Technologie;
use Illuminate\Http\Request;

     /**
 * @OA\Get(
 *     path="/api/technologies",
 *     summary="Get all technologies",
 *     tags={"Technologies"},
 *     @OA\Response(
 *         response=200,
 *         description="List of technologies",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="name", type="string"),
 *                 @OA\Property(property="description", type="string"),
 *                 @OA\Property(property="icon", type="string")
 *             )
 *         )
 *     )
 * )
 */


class TechnologieController extends Controller
{

    // Obtener todas las tecnologías

    public function index()
    {
        $technologies = Technologie::all();
        return response()->json($technologies);
    }

    // Crear una nueva tecnología
    /**
 * @OA\Post(
 *     path="/api/technologies",
 *     summary="Create a new technology",
 *     tags={"Technologies"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "description"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="icon", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Technology created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="icon", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error"
 *     )
 * )
 */

    public function store(Request $request)
    {
            // Validar los datos
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'nullable|string',
    ]);

    try {
        // Crear la tecnología
        $technologie = Technologie::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
        ]);

        return response()->json($technologie, 201); // Devuelve la tecnología creada
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500); // Captura cualquier excepción
    }
    }

    // Obtener una tecnología por ID
    /**
 * @OA\Get(
 *     path="/api/technologies/{id}",
 *     summary="Get a technology by ID",
 *     tags={"Technologies"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the technology",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Technology retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="icon", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Technology not found"
 *     )
 * )
 */

    public function show($id)
    {
        $technologie = Technologie::findOrFail($id);
        return response()->json($technologie);
    }

    // Actualizar una tecnología
    /**
 * @OA\Put(
 *     path="/api/technologies/{id}",
 *     summary="Update a technology",
 *     tags={"Technologies"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the technology to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="icon", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Technology updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="icon", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Technology not found"
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $technologie = Technologie::findOrFail($id);
        $technologie->update($request->all());
        return response()->json($technologie);
    }

    // Eliminar una tecnología
    /**
 * @OA\Delete(
 *     path="/api/technologies/{id}",
 *     summary="Delete a technology",
 *     tags={"Technologies"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the technology to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Technology deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Technology not found"
 *     )
 * )
 */

    public function destroy($id)
    {
        $technologie = Technologie::findOrFail($id);
        $technologie->delete();
        return response()->json(null, 204);
    }
}
