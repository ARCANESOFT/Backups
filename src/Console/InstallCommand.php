<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Console;

use Arcanesoft\Backups\Database\DatabaseSeeder;
use Arcanesoft\Foundation\Support\Console\InstallCommand as Command;

/**
 * Class     InstallCommand
 *
 * @package  Arcanesoft\Backups\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InstallCommand extends Command
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backups:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Backups module.';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->seed(DatabaseSeeder::class);
    }
}
