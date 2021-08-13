<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Http\Routes;

use Arcanesoft\Foundation\Support\Http\AdminRouteRegistrar;
use Closure;

/**
 * Class     AbstractRouteRegistrar
 *
 * @package  Arcanesoft\Backups\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractRouteRegistrar extends AdminRouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Group routes under a module stack.
     *
     * @param  \Closure  $callback
     */
    protected function moduleGroup(Closure $callback): void
    {
        $this->prefix('backups')
             ->name('backups.')
             ->group($callback);
    }
}
