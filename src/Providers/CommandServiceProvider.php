<?php namespace Arcanesoft\Backups\Providers;

use Arcanedev\Support\Providers\CommandServiceProvider as ServiceProvider;
use Arcanesoft\Backups\Console\InstallCommand;
use Arcanesoft\Backups\Console\PublishCommand;

/**
 * Class     CommandServiceProvider
 *
 * @package  Arcanesoft\Backups\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommandServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        PublishCommand::class,
    ];
}
