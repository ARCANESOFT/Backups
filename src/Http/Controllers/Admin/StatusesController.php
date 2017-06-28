<?php namespace Arcanesoft\Backups\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Backups\Policies\StatusesPolicy;
use Arcanesoft\Backups\Services\BackupStatuses;
use Illuminate\Support\Facades\Log;

/**
 * Class     StatusesController
 *
 * @package  Arcanesoft\Backups\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatusesController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use JsonResponses;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * StatusesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('backups-statuses');
        $this->addBreadcrumbRoute(trans('backups::statuses.titles.backups'), 'admin::backups.statuses.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(StatusesPolicy::PERMISSION_LIST);

        $statuses = BackupStatuses::all();

        $this->setTitle($title = trans('backups::statuses.titles.monitor-statuses-list'));
        $this->addBreadcrumb($title);

        return $this->view('admin.statuses.index', compact('statuses'));
    }

    public function show($index)
    {
        $this->authorize(StatusesPolicy::PERMISSION_SHOW);

        if (is_null($status = BackupStatuses::getStatus($index)))
            self::pageNotFound();

        $backups = $status->backupDestination()->backups();

        $this->setTitle($title = trans('backups::statuses.titles.monitor-status'));
        $this->addBreadcrumb($title);

        return $this->view('admin.statuses.show', compact('status', 'backups'));
    }

    public function backup()
    {
        $this->authorize(StatusesPolicy::PERMISSION_CREATE);

        if (BackupStatuses::runBackups()) {
            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('created'),
            ]);
        }

        return $this->jsonResponseError(['message' => 'There is an error while running the backups.']);
    }

    public function clear()
    {
        $this->authorize(StatusesPolicy::PERMISSION_DELETE);

        if (BackupStatuses::clearBackups()) {
            return $this->jsonResponseSuccess([
                'message' => $this->transNotification('cleared'),
            ]);
        }

        return $this->jsonResponseError(['message' => 'There is an error while running the backups.']);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Notify with translation.
     *
     * @param  string  $action
     * @param  array   $replace
     * @param  array   $context
     *
     * @return string
     */
    protected function transNotification($action, array $replace = [], array $context = [])
    {
        $title   = trans("backups::statuses.messages.{$action}.title");
        $message = trans("backups::statuses.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
