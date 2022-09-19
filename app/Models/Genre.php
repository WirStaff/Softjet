<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 *
 * @OA\Schema (
 *      description="Genre Model",
 *      type="object",
 *      title="Genre Model",
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 * )
 *
 */
class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }
}
