<?php namespace Arcanesoft\Backups\Policies;

use Arcanesoft\Core\Bases\Policy;
use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     StatusesPolicy
 *
 * @package  Arcanesoft\Backups\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatusesPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const PERMISSION_LIST     = 'backups.statuses.list';
    const PERMISSION_SHOW     = 'backups.statuses.show';
    const PERMISSION_CREATE   = 'backups.statuses.create';
    const PERMISSION_DELETE   = 'backups.statuses.delete';

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    /**
     * Allow to list all the backups.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function listPolicy(User $user)
    {
        return $user->may(static::PERMISSION_LIST);
    }

    /**
     * Allow to display a backup.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function showPolicy(User $user)
    {
        return $user->may(static::PERMISSION_SHOW);
    }

    /**
     * Allow to create a backup.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function createPolicy(User $user)
    {
        return $user->may(static::PERMISSION_CREATE);
    }

    /**
     * Allow to delete a backup.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function deletePolicy(User $user)
    {
        return $user->may(static::PERMISSION_DELETE);
    }
}
