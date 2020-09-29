<?php

use Arcanesoft\Foundation\Auth\Models\Role;
use Arcanesoft\Backups\Policies\StatusesPolicy;

return [

    'items' => [
        [
            'name'        => 'foundation::backups',
            'title'       => 'Backups',
            'icon'        => 'fas fa-fw fa-database',
            'route'       => 'admin::backups.statuses.index',
            'roles'       => [],
            'permissions' => [
                'admin::backups.statuses.index',
            ],
        ],
    ],

];
