<x-arc:layout>
    @section('page-title')
        <i class="fa fa-fw fa-database"></i> @lang('Backups')
    @endsection

    <x-arc:card>
        <x-arc:card-header>
            <div class="d-flex justify-content-between">
                <span class="d-inline-block">@lang('Monitor Statuses')</span>
                <div class="btn-separated">
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
                    <x-arc:table-th label="Disk"/>
                    <x-arc:table-th label="Name"/>
                    <x-arc:table-th label="Reachable" class="text-center"/>
                    <x-arc:table-th label="Healthy" class="text-center"/>
                    <x-arc:table-th label="Backups" class="text-center"/>
                    <x-arc:table-th label="Newest Backup" class="text-center"/>
                    <x-arc:table-th label="Used Storage" class="text-center"/>
                    <x-arc:table-th label="Actions" class="text-end"/>
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
                            <x-arc:badge type="success" label="Yes"/>
                        @else
                            <x-arc:badge type="danger" label="No"/>
                        @endif
                    </td>
                    <td class="small text-center">
                        @if ($status->isHealthy())
                            <x-arc:badge type="success" label="Yes"/>
                        @else
                            <x-arc:badge type="danger" label="No"/>
                        @endif
                    </td>
                    <td class="small text-center">
                        @if ($destination->isReachable())
                            <x-arc:badge-count value="{{ $destination->backups()->count() }}"/>
                        @else
                            <x-arc:badge type="light" label="--"/>
                        @endif
                    </td>
                    <td class="small text-center">
                        @if ($destination->isReachable() && $destination->newestBackup())
                            {{ $destination->newestBackup()->date()->diffForHumans() ?: 'No backups present' }}
                        @else
                            <x-arc:badge type="light" label="--"/>
                        @endif
                    </td>
                    <td class="small text-center text-muted">
                        <x-arc:badge type="light" label="{{ $destination->isReachable() ? $destination->humanReadableUsedStorage() : '--' }}"/>
                    </td>
                    <td class="text-end">
                        @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('show'))
                            <x-arc:table-action
                                type="show" action="{{ route('admin::backups.statuses.show', [$index]) }}"/>
                        @endcan
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </x-arc:card-table>
    </x-arc:card>

    {{-- CREATE BACKUP MODAL/SCRIPT --}}
    @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('create'))
        @push('modals')
            <x-arc:modal id="run-backups-modal" aria-labelledby="run-backups-modal-title" data-backdrop="static">
                <x-arc:form action="{{ route('admin::backups.statuses.backup') }}" method="POST" id="run-backups-form">
                    <x-arc:modal-header>
                        <x-arc:modal-title id="run-backups-modal-title">@lang('Run Backup')</x-arc:modal-title>
                    </x-arc:modal-header>
                    <x-arc:modal-body>@lang('Are you sure you want to run the backup ?')</x-arc:modal-body>
                    <x-arc:modal-footer class="justify-content-between">
                        <x-arc:modal-cancel-button/>
                        <button class="btn btn-success" type="submit">@lang('Backup')</button>
                    </x-arc:modal-footer>
                </x-arc:form>
            </x-arc:modal>
        @endpush

        @push('scripts')
            <script defer>
                let runBackupsModal = components.modal('div#run-backups-modal')
                let runBackupsForm  = components.form('form#run-backups-form')

                ARCANESOFT.on('backups::backups.create', () => {
                    runBackupsModal.show()
                })

                runBackupsForm.onSubmit('POST', () => {
                    runBackupsModal.hide()
                    location.reload()
                })
            </script>
        @endpush
    @endcan


    @can(Arcanesoft\Backups\Policies\StatusesPolicy::ability('delete'))
        @push('modals')
            <x-arc:modal id="clear-backups-modal" aria-labelledby="clear-backups-modal-title" data-backdrop="static">
                <x-arc:form action="{{ route('admin::backups.statuses.clear') }}" method="POST" id="clear-backups-form">
                    <x-arc:modal-header>
                        <x-arc:modal-title id="clear-backups-modal-title">@lang('Cleanup Backups')</x-arc:modal-title>
                    </x-arc:modal-header>
                    <x-arc:modal-body>@lang('Are you sure you want to cleanup the backups ?')</x-arc:modal-body>
                    <x-arc:modal-footer class="justify-content-between">
                        <x-arc:modal-cancel-button/>
                        <button class="btn btn-warning" type="submit">@lang('Cleanup')</button>
                    </x-arc:modal-footer>
                </x-arc:form>
            </x-arc:modal>
        @endpush

        @push('scripts')
            <script defer>
                let clearBackupsModal = components.modal('div#clear-backups-modal')
                let clearBackupsForm  = components.form('form#clear-backups-form')

                ARCANESOFT.on('backups::backups.clear', () => {
                    clearBackupsModal.show()
                })

                clearBackupsForm.onSubmit('POST', () => {
                    clearBackupsModal.hide()
                    location.reload()
                })
            </script>
        @endpush
    @endcan
</x-arc:layout>
