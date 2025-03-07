<?php
// app/Http/Controllers/ProjectTechnologieController.php




namespace App\Http\Controllers;

use App\Models\ProjectTechnologie;
use Illuminate\Http\Request;

    /**
 * @OA\Post(
 *     path="/api/projects/{projectId}/technologies",
 *     summary="Assign a technology to a project",
 *     tags={"Project Technologies"},
 *     @OA\Parameter(
 *         name="projectId",
 *         in="path",
 *         required=true,
 *         description="ID of the project",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"technologie_id"},
 *             @OA\Property(
 *                 property="technologie_id",
 *                 type="integer",
 *                 description="ID of the technology to assign"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Technology assigned successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="project_id", type="integer"),
 *             @OA\Property(property="technologie_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */

class ProjectTechnologieController extends Controller
{


    // Asignar tecnologías a un proyecto


    public function store(Request $request, $projectId)
    {
        $request->validate([
            'technologie_id' => 'required|exists:technologies,id',
        ]);

        $projectTechnologie = ProjectTechnologie::create([
            'project_id' => $projectId,
            'technologie_id' => $request->technologie_id,
        ]);

        return response()->json($projectTechnologie, 201);
    }

    // Eliminar una tecnología de un proyecto
    /**
 * @OA\Delete(
 *     path="/api/projects/{projectId}/technologies/{technologieId}",
 *     summary="Remove a technology from a project",
 *     tags={"Project Technologies"},
 *     @OA\Parameter(
 *         name="projectId",
 *         in="path",
 *         required=true,
 *         description="ID of the project",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="technologieId",
 *         in="path",
 *         required=true,
 *         description="ID of the technology to remove",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Technology removed successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Project or Technology not found"
 *     )
 * )
 */

    public function destroy($projectId, $technologieId)
    {
        $projectTechnologie = ProjectTechnologie::where('project_id', $projectId)
            ->where('technologie_id', $technologieId)
            ->firstOrFail();
        
        $projectTechnologie->delete();
        return response()->json(null, 204);
    }
}
