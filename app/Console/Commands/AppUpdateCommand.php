<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'App update command.';

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
        if (!file_exists(base_path('.env'))) {
            $this->error('.env file does not exists');
            return 1;
        }

        if ($this->confirm('This action will update the app. Do you wish to continue?', true)) {
            // Clear cache.
            $this->call('cache:clear');
            $this->call('config:clear');

            # Generate metadata for develop.
            if (app()->isLocal()) {
                $this->call('ide-helper:meta');
            }

        }

        return 0;
    }
}
