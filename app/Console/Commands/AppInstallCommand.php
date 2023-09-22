<?php

namespace App\Console\Commands;

use Database\Seeders\AuthPassportSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AppInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'App installation command';

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

        // Clear cache.
        $this->call('cache:clear');
        $this->call('config:clear');

        // Generate app key.
        $this->call('key:generate');

        // Install database + seeder.
        $this->call('migrate:fresh', ['--seed' => true]);

        $this->installApp();

        # Generate metadata for develop.
        if (app()->isLocal()) {
            $this->call('ide-helper:meta');
        }

        return 0;
    }

    private function installApp()
    {
        $provider = in_array('users', array_keys(Config::get('auth.providers'))) ? 'users' : null;
        Artisan::call('passport:keys');
        Artisan::call(
            'passport:client',
            [
                '--personal' => true,
                '--name' => 'Personal Access Client',
            ]
        );
        Artisan::call(
            'passport:client',
            [
                '--password' => true,
                '--name' => 'Password Grant Client',
                '--provider' => $provider,
            ]
        );

        // Keep the same API key + secret.
        $secret = config('app.api_secret');
        DB::table('oauth_clients')->where('id', '=', 1)->update([
            'secret' => $secret,
        ]);
        $this->info('Secret: '. $secret);
    }
}
