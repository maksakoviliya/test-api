<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SlotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $capacity
 * @property int $remaining
 * @property-read Hold[] $holds
 */
final class Slot extends Model
{
    /** @use HasFactory<SlotFactory> */
    use HasFactory;

    protected $fillable = [
        'capacity',
        'remaining',
    ];

    public function holds(): HasMany
    {
        return $this->hasMany(Hold::class);
    }
}
