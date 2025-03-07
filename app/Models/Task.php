<?php

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     required={"name", "description", "status", "project_id"},
 *     @OA\Property(property="id", type="integer", description="ID of the task"),
 *     @OA\Property(property="name", type="string", description="Name of the task"),
 *     @OA\Property(property="description", type="string", description="Description of the task"),
 *     @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, description="Current status of the task"),
 *     @OA\Property(property="project_id", type="integer", description="ID of the associated project")
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Definir los campos que son asignables masivamente
    protected $fillable = [
        'name',
        'description',
        'status',
        'project_id',
    ];

    // Relación con el modelo Project (muchos a uno)
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
