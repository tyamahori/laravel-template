<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;

use function is_array;

class SqlDefExecute extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'sqldef:execute';

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
        $environment = $application->environment();

        if ($environment === 'testing') {
            $this->error('This command is not available in testing environment.');

            return;
        }

        $schemaFile = $application->databasePath() . '/schema.sql';
        $dbUser = $config->get('database.connections.pgsql.username');
        $dbHost = $config->get('database.connections.pgsql.host');
        $dbName = $config->get('database.connections.pgsql.database');
        $dbPassword = $config->get('database.connections.pgsql.password');

        $dryRunCommand = "psqldef -U $dbUser -h $dbHost $dbName -W $dbPassword --dry-run < $schemaFile";
        $dryRunCommandOutPut = shell_exec($dryRunCommand);
        if (!$dryRunCommandOutPut) {
            $this->info('Failed to execute command.');

            return;
        }
        $this->info($dryRunCommandOutPut);
        if (!$this->confirm("You are in【'$environment'】. Do you wish to continue previous outputs ↑ ? :")) {
            $this->info('Aborted.');
        }

        $commandToExecute = "psqldef -U $dbUser -h $dbHost $dbName -W $dbPassword < $schemaFile";
        $commandToDisplay = 'psqldef -U $dbUser -h $dbHost $dbName -W $dbPassword < $schemaFile';

        $this->info("Executing command: $commandToDisplay");
        shell_exec($commandToExecute);
        $this->info('Command executed.');

        is_array([]);
    }
}
