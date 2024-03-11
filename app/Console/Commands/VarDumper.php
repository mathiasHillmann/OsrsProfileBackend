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
    protected $signature = 'var-dumper {--download=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dumps all variables into files';

    private const DUMP_REPOSITORY = 'https://github.com/abextm/osrs-cache/';

    private const DUMP_PATH = 'app/tmp';

    private const VARIABLES_SOURCES = [
        'quests' => 'rs2asm/4024.rs2asm',
        'combat_achievements' => 'rs2asm/4834.rs2asm',
        'achievement_diaries' => 'rs2asm/56.rs2asm',
        'boss_kc' => 'rs2asm/4778.rs2asm',
    ];

    private const ENUMS = [
        'bosses' => '3971.json',
    ];

    // I need someone that is ranked on every boss to be able to get the hiscore id for an activity
    private string $hiscoreUser = 'Marni';

    private Collection $hiscoreData;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchHiscoreData();

        if (filter_var($this->option('download'), FILTER_VALIDATE_BOOL) === true) {
            $this->createTemporaryFiles();

            $this->downloadLatestCacheDump();
        }

        $this->getQuestVariables();
        $this->getCombatAchievementVariables();
        $this->getBossKcVariables();
    }

    private function fetchHiscoreData()
    {
        $service = new HiscoreService();

        $player = new Player([
            'username' => $this->hiscoreUser,
            'account_type' => RunescapeAccountTypes::Normal,
        ]);

        $this->hiscoreData = collect($service->fetchPlayer($player)['activities'] ?? []);
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
                    $info = $this->readDbrow($labelIdMap[$label])['columnValues'];
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

    private function getBossKcVariables(): void
    {
        $this->line(__FUNCTION__);

        $variables = [];
        $labelIdMap = [];

        $enum = $this->readEnum(self::ENUMS['bosses']);
        $bossMap = array_combine($enum['keys'], $enum['stringVals']);

        $this->readAsmFile(
            self::VARIABLES_SOURCES['boss_kc'],
            function (string $line, string $previousLine) use (&$variables, &$labelIdMap, $bossMap) {
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

                    // dd($labelIdMap, $bossMap, $label);
                    if (str_contains($label, 'LABEL')) {
                        $name = $this->getBossName($bossMap[$labelIdMap[$label]]);
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
    }

    private function readAsmFile(string $path, \Closure $callback): void
    {
        $asmFile = File::lines(storage_path(self::DUMP_PATH."/dump/{$path}"));
        $previousLine = '';

        foreach ($asmFile as $line) {
            $line = trim($line);

            $callback($line, $previousLine);

            $previousLine = $line;
        }
    }

    private function readDbrow(string $id): array
    {
        return json_decode(
            file_get_contents(
                storage_path(self::DUMP_PATH."/dump/dbrow/{$id}.json")
            ),
            true
        );
    }

    private function readEnum(string $file): array
    {
        return json_decode(
            file_get_contents(
                storage_path(self::DUMP_PATH."/dump/enums/{$file}")
            ),
            true
        );
    }
}
