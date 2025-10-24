<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SlotFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $capacity
 * @property int $remaining
 */
final class Slot extends Model
{
    /** @use HasFactory<SlotFactory> */
    use HasFactory;

    protected $fillable = [
        'capacity',
        'remaining',
    ];
}
