<?php namespace Arcanesoft\Backups\Http\Routes;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     StatusesRoutes
 *
 * @package  Arcanesoft\Backups\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatusesRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes for the application.
     */
    public function map()
    {
        $this->prefix('statuses')->as('statuses.')->group(function () {
            $this->get('/', 'StatusesController@index')
                 ->name('index');  // admin::backups.statuses.index

            $this->post('backup', 'StatusesController@backup')
                 ->middleware('ajax')
                 ->name('backup'); // admin::backups.statuses.backup

            $this->post('clear', 'StatusesController@clear')
                 ->middleware('ajax')
                 ->name('clear');  // admin::backups.statuses.clear

            $this->get('{index}', 'StatusesController@show')
                 ->name('show');   // admin::backups.statuses.clear
        });
    }
}
