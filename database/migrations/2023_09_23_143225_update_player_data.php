<?php

use App\Models\Player;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (Player::cursor() as $player) {
            $newData = [];

            foreach ($player->data as $key => $value) {
                $newData[$key] = $value['value'];
            }

            $player->timestamps = false;
            $player->data = $newData;
            $player->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
