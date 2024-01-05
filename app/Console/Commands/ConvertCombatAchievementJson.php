<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertCombatAchievementJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert-ca-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts a regular array of combat achievement taks to an object for easier use';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $return = [];

        $data = File::json(storage_path('app/CombatAchievements.json'));

        foreach ($data as $task) {
            $return[$task['id']] = [
                'monster' => $task['monster'],
                'tier' => $task['tier'],
                'type' => $task['type'],
                'name' => $task['name'],
                'description' => $task['task'],
            ];
        }

        ksort($return);

        File::put(storage_path('app/CombatAchievements.php'), var_export($return, true));
    }
}
