<?php namespace Arcanesoft\Backups\Providers;

use Arcanesoft\Backups\Http\Routes;
use Arcanesoft\Core\Bases\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanesoft\Backups\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The admin controller namespace for the application.
     *
     * @var string
     */
    protected $adminNamespace = 'Arcanesoft\\Backups\\Http\\Controllers\\Admin';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the route bindings.
     */
    protected function registerRouteBindings()
    {
        //
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->adminGroup(function () {
            $this->mapAdminRoutes();
        });
    }

    /**
     * Define the admin routes for the application.
     */
    private function mapAdminRoutes()
    {
        $this->name('backups.')
            ->prefix($this->config()->get('arcanesoft.backups.route.prefix', 'backups'))
            ->group(function () {
                Routes\StatusesRoutes::register();
            });
    }
}
