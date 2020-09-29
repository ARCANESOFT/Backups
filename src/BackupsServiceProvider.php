<?php

declare(strict_types=1);

namespace Arcanesoft\Backups;

use Arcanesoft\Backups\Console\PublishCommand;
use Arcanesoft\Foundation\Support\Providers\PackageServiceProvider;

/**
 * Class     BackupsServiceProvider
 *
 * @package  Arcanesoft\Backups
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BackupsServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'backups';

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = true;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerConfig();

        $this->registerProviders([
            Providers\AuthServiceProvider::class,
            Providers\RouteServiceProvider::class,
        ]);

        $this->registerCommands([
            PublishCommand::class,
        ]);
    }

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->loadTranslations();
        $this->loadViews();

        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->publishTranslations();
            $this->publishViews();
        }
    }
}
