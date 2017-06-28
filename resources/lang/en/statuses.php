<?php

return [

    /* -----------------------------------------------------------------
     |  Attributes
     | -----------------------------------------------------------------
     */

    'attributes' => [
        'name'              => 'Name',
        'disk'              => 'Disk',
        'reachable'         => 'Reachable',
        'healthy'           => 'Healthy',
        'number_of_backups' => '# of backups',
        'newest_backup'     => 'Newest backup',
        'used_storage'      => 'Used storage',

        'date'              => 'Date',
        'path'              => 'Path',
        'size'              => 'Size',
    ],

    /* -----------------------------------------------------------------
     |  Titles
     | -----------------------------------------------------------------
     */

    'titles' => [
        'backups'               => 'Backups',
        'monitor-status'        => 'Monitor Status',
        'monitor-statuses-list' => 'List of Monitor Statuses',
    ],

    /* -----------------------------------------------------------------
     |  Actions
     | -----------------------------------------------------------------
     */

    'actions' => [
        'run-backups'   => 'Run Backups',
        'clear-backups' => 'Clear Backups',
    ],

    /* -----------------------------------------------------------------
     |  Messages
     | -----------------------------------------------------------------
     */

    'messages' => [
        'created' => [
            'title'   => 'Backups created !',
            'message' => 'The Backups was created successfully !',
        ],

        'cleared' => [
            'title'   => 'Backups cleared !',
            'message' => 'The Backups was cleared successfully !',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Modals
     | -----------------------------------------------------------------
     */

    'modals' => [
        'backup' => [
            'title'   => 'Backup all',
            'message' => 'Are you sure you want to run the <span class="label label-success">backups</span> ?',
        ],

        'clear' => [
            'title'   => 'Clear all backups',
            'message' => 'Are you sure you want to <span class="label label-warning">clear</span> all the backups ?',
        ],
    ],

];
