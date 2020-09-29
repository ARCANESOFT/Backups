<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Services;

use Arcanedev\LaravelBackup\Actions\Backup\BackupAction;
use Arcanedev\LaravelBackup\Actions\Cleanup\CleanAction;
use Arcanedev\LaravelBackup\Entities\{BackupDestinationStatus, BackupDestinationStatusCollection};

/**
 * Class     BackupStatuses
 *
 * @package  Arcanesoft\Backups\Services
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BackupService
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\LaravelBackup\Actions\Backup\BackupAction */
    protected $backupAction;

    /** @var  \Arcanedev\LaravelBackup\Actions\Cleanup\CleanAction */
    protected $cleanAction;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * BackupService constructor.
     *
     * @param  \Arcanedev\LaravelBackup\Actions\Backup\BackupAction  $backupAction
     * @param  \Arcanedev\LaravelBackup\Actions\Cleanup\CleanAction  $cleanAction
     */
    public function __construct(BackupAction $backupAction, CleanAction $cleanAction)
    {
        $this->backupAction = $backupAction;
        $this->cleanAction = $cleanAction;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get all the statuses.
     *
     * @return \Arcanedev\LaravelBackup\Entities\BackupDestinationStatus[]|\Arcanedev\LaravelBackup\Entities\BackupDestinationStatusCollection
     */
    public function statuses(): BackupDestinationStatusCollection
    {
        return BackupDestinationStatusCollection::makeFromConfig();
    }

    /**
     * Get a status by index.
     *
     * @param  int  $index
     *
     * @return \Spatie\Backup\Tasks\Monitor\BackupDestinationStatus|null
     */
    public function getStatus($index): ?BackupDestinationStatus
    {
        return $this->statuses()->get($index);
    }

    /**
     * Run the backups.
     *
     * @param  string|null  $disk
     *
     * @return bool
     */
    public function runBackups($disk = null): bool
    {
        try {
            $this->backupAction->execute([
                //
            ]);

            return true;
        }
        catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Clean the backups.
     *
     * @return bool
     */
    public function clearBackups(): bool
    {
        try {
            $this->cleanAction->execute([
                //
            ]);

            return true;
        }
        catch (\Exception $ex) {
            return false;
        }
    }
}
