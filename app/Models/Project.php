<?php

/**
 * @OA\Schema(
 *     schema="Project",
 *     type="object",
 *     required={"id", "name", "description"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Portfolio Website"),
 *     @OA\Property(property="description", type="string", example="A personal portfolio site."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-20T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-20T12:30:00Z")
 * )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Definir los campos que son asignables masivamente
    protected $fillable = [
        'code_url',
        'demo_url',
        'user_id',
    ];
    

    // Relación con el modelo UserPortafolio (muchos a uno)
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    // Relación con el modelo Technologie (muchos a muchos)
    public function technologies()
    {
        return $this->belongsToMany(Technologie::class, 'project_technologie', 'project_id', 'technologie_id');
    }

    // Relación con el modelo Task (uno a muchos)
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Definir la relación con traducciones
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }


    

}

