<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     schema="Translation",
 *     type="object",
 *     required={"project_id", "language_code", "name"},
 *     @OA\Property(property="id", type="integer", description="ID of the translation"),
 *     @OA\Property(property="project_id", type="integer", description="ID of the project"),
 *     @OA\Property(property="language_code", type="string", description="Language code"),
 *     @OA\Property(property="name", type="string", description="Name of the translation"),
 *     @OA\Property(property="description", type="string", description="Description of the translation", nullable=true)
 * )
 */


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'language_code',
        'name',
        'description',
    ];

    // Definir la relación con el proyecto
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
}
