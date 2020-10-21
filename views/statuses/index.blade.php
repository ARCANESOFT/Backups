@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-database"></i> @lang('Backups')
@endsection

@section('content')
    <x-arc:card>
        <x-arc:card-header>
            <div class="d-flex justify-content-between">
                <span class="d-inline-block">@lang('Monitor Statuses')</span>
                <div>
                    @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('create'))
                        <a class="btn btn-xs btn-success" onclick="ARCANESOFT.emit('backups::backups.create')">
                            <i class="far fa-fw fa-save"></i> @lang('Run Backup')
                        </a>
                    @endcan

                    @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('delete'))
                        <button class="btn btn-xs btn-warning" onclick="ARCANESOFT.emit('backups::backups.clear')">
                            <i class="fas fa-fw fa-eraser"></i> @lang('Clear Backups')
                        </button>
                    @endcan
                </div>
            </div>
        </x-arc:card-header>
        <x-arc:card-table class="table-hover">
            <thead>
                <tr>
                    <x-arc:table-th>@lang('Disk')</x-arc:table-th>
                    <x-arc:table-th>@lang('Name')</x-arc:table-th>
                    <x-arc:table-th class="text-center">@lang('Reachable')</x-arc:table-th>
                    <x-arc:table-th class="text-center">@lang('Healthy')</x-arc:table-th>
                    <x-arc:table-th class="text-center">@lang('Backups')</x-arc:table-th>
                    <x-arc:table-th class="text-center">@lang('Newest Backup')</x-arc:table-th>
                    <x-arc:table-th class="text-center">@lang('Used Storage')</x-arc:table-th>
                    <x-arc:table-th class="text-right">@lang('Actions')</x-arc:table-th>
                </tr>
            </thead>
            <tbody>
            @forelse($statuses as $index => $status)
                <?php
                /** @var  Arcanedev\LaravelBackup\Entities\BackupDestinationStatus  $status */
                $destination = $status->backupDestination()
                ?>
                <tr>
                    <td class="small font-monospace">{{ $destination->diskName() }}</td>
                    <td class="small">{{ $destination->backupName() }}</td>
                    <td class="small text-center">
                        @if ($destination->isReachable())
                            <span class="badge border border-success text-muted">@lang('Yes')</span>
                        @else
                            <span class="badge border border-danger text-muted">@lang('No')</span>
                        @endif
                    </td>
                    <td class="small text-center">
                        @if ($status->isHealthy())
                            <span class="badge border border-success text-muted">@lang('Yes')</span>
                        @else
                            <span class="badge border border-danger text-muted">@lang('No')</span>
                        @endif
                    </td>
                    <td class="small text-center">
                        @if ($destination->isReachable())
                            {{ arcanesoft\ui\count_pill($destination->backups()->count()) }}
                        @else
                            <span class="badge text-muted">-</span>
                        @endif
                    </td>
                    <td class="small text-center">
                        @if ($destination->isReachable() && $destination->newestBackup())
                            {{ $destination->newestBackup()->date()->diffForHumans() ?: 'No backups present' }}
                        @else
                            <span class="badge text-muted">-</span>
                        @endif
                    </td>
                    <td class="small text-center text-muted">
                        <span class="badge text-muted">{{ $destination->isReachable() ? $destination->humanReadableUsedStorage() : '-' }}</span>
                    </td>
                    <td class="text-right">
                        @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('show'))
                            <a href="{{ route('admin::backups.statuses.show', [$index]) }}"
                               class="btn btn-sm btn-light" data-toggle="tooltip" title="@lang('Show')">
                                <i class="far fa-fw fa-eye"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </x-arc:card-table>
    </x-arc:card>
@endsection

{{-- CREATE BACKUP MODAL/SCRIPT --}}
@can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('create'))
    @push('modals')
        <x-arc:modal id="run-backups-modal" aria-labelledby="run-backups-modal-title" data-backdrop="static">
            {{ form()->open(['route' => 'admin::backups.statuses.backup', 'method' => 'POST', 'id' => 'run-backups-form', 'autocomplete' => 'off']) }}
                <x-arc:modal-header>
                    <x-arc:modal-title id="run-backups-modal-title">
                        @lang('Run Backup')
                    </x-arc:modal-title>
                </x-arc:modal-header>
                <x-arc:modal-body>
                    @lang('Are you sure you want to run the backup ?')
                </x-arc:modal-body>
                <x-arc:modal-footer class="justify-content-between">
                    <x-arc:modal-cancel-button/>
                    <button class="btn btn-success" type="submit">@lang('Backup')</button>
                </x-arc:modal-footer>
            {{ form()->close() }}
        </x-arc:modal>
    @endpush

    @push('scripts')
        <script>
            let runBackupsModal = twbs.Modal.make('div#run-backups-modal')
            let runBackupsForm  = components.form('form#run-backups-form')

            ARCANESOFT.on('backups::backups.create', () => {
                runBackupsModal.show()
            })

            runBackupsForm.on('submit', (event) => {
                event.preventDefault()

                let submitBtn = components.loadingButton(
                    runBackupsForm.elt().querySelector('button[type="submit"]')
                )

                submitBtn.loading()

                ARCANESOFT
                    .request()
                    .post(runBackupsForm.getAction())
                    .then(({data}) => {
                        if (data.code === 'success') {
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
            let clearBackupsForm  = components.form('form#clear-backups-form')

            ARCANESOFT.on('backups::backups.clear', () => {
                clearBackupsModal.show()
            })

            clearBackupsForm.on('submit', (event) => {
                event.preventDefault()

                let submitBtn = components.loadingButton(
                    clearBackupsForm.elt().querySelector('button[type="submit"]')
                )

                submitBtn.loading()

                ARCANESOFT
                    .request()
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
