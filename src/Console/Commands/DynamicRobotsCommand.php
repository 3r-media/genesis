<?php

namespace Rrr\Genesis\Console\Commands;

use Illuminate\Console\Command;
use Rrr\Genesis\Support\DynamicRobotsTxt;

class DynamicRobotsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robots:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(DynamicRobotsTxt::checkAndPromptForRobotsTxt());
    }
}
