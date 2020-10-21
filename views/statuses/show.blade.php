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
                        <th class="font-weight-light text-uppercase text-muted">@lang('Name')</th>
                        <td class="text-right small">{{ $destination->backupName() }}</td>
                    </tr>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">@lang('Disk')</th>
                        <td class="text-right small font-monospace">{{ $destination->diskName() }}</td>
                    </tr>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">@lang('Reachable')</th>
                        <td class="text-right small">
                            @if ($destination->isReachable())
                                <span class="badge border border-success text-muted">@lang('Yes')</span>
                            @else
                                <span class="badge border border-danger text-muted">@lang('No')</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">@lang('Healthy')</th>
                        <td class="text-right small">
                            @if ($status->isHealthy())
                                <span class="badge border border-success text-muted">@lang('Yes')</span>
                            @else
                                <span class="badge border border-danger text-muted">@lang('No')</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">@lang('Backups')</th>
                        <td class="text-right small">
                            @if ($destination->isReachable())
                                {{ arcanesoft\ui\count_pill($destination->backups()->count()) }}
                            @else
                                <span class="badge text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">@lang('Newest Backup')</th>
                        <td class="text-right small">
                            @if ($destination->isReachable() && $destination->newestBackup())
                                <small>{{ $destination->newestBackup()->date()->diffForHumans() ?: 'null' }}</small>
                            @else
                                <span class="badge text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="font-weight-light text-uppercase text-muted">@lang('Used Storage')</th>
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
                            <x-arc:table-th>@lang('Date')</x-arc:table-th>
                            <x-arc:table-th>@lang('Path')</x-arc:table-th>
                            <x-arc:table-th class="text-right">@lang('Size')</x-arc:table-th>
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

@section('scripts')
@endsection
