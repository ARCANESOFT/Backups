<?php namespace Arcanesoft\Backups\Seeds;

use Arcanesoft\Auth\Seeds\PermissionsSeeder;
use Arcanesoft\Backups\Policies\StatusesPolicy;

/**
 * Class     PermissionsTableSeeder
 *
 * @package  Arcanesoft\Backups\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsTableSeeder extends PermissionsSeeder
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
                'group'       => [
                    'name'        => 'Backups',
                    'slug'        => 'backups',
                    'description' => 'backups permissions group',
                ],
                'permissions' => array_merge(
                    $this->getStatusesPermissions()
                ),
            ],
        ]);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the Statuses permissions.
     *
     * @return array
     */
    private function getStatusesPermissions()
    {
        return [
            [
                'name'        => 'Statuses - List all backups',
                'description' => 'Allow to list all posts.',
                'slug'        => StatusesPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Statuses - View a backup',
                'description' => 'Allow to display a post.',
                'slug'        => StatusesPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Statuses - Create a backup',
                'description' => 'Allow to create a post.',
                'slug'        => StatusesPolicy::PERMISSION_CREATE,
            ],
            [
                'name'        => 'Statuses - Delete a backup',
                'description' => 'Allow to delete a post.',
                'slug'        => StatusesPolicy::PERMISSION_DELETE,
            ],
        ];
    }
}
