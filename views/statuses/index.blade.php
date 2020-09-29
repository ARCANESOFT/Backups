@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-database"></i> @lang('Backups')
@endsection

@section('content')
    <div class="card card-borderless shadow-sm">
        <div class="card-header px-2">
            <div class="d-flex justify-content-between">
                <span class="d-inline-block">@lang('Monitor Statuses')</span>
                <div>
                    @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('create'))
                        <a class="btn btn-xs btn-success" onclick="Foundation.$emit('backups::backups.create')">
                            <i class="far fa-fw fa-save"></i> @lang('Run Backup')
                        </a>
                    @endcan

                    @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('delete'))
                        <button class="btn btn-xs btn-warning" onclick="Foundation.$emit('backups::backups.clear')">
                            <i class="fas fa-fw fa-eraser"></i> @lang('Clear Backups')
                        </button>
                    @endcan
                </div>
            </div>
        </div>
        <table class="table table-condensed table-hover mb-0">
            <thead>
                <tr>
                    <th class="font-weight-light text-uppercase text-muted">@lang('Disk')</th>
                    <th class="font-weight-light text-uppercase text-muted">@lang('Name')</th>
                    <th class="font-weight-light text-uppercase text-muted text-center">@lang('Reachable')</th>
                    <th class="font-weight-light text-uppercase text-muted text-center">@lang('Healthy')</th>
                    <th class="font-weight-light text-uppercase text-muted text-center">@lang('Backups')</th>
                    <th class="font-weight-light text-uppercase text-muted text-center">@lang('Newest Backup')</th>
                    <th class="font-weight-light text-uppercase text-muted text-center">@lang('Used Storage')</th>
                    <th class="font-weight-light text-uppercase text-muted text-right">@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
            @forelse($statuses as $index => $status)
                <?php
                /** @var  Arcanedev\LaravelBackup\Entities\BackupDestinationStatus  $status */
                $destination = $status->backupDestination()
                ?>
                <tr>
                    <td class="font-monospace">{{ $destination->diskName() }}</td>
                    <td>{{ $destination->backupName() }}</td>
                    <td class="text-center">
                        @if ($destination->isReachable())
                            <span class="badge badge-outline-success">@lang('Yes')</span>
                        @else
                            <span class="badge badge-outline-danger">@lang('No')</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($status->isHealthy())
                            <span class="badge badge-outline-success">@lang('Yes')</span>
                        @else
                            <span class="badge badge-outline-danger">@lang('No')</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($destination->isReachable())
                            {{ arcanesoft\ui\count_pill($destination->backups()->count()) }}
                        @else
                            <span class="badge badge-default">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($destination->isReachable() && $destination->newestBackup())
                            <small>{{ $destination->newestBackup()->date()->diffForHumans() ?: 'No backups present' }}</small>
                        @else
                            <span class="badge badge-default">-</span>
                        @endif
                    </td>
                    <td class="font-weight-bold text-muted text-center small">
                        {{ $destination->isReachable() ? $destination->humanReadableUsedStorage() : '-' }}
                    </td>
                    <td class="text-right">
                        @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('show'))
                            {{ arcanesoft\ui\action_link_icon('show', route('admin::backups.statuses.show', [$index]))->size('sm') }}
                        @endcan
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

{{-- CREATE BACKUP MODAL/SCRIPT --}}
@can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('create'))
    @push('modals')
        <div id="run-backups-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => 'admin::backups.statuses.backup', 'method' => 'POST', 'id' => 'run-backups-form', 'class' => '', 'autocomplete' => 'off']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelTitleId">@lang('Run Backup')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('Are you sure you want to run the backup ?')
                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                        <button class="btn btn-success" type="submit">@lang('Backup')</button>
                    </div>
                </div>
                {{ form()->close() }}
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            let runBackupsModal = twbs.Modal.make('div#run-backups-modal')
            let runBackupsForm  = Form.make('form#run-backups-form')

            Foundation.$on('backups::backups.create', () => {
                runBackupsModal.show()
            })

            runBackupsForm.on('submit', (event) => {
                event.preventDefault()

                let submitBtn = Foundation.ui.loadingButton(
                    runBackupsForm.elt().querySelector('button[type="submit"]')
                )

                submitBtn.loading()

                request()
                    .post(runBackupsForm.getAction())
                    .then((response) => {
                        if (response.data.code === 'success') {
                            runBackupsModal.hide()
                            location.reload()
                        }
                        else {
                            alert('ERROR ! Check the console !')
                            submitBtn.reset()
                        }
                    })
                    .catch(function (error) {
                        alert('AJAX ERROR ! Check the console !')
                        console.log(error)
                        submitBtn.reset()
                    })
            })
        </script>
    @endpush
@endcan


@can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('delete'))
    @push('modals')
        <div id="clear-backups-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog">
                {{ form()->open(['route' => 'admin::backups.statuses.clear', 'method' => 'POST', 'id' => 'clear-backups-form', 'class' => '', 'autocomplete' => 'off']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelTitleId">@lang('Cleanup Backups')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('Are you sure you want to cleanup the backups ?')
                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                        <button class="btn btn-warning" type="submit">@lang('Cleanup')</button>
                    </div>
                </div>
                {{ form()->close() }}
            </div>
        </div>
    @endpush

    @push('scripts')
        <script>
            let clearBackupsModal = twbs.Modal.make('div#clear-backups-modal')
            let clearBackupsForm  = Form.make('form#clear-backups-form')

            Foundation.$on('backups::backups.clear', () => {
                clearBackupsModal.show()
            })

            clearBackupsForm.on('submit', (event) => {
                event.preventDefault()

                let submitBtn = Foundation.ui.loadingButton(
                    clearBackupsForm.elt().querySelector('button[type="submit"]')
                )

                submitBtn.loading()

                request()
                    .post(clearBackupsForm.getAction())
                    .then(function (response) {
                        if (response.data.code === 'success') {
                            clearBackupsModal.hide()
                            location.reload()
                        }
                        else {
                            alert('ERROR ! Check the console !')
                            submitBtn.reset()
                        }
                    })
                    .catch(function (error) {
                        alert('AJAX ERROR ! Check the console !')
                        console.log(error)
                        submitBtn.reset()
                    })
            })
        </script>
    @endpush
@endcan
