<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Database\Seeders;

use Arcanesoft\Foundation\Core\Database\PermissionsSeeder as Seeder;

/**
 * Class     PermissionsSeeder
 *
 * @package  Arcanesoft\Backups\Database\Seeders
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsSeeder extends Seeder
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
        $this->seed([
            'name'        => 'Backups',
            'slug'        => 'backups',
            'description' => 'backups permissions group',
        ], $this->getPermissionsFromPolicyManager('admin::backups.'));
    }
}
