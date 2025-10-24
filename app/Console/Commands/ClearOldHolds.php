<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\HoldStatus;
use App\Models\Hold;
use Illuminate\Console\Command;

class ClearOldHolds extends Command
{
    protected $signature = 'app:clear-old-holds';

    protected $description = 'Clear old holds from the database';

    public function handle(): int
    {
        Hold::query()
            ->where('created_at', '<', now()->subMinutes(15))
            ->where('status', HoldStatus::HELD)
            ->delete();

        return parent::SUCCESS;
    }
}
