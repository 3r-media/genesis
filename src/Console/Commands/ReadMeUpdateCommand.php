<?php

namespace Rrr\Genesis\Console\Commands;

use Illuminate\Console\Command;
use Rrr\Genesis\Support\DynamicReadme;

class ReadMeUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'readme:update {composerPath?} {packagePath?} {readmePath?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the README file with the dependencies from the composer.json file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $composerPath = $this->argument('composerPath') ?? base_path('composer.json');
        $packagePath = $this->argument('packagePath') ?? base_path('package.json');
        $readmePath = $this->argument('readmePath') ?? base_path('README.md');

        DynamicReadme::updateReadme($composerPath, $packagePath, $readmePath);

        $this->info('README file has been updated with dependencies from composer.json and package.json.');
    }
}
