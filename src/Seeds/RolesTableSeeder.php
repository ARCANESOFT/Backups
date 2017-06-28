<?php namespace Arcanesoft\Backups\Seeds;

use Arcanesoft\Auth\Seeds\RolesSeeder;

/**
 * Class     RolesTableSeeder
 *
 * @package  Arcanesoft\Backups\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesTableSeeder extends RolesSeeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->seed([
            [
                'name'        => 'Backups Manager',
                'description' => 'The Backups manager role.',
                'is_locked'   => true,
            ],
        ]);

        $this->syncAdminRole();
        $this->syncRoles([
            'backups-manager' => 'backups.',
        ]);
    }
}
