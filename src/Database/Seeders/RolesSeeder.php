<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Database\Seeders;

use Arcanesoft\Foundation\Core\Database\RolesSeeder as Seeder;

/**
 * Class     RolesSeeder
 *
 * @package  Arcanesoft\Backups\Database\Seeders
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesSeeder extends Seeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedMany([
            [
                'name'        => 'Backups Manager',
                'description' => 'The Backups manager role.',
                'is_locked'   => true,
            ],
        ]);

        $this->syncRolesWithPermissions([
            'backups-manager' => [
                'admin::backups.*',
            ],
        ]);
    }
}
