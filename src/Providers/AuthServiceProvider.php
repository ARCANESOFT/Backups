<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Providers;

use Arcanesoft\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Backups\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Getters
     | -----------------------------------------------------------------
     */

    /**
     * Get policy's classes.
     *
     * @return iterable
     */
    public function policyClasses(): iterable
    {
        return $this->app->get('config')->get('arcanesoft.backups.policies', []);
    }
}
