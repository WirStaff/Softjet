<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @OA\Schema (
 *      description="Game Model",
 *      type="object",
 *      title="Game Model",
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string"
 *      ),
 * )
 *
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
