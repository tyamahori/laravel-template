<?php

namespace App\Console\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;

class SqlDefExport extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'sqldef:export';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'sqldef wrapper command to export schema.';

    /**
     * Execute the console command.
     * @param Repository $config
     * @param Application $application
     */
    public function handle(
        Repository $config,
        Application $application
    ): void {

        $schemaFile = $application->databasePath() . '/schema.sql';
        $dbUser = $config->get('database.connections.pgsql.username');
        $dbHost = $config->get('database.connections.pgsql.host');
        $dbName = $config->get('database.connections.pgsql.database');
        $dbPassword = $config->get('database.connections.pgsql.password');

        $command = "psqldef -U $dbUser -h $dbHost $dbName -W $dbPassword --export > $schemaFile";

        shell_exec($command);
    }
}
