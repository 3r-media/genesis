<?php

namespace Rrr\Genesis\Console\Commands;

use Illuminate\Console\Command;
use Rrr\Genesis\Support\StubPublisher;

class InstallGenesisCommand extends Command
{
    protected $signature = 'genesis:install {appPath?} 
    {--force : Overwrite existing files} 
    {--dev-stack : Install dev-stack}
    {--robots : Run the robots.txt setup prompt}
    {--all : Install all options with force overwrite}';

    protected $description = 'Install the Genesis package root stubs and packages';

    public function handle(): int
    {
        $all = $this->option('all');

        $force = $all || $this->option('force');
        $devStack = $all || $this->option('dev-stack');
        $robots = $all || $this->option('robots');

        if ($devStack) {
            $this->info('📦 Installing rrr/dev-stack...');
            passthru('composer require rrr/dev-stack --dev --with-all-dependencies');
        }

        $appPath = rtrim($this->argument('appPath') ?? base_path(), '/');
        $stubDir = __DIR__ . '/../../../resources/stubs';

        $publisher = new StubPublisher($stubDir, $appPath);

        $published = $publisher->publish([
            'gitignore.stub' => '.gitignore',
            'todo/install.md' => 'todo/install.md',
            '.env.example' => '.env.example',
            'README.md' => 'README.md',
            'phpunit.xml' => 'phpunit.xml',
            'tests' => 'tests',
            'tests/packages/.gitkeep'=> 'tests/packages/.gitkeep',
        ], $force);

        if (empty($published)) {
            $this->warn('No stubs were published (files may already exist).');
        } else {
            foreach ($published as $file) {
                $this->info("✅ Published: {$file}");
            }
        }

        if ($robots) {
            $this->info('🤖 Running robots.txt installer...');
            $this->call('robots:install');
        }

        return self::SUCCESS;
    }
}
