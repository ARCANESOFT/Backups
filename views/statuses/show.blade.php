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
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">@lang('Monitor Status')</div>
                <table class="table table-condensed mb-0">
                    <tr>
                        <th>@lang('Name') :</th>
                        <td class="text-right">
                            <span class="badge badge-outline-dark">{{ $destination->backupName() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Disk') :</th>
                        <td class="text-right">
                            <span class="badge badge-outline-primary">{{ $destination->diskName() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Reachable') :</th>
                        <td class="text-right">
                            @if ($destination->isReachable())
                                <span class="badge badge-outline-success">@lang('Yes')</span>
                            @else
                                <span class="badge badge-outline-danger">@lang('No')</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Healthy') :</th>
                        <td class="text-right">
                            @if ($status->isHealthy())
                                <span class="badge badge-outline-success">@lang('Yes')</span>
                            @else
                                <span class="badge badge-outline-danger">@lang('No')</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Backups') :</th>
                        <td class="text-right">
                            @if ($destination->isReachable())
                                {{ arcanesoft\ui\count_pill($destination->backups()->count()) }}
                            @else
                                <span class="badge badge-default">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Newest Backup') :</th>
                        <td class="text-right">
                            @if ($destination->isReachable() && $destination->newestBackup())
                                <small>{{ $destination->newestBackup()->date()->diffForHumans() ?: 'null' }}</small>
                            @else
                                <span class="badge badge-default">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Used Storage') :</th>
                        <td class="text-right">
                            <span class="badge badge-light">
                                {{ $destination->isReachable() ? $destination->humanReadableUsedStorage() : '-' }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">
                    @lang('Backups')
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Path')</th>
                                    <th class="text-right">@lang('Size')</th>
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
                                            <span class="badge badge-default">
                                                {{ $backup->humanReadableSize() }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">There is no backups for the time being</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
