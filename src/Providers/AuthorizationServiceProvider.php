<?php namespace Arcanesoft\Backups\Providers;

use Arcanesoft\Backups\Policies\StatusesPolicy;
use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Backups\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register any application authentication / authorization services.
     */
    public function boot()
    {
        parent::registerPolicies();

        $this->defineMany(StatusesPolicy::class, StatusesPolicy::policies());
    }
}
