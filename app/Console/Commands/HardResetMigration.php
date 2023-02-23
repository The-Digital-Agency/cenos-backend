<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HardResetMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hardreset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hard reset, migrate and seed the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Resetting and Reloading Table!');
        $this->call('migrate:fresh', ['--seed']);
        $this->info('Done!');
    }
}
