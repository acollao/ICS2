<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DynamicDatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('dynamic-db-connection', function ($app, $parameters) {
            // Get the dynamic database name based on your logic (e.g., from a config, request, etc.)
            $dynamicDbName = $parameters['databaseName']; // This is the dbname you passed from the controller

            // Configure the dynamic database connection
            config(['database.connections.dynamic' => [
                'driver' => 'mysql', // Change this to your database driver
                'host' => '10.81.4.114',
                'database' => $dynamicDbName,
                'username' => 'dbadmin',
                'password' => 'Spiglobal@2023',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
            ]]);

            // Set the new connection as the current connection
            DB::purge('dynamic');
            DB::setDefaultConnection('dynamic');

            return DB::connection('dynamic');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
