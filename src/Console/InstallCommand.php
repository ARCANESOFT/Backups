<?php namespace Arcanesoft\Backups\Console;

use Arcanedev\Support\Bases\Command;
use Arcanesoft\Backups\Seeds\DatabaseSeeder;

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
    protected $signature   = 'backups:install';

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
    public function handle()
    {
        $this->call('db:seed', ['--class' => DatabaseSeeder::class]);
    }
}
