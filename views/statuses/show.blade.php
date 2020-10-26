@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-database"></i> @lang('Backups')
@endsection

<?php
/** @var  Arcanedev\LaravelBackup\Entities\BackupDestinationStatus  $status */
$destination = $status->backupDestination()
?>

@section('content')
    <div class="row">
        <div class="col-md-4">
            <x-arc:card>
                <x-arc:card-header>@lang('Monitor Status')</x-arc:card-header>
                <x-arc:card-table>
                    <tr>
                        <x-arc:table-th label="Name"/>
                        <td class="text-right small">{{ $destination->backupName() }}</td>
                    </tr>
                    <tr>
                        <x-arc:table-th label="Disk"/>
                        <td class="text-right small font-monospace">{{ $destination->diskName() }}</td>
                    </tr>
                    <tr>
                        <x-arc:table-th label="Reachable"/>
                        <td class="text-right small">
                            @if ($destination->isReachable())
                                <span class="badge border border-success text-muted">@lang('Yes')</span>
                            @else
                                <span class="badge border border-danger text-muted">@lang('No')</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <x-arc:table-th label="Healthy"/>
                        <td class="text-right small">
                            @if ($status->isHealthy())
                                <span class="badge border border-success text-muted">@lang('Yes')</span>
                            @else
                                <span class="badge border border-danger text-muted">@lang('No')</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <x-arc:table-th label="Backups"/>
                        <td class="text-right small">
                            @if ($destination->isReachable())
                                <x-arc:badge-count value="{{ $destination->backups()->count() }}"/>
                            @else
                                <span class="badge text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <x-arc:table-th label="Newest Backup"/>
                        <td class="text-right small">
                            @if ($destination->isReachable() && $destination->newestBackup())
                                <small>{{ $destination->newestBackup()->date()->diffForHumans() ?: 'null' }}</small>
                            @else
                                <span class="badge text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <x-arc:table-th label="Used Storage"/>
                        <td class="text-right small">
                            <span class="badge text-muted">{{ $destination->isReachable() ? $destination->humanReadableUsedStorage() : '-' }}</span>
                        </td>
                    </tr>
                </x-arc:card-table>
            </x-arc:card>
        </div>

        <div class="col-md-8">
            {{-- BACKUPS --}}
            <x-arc:card>
                <x-arc:card-header>@lang('Backups')</x-arc:card-header>
                <x-arc:card-table class="table-hover">
                    <thead>
                        <tr>
                            <x-arc:table-th label="Date"/>
                            <x-arc:table-th label="Path"/>
                            <x-arc:table-th label="Size" class="text-right"/>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($destination->backups() as $backup)
                        <?php /** @var  Arcanedev\LaravelBackup\Entities\Backup  $backup */ ?>
                        <tr>
                            <td>
                                <small>{{ $backup->date() }}</small>
                            </td>
                            <td>
                                <span class="badge badge-inverse">{{ $backup->path() }}</span>
                            </td>
                            <td class="text-right">
                                <span class="badge badge-default">{{ $backup->humanReadableSize() }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted small">@lang('There is no backups for the time being')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </x-arc:card-table>
            </x-arc:card>
        </div>
    </div>
@endsection
