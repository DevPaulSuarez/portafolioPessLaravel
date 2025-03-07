<?php
namespace App\Http\Controllers;

use App\Models\Project; 
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Project API", version="1.0")
 */

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get all projects",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Project")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $projects = Project::with('technologies', 'tasks', 'user', 'translations:id,project_id,language_code,name,description')->get();
        return response()->json($projects, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Get a project by ID",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show($id)
    {
        $project = Project::with('technologies', 'tasks', 'user','translations:id,project_id,language_code,name,description')->find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json($project, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"translations"},
     *             @OA\Property(property="code_url", type="string", format="url"),
     *             @OA\Property(property="demo_url", type="string", format="url"),
     *             @OA\Property(
     *                 property="translations",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"language_code", "name", "description"},
     *                     @OA\Property(property="language_code", type="string", maxLength=2),
     *                     @OA\Property(property="name", type="string", maxLength=255),
     *                     @OA\Property(property="description", type="string")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     )
     * )
     */
    public function store(Request $request)
    {
        // 1. Validar la solicitud
        $request->validate([
            'translations' => 'required|array',
            'translations.*.language_code' => 'required|string|max:2',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'required|string',
            'code_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
        ]);

        // 2. Crear el proyecto
        $project = Project::create([
            'code_url' => $request->code_url,
            'demo_url' => $request->demo_url,
            'user_id' => 1, 
        ]);

        // 3. Añadir traducciones al proyecto
        foreach ($request->translations as $translation) {
            $project->translations()->create($translation);
        }

        // 4. Responder con el proyecto creado
        return response()->json([
            'message' => 'Project created successfully!',
            'data' => $project->load('translations'),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update a project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="code_url", type="string", format="url"),
     *             @OA\Property(property="demo_url", type="string", format="url"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="end_date", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validated = $request->validate([
            'code_url' => 'nullable|string',
            'demo_url' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'end_date' => 'nullable|date',
        ]);

        $project->update($validated);
        return response()->json($project, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a project",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}
