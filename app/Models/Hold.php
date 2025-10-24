<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\HoldStatus;
use Database\Factories\HoldFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $slot_id
 * @property HoldStatus $status
 * @property-read Slot $slot
 */
final class Hold extends Model
{
    /** @use HasFactory<HoldFactory> */
    use HasFactory;

    protected $fillable = [
        'slot_id',
        'status',
    ];

    protected $casts = [
        'status' => HoldStatus::class,
    ];

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }
}
