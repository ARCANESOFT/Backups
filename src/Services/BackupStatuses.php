<?php namespace Arcanesoft\Backups\Services;

use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\Tasks\Cleanup\CleanupJob;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

/**
 * Class     BackupStatuses
 *
 * @package  Arcanesoft\Backups\Services
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BackupStatuses
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get all the statuses.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        return BackupDestinationStatusFactory::createForMonitorConfig(config('laravel-backup.monitorBackups'));
    }

    /**
     * Get a status by index.
     *
     * @param  int  $index
     *
     * @return \Spatie\Backup\Tasks\Monitor\BackupDestinationStatus|null
     */
    public static function getStatus($index)
    {
        return static::all()->get($index);
    }

    /**
     * Run the backups.
     *
     * @param  string|null  $disk
     *
     * @return bool
     */
    public static function runBackups($disk = null)
    {
        try {
            $backupJob = BackupJobFactory::createFromArray(config('laravel-backup'));

            if ( ! is_null($disk)) {
                $backupJob->onlyBackupTo($disk);
            }

            $backupJob->run();
        }
        catch (\Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * Clean the backups.
     *
     * @return bool
     */
    public static function clearBackups()
    {
        try {
            $config = config('laravel-backup');

            $backupDestinations = BackupDestinationFactory::createFromArray($config['backup']);

            $strategy = app($config['cleanup']['strategy']);

            $disableNotification = false; // TODO: Create a config for this

            (new CleanupJob($backupDestinations, $strategy, $disableNotification))->run();
        }
        catch (\Exception $ex) {
            return false;
        }

        return true;
    }
}
