<?php

namespace App\Console\Commands;

use Closure;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PharData;

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

    const DUMP_REPOSITORY = "https://github.com/abextm/osrs-cache/";

    const DUMP_PATH = 'app/tmp';
    const RESULT_PATH = 'app/vars';

    const VARIABLES_SOURCES = [
        'quests' => 'rs2asm/4024.rs2asm',
        'combat_achievements' => 'rs2asm/4834.rs2asm',
        'achievement_diaries' => 'rs2asm/56.rs2asm',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createTemporaryFiles();

        $this->downloadLatestCacheDump();

        $this->getQuestVariables();
    }

    private function createTemporaryFiles(): void
    {
        File::deleteDirectory(storage_path(self::DUMP_PATH));
        File::makeDirectory(storage_path(self::DUMP_PATH), 0777, true);

        File::deleteDirectory(storage_path(self::RESULT_PATH));
        File::makeDirectory(storage_path(self::RESULT_PATH), 0777, true);
    }

    private function downloadLatestCacheDump(): void
    {
        $response = Http::acceptJson()->get(sprintf('%s/releases/latest', self::DUMP_REPOSITORY));

        if ($response->successful()) {
            $tag = $response->object()->tag_name;
        } else {
            throw new Exception("Could not get tag from github: ({$response->status()}) - {$response->body()}");
        }

        $tarPath = storage_path(self::DUMP_PATH . DIRECTORY_SEPARATOR . 'cache.tar.gz');

        Http::sink($tarPath)
            ->get(sprintf('%s/releases/download/%s/dump-%s.tar.gz', self::DUMP_REPOSITORY, $tag, $tag));

        if (File::exists($tarPath)) {
            $tar = new PharData($tarPath);
            $tar->extractTo(storage_path(self::DUMP_PATH));
        } else {
            throw new Exception('Dump tar not found. Possibly did not download');
        }
    }

    private function readAsmFile(string $path, Closure $callback): void
    {
        $asmFile = File::lines(storage_path(self::DUMP_PATH . "/dump/{$path}"));
        $lastLine = '';

        foreach ($asmFile as $line) {
            $line = trim($line);

            $callback($line, $lastLine);

            $lastLine = $line;
        }
    }

    private function readDbrow(string $id): array
    {
        return json_decode(
            file_get_contents(
                storage_path(self::DUMP_PATH . "/dump/dbrow/{$id}.json")
            ),
            true
        );
    }

    private function getQuestVariables(): void
    {
        $variables = [];
        $labelIdMap = [];

        $this->readAsmFile(
            self::VARIABLES_SOURCES['quests'],
            function (string $line, string $lastLine) use (&$variables, &$labelIdMap) {
                // Example: "      10: LABEL3"
                if (preg_match('/\d+: LABEL\d+/', $line)) {
                    $data = explode(': ', $line); // [10, LABEL3]
                    $labelIdMap[$data[1]] = $data[0];
                }

                // Example: "   get_varp               32"
                if (str_contains($line, 'get_var')) {
                    $data = preg_split('/\s+/', $line); // [get_varp, 32]
                    $label = explode(':', $lastLine)[0]; // [LABEL3]
                    $varType = explode('_', $data[0]); // [get, varp]
                    $info = $this->readDbrow($labelIdMap[$label])['columnValues'];

                    $variables[] = [
                        'name' => $info[2][0] ?? 'Unknown',
                        'type' => $varType[1],
                        'index' => $data[1] ?? 0,
                        'low_value' => $info[16][0] ?? 0,
                        'high_value' => $info[17][0] ?? 0
                    ];
                }
            }
        );

        File::put(storage_path("app/vars/quests.json"), json_encode($variables,  JSON_PRETTY_PRINT));
    }
}
