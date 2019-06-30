<?php

namespace App\Console\Commands;

use App\Character;
use App\Graphic;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputOption;

class UpdateDatabaseFromFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the database of characters using files (see dictionary.txt and graphics.txt 
        from https://github.com/skishore/makemeahanzi)';

    private $updateChunkSize = 250;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->addOption('dry', null, InputOption::VALUE_NONE, 'Run the command with doing any change with the database.');
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if ($this->option('dry'))
            $this->comment('Running in dry mode, no change will be done to the database.');

        /*
         * First check if files exists
         */

        if (!Storage::disk()->exists('dictionary.txt')) {
            $this->error("dictionary.txt is missing, please check that you correctly put it in storage/app folder");

            return;
        }

        if (!Storage::disk()->exists('graphics.txt')) {
            $this->error("graphics.txt is missing, please check that you correctly put it in storage/app folder");

            return;
        }

        /*
         * Update dictionary data
         */

        $this->line('');
        $this->line('Processing dictionary...');
        $handle = Storage::disk()->readStream('dictionary.txt');
        $data = collect();
        $updated = 0;
        $created = 0;

        while (($line = fgets($handle)) !== false) {

            $data->push(json_decode($line, true));

            // In order to limit memory usage, we split
            // chunks of data to update
            if (count($data) === $this->updateChunkSize)
                $this->processDictionary($data, $created, $updated);
        }
        $this->processDictionary($data, $created, $updated);
        $this->info("$created new entries.");
        $this->info("$updated updated entries.");
        fclose($handle);

        /*
         * Update graphics data
         */

        $this->line('');
        $this->line('Processing graphics...');
        $handle = Storage::disk()->readStream('graphics.txt');
        $data = collect();
        $updated = 0;
        $created = 0;

        while (($line = fgets($handle)) !== false) {

            $data->push(json_decode($line, true));

            // In order to limit memory usage, we split
            // chunks of data to update
            if (count($data) === $this->updateChunkSize)
                $this->processGraphics($data, $created, $updated);
        }
        $this->processGraphics($data, $created, $updated);
        $this->info("$created new entries.");
        $this->info("$updated updated entries.");
        fclose($handle);

        return;
    }


    private function processDictionary(Collection &$data, int &$created, int &$updated)
    {
        $skipped = 0;
        $chars = Character::query()
            ->whereIn('character', $data->pluck('character'))
            ->select(['id', 'character'])
            ->get();

        foreach ($data as $el) {
            if (empty($el)) {
                $skipped++;
                continue;
            }

            /** @var Character $char */
            if (!$char = $chars->firstWhere('character', $el['character'])) {
                $char = new Character();
                $created++;
            } else {
                $updated++;
            }

            $char->fill($el);

            if (!$this->option('dry'))
                $char->save();

            $processed[] = $el['character'];
        }

        $this->comment(($created + $updated) . " characters processed" . ($skipped ? ". Skipped: $skipped" : ''));
        $data = collect();
    }


    private function processGraphics(Collection &$data, int &$created, int &$updated)
    {
        $skipped = 0;
        $chars = Graphic::query()
            ->whereIn('character', $data->pluck('character'))
            ->select(['id', 'character'])
            ->get();

        foreach ($data as $el) {
            if (empty($el)) {
                $skipped++;
                continue;
            }

            /** @var Graphic $char */
            if (!$char = $chars->firstWhere('character', $el['character'])) {
                $char = new Graphic();
                $created++;
            } else {
                $updated++;
            }

            $char->fill($el);

            if (!$this->option('dry'))
                $char->save();

            $processed[] = $el['character'];
        }

        $this->comment(($created + $updated) . " characters processed" . ($skipped ? ". Skipped: $skipped" : ''));
        $data = collect();
    }
}
