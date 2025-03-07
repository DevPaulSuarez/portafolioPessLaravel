<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

    /**
 * @OA\Get(
 *     path="/api/tasks",
 *     summary="Get all tasks",
 *     tags={"Tasks"},
 *     @OA\Response(
 *         response=200,
 *         description="List of tasks",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="name", type="string"),
 *                 @OA\Property(property="description", type="string"),
 *                 @OA\Property(property="status", type="string"),
 *                 @OA\Property(property="project_id", type="integer")
 *             )
 *         )
 *     )
 * )
 */



class TaskController extends Controller
{

    // Obtener todas las tareas


    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    // Crear una nueva tarea
    /**
 * @OA\Post(
 *     path="/api/tasks",
 *     summary="Create a new task",
 *     tags={"Tasks"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"name", "description", "status", "project_id"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}),
 *             @OA\Property(property="project_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Task created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="project_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'project_id' => 'required|exists:projects,id', // Validar que el project_id exista
        ]);

        // Crear la tarea
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'project_id' => $request->project_id,
        ]);

        // Retornar una respuesta
        return response()->json($task, 201); // Devuelve la tarea creada
    }

    // Obtener una tarea por ID

    /**
 * @OA\Get(
 *     path="/api/tasks/{id}",
 *     summary="Get a task by ID",
 *     tags={"Tasks"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the task",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Task retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="project_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Task not found"
 *     )
 * )
 */

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // Actualizar una tarea
    /**
 * @OA\Put(
 *     path="/api/tasks/{id}",
 *     summary="Update a task",
 *     tags={"Tasks"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the task to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}),
 *             @OA\Property(property="project_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Task updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="project_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Task not found"
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task);
    }

    // Eliminar una tarea
    /**
 * @OA\Delete(
 *     path="/api/tasks/{id}",
 *     summary="Delete a task",
 *     tags={"Tasks"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the task to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Task deleted successfully"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Task not found"
 *     )
 * )
 */

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
