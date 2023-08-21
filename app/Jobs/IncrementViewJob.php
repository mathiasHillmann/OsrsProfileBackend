<?php

namespace App\Jobs;

use App\Models\Player;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class IncrementViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $username)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            DB::transaction(function () {
                $select = Player::where('username', $this->username)->first();
                $select->timestamps = false;
                $select->views = $select->views + 1;
                $select->save();
            });
        } catch (\Throwable $th) {
            report($th);
        }
    }
}
