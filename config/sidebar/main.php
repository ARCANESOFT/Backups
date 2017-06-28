<?php

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Backups\Policies\StatusesPolicy;

return [
    'title'       => 'backups::sidebar.backups',
    'name'        => 'backups-statuses',
    'route'       => 'admin::backups.statuses.index',
    'icon'        => 'fa fa-fw fa-database',
    'roles'       => [Role::ADMINISTRATOR],
    'permissions' => [
        StatusesPolicy::PERMISSION_LIST,
    ],
    'children'    => [
        //
    ],
];
