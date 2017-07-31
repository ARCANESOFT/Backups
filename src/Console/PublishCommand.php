<?php namespace Arcanesoft\Backups\Console;

use Arcanedev\Support\Bases\Command;
use Arcanesoft\Backups\BackupsServiceProvider;

/**
 * Class     PublishCommand
 *
 * @package  Arcanesoft\Backups\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PublishCommand extends Command
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
    protected $signature   = 'backups:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish backups config, migrations and other stuff.';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => BackupsServiceProvider::class]);
    }
}
