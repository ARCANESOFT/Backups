<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Database;

use Arcanesoft\Backups\Database\Seeders\{PermissionsSeeder, RolesSeeder};
use Arcanesoft\Foundation\Support\Database\Seeder;

/**
 * Class     DatabaseSeeder
 *
 * @package  Arcanesoft\Backups\Database
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DatabaseSeeder extends Seeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the seeders.
     *
     * @return array
     */
    public function seeders(): array
    {
        return [
            PermissionsSeeder::class,
            RolesSeeder::class,
        ];
    }
}
