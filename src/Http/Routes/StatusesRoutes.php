<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Http\Routes;

use Arcanesoft\Backups\Http\Controllers\StatusesController;

/**
 * Class     StatusesRoutes
 *
 * @package  Arcanesoft\Backups\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatusesRoutes extends AbstractRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes for the application.
     */
    public function map(): void
    {
        $this->adminGroup(function () {
            $this->prefix('statuses')->as('statuses.')->group(function () {
                // admin::backups.statuses.index
                $this->get('/', [StatusesController::class, 'index'])
                     ->name('index');

                // admin::backups.statuses.backup
                $this->post('backup', [StatusesController::class, 'backup'])
                     ->middleware(['ajax'])
                     ->name('backup');

                // admin::backups.statuses.clear
                $this->post('clear', [StatusesController::class, 'clear'])
                     ->middleware(['ajax'])
                     ->name('clear');

                // admin::backups.statuses.clear
                $this->get('{index}', [StatusesController::class, 'show'])
                     ->name('show');
            });
        });
    }
}
