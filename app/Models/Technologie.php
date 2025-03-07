<?php
/**
 * @OA\Schema(
 *     schema="Technologie",
 *     type="object",
 *     required={"name", "description"},
 *     @OA\Property(property="id", type="integer", description="ID of the technology"),
 *     @OA\Property(property="name", type="string", description="Name of the technology"),
 *     @OA\Property(property="description", type="string", description="Description of the technology"),
 *     @OA\Property(property="icon", type="string", description="Icon representing the technology", nullable=true)
 * )
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importa el trait
use Illuminate\Database\Eloquent\Model;

class Technologie extends Model
{
    //
    use HasFactory; // Usa el trait HasFactory

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_technologie', 'technologie_id', 'project_id');
    }

}
