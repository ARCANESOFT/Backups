<?php

declare(strict_types=1);

namespace Arcanesoft\Backups\Http\Controllers;

use Arcanesoft\Backups\Policies\StatusesPolicy;
use Arcanesoft\Backups\Services\BackupService;
use Arcanesoft\Foundation\Support\Traits\HasNotifications;
use Illuminate\Support\Facades\Log;

/**
 * Class     StatusesController
 *
 * @package  Arcanesoft\Backups\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatusesController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasNotifications;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Backups\Services\BackupService */
    protected $backupService;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * StatusesController constructor.
     */
    public function __construct(BackupService $backupService)
    {
        parent::__construct();

        $this->setCurrentSidebarItem('foundation::backups');
        $this->addBreadcrumbRoute(__('Backups'), 'admin::backups.statuses.index');

        $this->backupService = $backupService;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(StatusesPolicy::ability('index'));

        $statuses = $this->backupService->statuses();

        $this->setTitle($title = __('List of Monitor Statuses'));
        $this->addBreadcrumb($title);

        return $this->view('statuses.index', compact('statuses'));
    }

    public function show($index)
    {
        $this->authorize(StatusesPolicy::ability('show'));

        $status = $this->backupService->getStatus($index);

        abort_if(is_null($status), 404);

        $this->setTitle($title = __('Monitor Status'));
        $this->addBreadcrumb($title);

        return $this->view('statuses.show', compact('status'));
    }

    public function backup()
    {
        $this->authorize(StatusesPolicy::ability('create'));

        if ($this->backupService->runBackups()) {
            return static::jsonResponseSuccess([
                'message' => $this->transNotification('created'),
            ]);
        }

        return static::jsonResponseError([
            'message' => 'There is an error while running the backups.'
        ]);
    }

    public function clear()
    {
        $this->authorize(StatusesPolicy::ability('clean'));

        if ($this->backupService->clearBackups()) {
            return static::jsonResponseSuccess([
                'message' => $this->transNotification('cleared'),
            ]);
        }

        return static::jsonResponseError(['message' => 'There is an error while running the backups.']);
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
        static::notifySuccess($title, $message);

        return $message;
    }
}
