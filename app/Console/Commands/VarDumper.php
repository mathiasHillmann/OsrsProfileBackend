<?php

namespace App\Console\Commands;

use App\Enums\RunescapeAccountTypes;
use App\Models\Player;
use App\Services\HiscoreService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class VarDumper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'var-dumper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dumps all variables into files';

    private const DUMP_REPOSITORY = 'https://github.com/abextm/osrs-cache/';

    private const DUMP_PATH = 'app/tmp';

    private const VARIABLES_SOURCES = [
        'quests' => '4024.rs2asm',
        'combat_achievements' => '4834.rs2asm',
        'achievement_diaries' => '56.rs2asm',
        'boss_kc' => '4778.rs2asm',
    ];

    private const ENUMS = [
        'bosses' => '3971',
    ];

    private const NON_BOSSES = [
        'Aberrant Spectre', 'Basilisk Knight', 'Black Dragon', 'Bloodveld',
        'Brutal Black Dragon', 'Demonic Gorilla', 'Fire Giant', 'Greater Demon',
        'Kurask', 'Lizardman Shaman', 'The Mimic', 'Fragment of Seren',
        'Skeletal Wyvern', 'Wyrm', "TzHaar-Ket-Rak's Challenges", 'None',
    ];

    // I need someone that is ranked on every boss to be able to get the hiscore id for an activity
    private const HISCORE_USER = 'Marni';

    private Collection $hiscoreData;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchHiscoreData();

        if ($this->confirm('Download latest cache?')) {
            $this->createTemporaryFiles();

            $this->downloadLatestCacheDump();
        }

        $this->getQuestVariables();
        $monsterMap = $this->getBossKcVariables();
        $this->getCombatAchievementVariables();
        $this->getCombatAchievementTasks($monsterMap);
    }

    private function fetchHiscoreData()
    {
        $this->line(__FUNCTION__);

        $service = new HiscoreService();

        $player = new Player([
            'username' => self::HISCORE_USER,
            'account_type' => RunescapeAccountTypes::Normal,
        ]);

        try {
            $this->hiscoreData = collect($service->fetchPlayer($player)['activities'] ?? []);
        } catch (\Throwable $th) {
            $this->hiscoreData = collect([]);
        }
    }

    private function createTemporaryFiles(): void
    {
        $this->line(__FUNCTION__);

        File::deleteDirectory(storage_path(self::DUMP_PATH));
        File::makeDirectory(storage_path(self::DUMP_PATH), 0777, true);
    }

    private function downloadLatestCacheDump(): void
    {
        $this->line(__FUNCTION__);

        $response = Http::acceptJson()->get(sprintf('%s/releases/latest', self::DUMP_REPOSITORY));

        if ($response->successful()) {
            $tag = $response->object()->tag_name;
        } else {
            throw new \Exception("Could not get tag from github: ({$response->status()}) - {$response->body()}");
        }

        $tarPath = storage_path(self::DUMP_PATH.DIRECTORY_SEPARATOR.'cache.tar.gz');

        Http::sink($tarPath)
            ->get(sprintf('%s/releases/download/%s/dump-%s.tar.gz', self::DUMP_REPOSITORY, $tag, $tag));

        if (File::exists($tarPath)) {
            $tar = new \PharData($tarPath);
            $tar->extractTo(storage_path(self::DUMP_PATH));
        } else {
            throw new \Exception('Dump tar not found. Possibly did not download');
        }
    }

    private function getQuestVariables(): void
    {
        $this->line(__FUNCTION__);

        $variables = [];
        $labelIdMap = [];

        $this->readAsmFile(
            self::VARIABLES_SOURCES['quests'],
            function (string $line, string $previousLine) use (&$variables, &$labelIdMap) {
                // Example: "      10: LABEL3"
                if (preg_match('/\d+: LABEL\d+/', $line)) {
                    $data = explode(': ', $line); // [10, LABEL3]
                    $labelIdMap[$data[1]] = $data[0];
                }

                // Example: "   get_varp               32"
                if (str_contains($line, 'get_var')) {
                    $data = preg_split('/\s+/', $line); // [get_varp, 32]
                    $label = explode(':', $previousLine)[0]; // [LABEL3]
                    $varType = explode('_', $data[0]); // [get, varp]
                    $info = $this->readJson('dbrow', $labelIdMap[$label])['columnValues'];
                    $questName = $info[2][0] ?? 'Unknown';

                    $variables[$questName] = [
                        'index' => $data[1] ?? 0,
                        'type' => $varType[1] == 'varp' ? 'varp' : 'varb',
                        'questType' => ($info[4][0] ?? 0) == 1 ? 'miniquest' : 'quest',
                        'startValue' => $info[18][0] ?? 0,
                        'endValue' => $info[19][0] ?? 0,
                        'text' => $questName,
                    ];
                }
            }
        );

        File::put(base_path('data/quests.json'), json_encode($variables, JSON_PRETTY_PRINT));
    }

    private function getBossName(string $original): string
    {
        return match ($original) {
            'Thermy' => 'Thermonuclear Smoke Devil',
            'Crystalline Hunllef' => 'The Gauntlet',
            'Corrupted Hunllef' => 'The Corrupted Gauntlet',
            'The Nightmare' => 'Nightmare',
            'Leviathan' => 'The Leviathan',
            'Whisperer' => 'The Whisperer',
            'Chambers of Xeric: CM' => 'Chambers of Xeric: Challenge Mode',
            'Barrows' => 'Barrows Chests',
            "Kree'arra" => "Kree'Arra",
            default => $original,
        };
    }

    private function getBossKcVariables(): array
    {
        $this->line(__FUNCTION__);

        $variables = [];
        $labelIdMap = [];

        $enum = $this->readJson('enum', self::ENUMS['bosses']);
        $monsterMap = array_combine($enum['keys'], $enum['stringVals']);

        $this->readAsmFile(
            self::VARIABLES_SOURCES['boss_kc'],
            function (string $line, string $previousLine) use (&$variables, &$labelIdMap, $monsterMap) {
                // Example: "      10: LABEL3"
                if (preg_match('/\d+: LABEL\d+/', $line)) {
                    $data = explode(': ', $line); // [10, LABEL3]
                    $labelIdMap[$data[1]] = $data[0];
                }

                // Example: "   get_varp               32"
                if (str_contains($line, 'get_var')) {
                    $data = preg_split('/\s+/', $line); // [get_varp, 32]
                    $label = explode(':', $previousLine)[0]; // [LABEL3]
                    $varType = explode('_', $data[0]); // [get, varp]

                    if (str_contains($label, 'LABEL')) {
                        $id = $labelIdMap[$label];
                        $name = $this->getBossName($monsterMap[$id]);
                        $hiscore = $this->hiscoreData->where(fn ($activity) => $activity['name'] == $name)->first();

                        $variables[$name] = [
                            'text' => $name,
                            'type' => $varType[1] == 'varp' ? 'varp' : 'varb',
                            'index' => $data[1] ?? 0,
                            'hiscoreId' => $hiscore['id'] ?? null,
                        ];
                    }
                }
            }
        );

        File::put(base_path('data/boss-kc-vars.json'), json_encode($variables, JSON_PRETTY_PRINT));

        return $monsterMap;
    }

    private function getCombatAchievementVariables(): void
    {
        $this->line(__FUNCTION__);

        $variables = [];

        $this->readAsmFile(
            self::VARIABLES_SOURCES['combat_achievements'],
            function (string $line, string $previousLine) use (&$variables) {
                // Example: "   get_varp               32"
                if (str_contains($line, 'get_var')) {
                    $data = preg_split('/\s+/', $line); // [get_varp, 32]

                    $variables[] = $data[1] ?? 0;
                }
            }
        );

        File::put(base_path('data/combat-achievements-vars.json'), json_encode($variables, JSON_PRETTY_PRINT));
    }

    private function getCombatAchievementTasks(array $monsterMap): void
    {
        $this->line(__FUNCTION__);

        $tasks = [];
        $exampleTaskStructKeys = [
            '1312',
            '1306',
            '1307',
            '1308',
            '1309',
            '1310',
            '1311',
        ];

        // Get all filenames in a directory without the extension
        $files = collect(scandir(storage_path(self::DUMP_PATH.'/dump/structs')))
            ->transform(fn ($file) => pathinfo($file, PATHINFO_FILENAME))
            ->diff(['..', '.', '']);

        foreach ($files as $file) {
            $struct = $this->readJson('struct', $file);

            if (
                array_key_exists('id', $struct)
                && array_key_exists('params', $struct)
                && array_keys($struct['params']) == $exampleTaskStructKeys
            ) {
                $monsterName = $this->getBossName($monsterMap[$struct['params'][1312]] ?? 'None');

                $tasks[$struct['params'][1306]] = [
                    'monster' => $monsterName,
                    'tier' => match ($struct['params'][1310]) {
                        1 => 'Easy',
                        2 => 'Medium',
                        3 => 'Hard',
                        4 => 'Elite',
                        5 => 'Master',
                        6 => 'Grandmaster',
                    },
                    'type' => match ($struct['params'][1311]) {
                        1 => 'Stamina',
                        2 => 'Perfection',
                        3 => 'Kill Count',
                        4 => 'Mechanical',
                        5 => 'Restriction',
                        6 => 'Speed',
                    },
                    'name' => $struct['params'][1308],
                    'description' => $struct['params'][1309],
                    'boss' => in_array($monsterName, self::NON_BOSSES) ? false : true,
                ];
            }
        }

        ksort($tasks);

        File::put(base_path('data/combat-achievements-tasks.json'), json_encode($tasks, JSON_PRETTY_PRINT));
    }

    private function readAsmFile(string $file, \Closure $callback): void
    {
        $asmFile = File::lines(storage_path(self::DUMP_PATH."/dump/rs2asm/{$file}"));
        $previousLine = '';

        foreach ($asmFile as $line) {
            $line = trim($line);

            $callback($line, $previousLine);

            $previousLine = $line;
        }
    }

    private function readJson(string $type, string $id): array
    {
        $path = match ($type) {
            'dbrow' => '/dump/dbrow/',
            'enum' => '/dump/enums/',
            'struct' => '/dump/structs/',
            'default' => throw new \UnexpectedValueException("Invalid json type: {$type}"),
        };

        return json_decode(
            file_get_contents(
                storage_path(self::DUMP_PATH.$path."{$id}.json")
            ),
            true
        );
    }
}
