<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;



class TranslationController extends Controller
{



    /**
 * @OA\Get(
 *     path="/api/translations",
 *     summary="Get all translations",
 *     tags={"Translations"},
 *     @OA\Response(
 *         response=200,
 *         description="List of translations",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Translation")
 *         )
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/translations",
 *     summary="Create a new translation",
 *     tags={"Translations"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"project_id", "language_code", "name"},
 *             @OA\Property(property="project_id", type="integer"),
 *             @OA\Property(property="language_code", type="string"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Translation created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Translation")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid data provided"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/translations/{id}",
 *     summary="Get a specific translation by ID",
 *     tags={"Translations"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the translation",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Translation found",
 *         @OA\JsonContent(ref="#/components/schemas/Translation")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Translation not found"
 *     )
 * )
 */

/**
 * @OA\Put(
 *     path="/api/translations/{id}",
 *     summary="Update a translation",
 *     tags={"Translations"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the translation",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"project_id", "language_code", "name"},
 *             @OA\Property(property="project_id", type="integer"),
 *             @OA\Property(property="language_code", type="string"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Translation updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Translation")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid data provided"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Translation not found"
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/translations/{id}",
 *     summary="Delete a translation",
 *     tags={"Translations"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the translation to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Translation deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Translation not found"
 *     )
 * )
 */

    // Obtener todas las traducciones
    public function index()
    {
        $translations = Translation::all();
        return response()->json($translations);
    }

    // Crear una nueva traducción
    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'language_code' => 'required|string|max:10',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Crear la traducción
        $translation = Translation::create($validated);

        return response()->json($translation, 201);
    }

    // Obtener una traducción específica por ID
    public function show($id)
    {
        $translation = Translation::findOrFail($id);
        return response()->json($translation);
    }

    // Actualizar una traducción
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'language_code' => 'required|string|max:10',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Buscar y actualizar la traducción
        $translation = Translation::findOrFail($id);
        $translation->update($validated);

        return response()->json($translation);
    }

    // Eliminar una traducción
    public function destroy($id)
    {
        $translation = Translation::findOrFail($id);
        $translation->delete();

        return response()->json(null, 204);
    }
}
