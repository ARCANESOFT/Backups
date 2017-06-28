@section('header')
    <h1><i class="fa fa-fw fa-database"></i> {{ trans('backups::statuses.titles.backups') }} <small>{{ trans('backups::statuses.titles.monitor-status') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('backups::statuses.titles.monitor-status') }}</h2>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.name') }} :</th>
                                <td>
                                    <span class="label label-inverse">{{ $status->backupName() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.disk') }} :</th>
                                <td>
                                    <span class="label label-primary">{{ $status->diskName() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.reachable') }} :</th>
                                <td>
                                    @if ($status->isReachable())
                                        <span class="label label-success">Yes</span>
                                    @else
                                        <span class="label label-danger">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.healthy') }} :</th>
                                <td>
                                    @if ($status->isHealthy())
                                        <span class="label label-success">Yes</span>
                                    @else
                                        <span class="label label-danger">No</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.number_of_backups') }} :</th>
                                <td>
                                    @if ($status->isReachable())
                                        {{ label_count($status->amountOfBackups()) }}
                                    @else
                                        <span class="label label-default">/</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.newest_backup') }} :</th>
                                <td>
                                    @if ($status->isReachable())
                                        <small>{{ $status->dateOfNewestBackup() ?: 'null' }}</small>
                                    @else
                                        <span class="label label-default">/</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('backups::statuses.attributes.used_storage') }} :</th>
                                <td>
                                    @if ($status->isReachable())
                                        <span class="label label-default">{{ $status->humanReadableUsedStorage() }}</span>
                                    @else
                                        <span class="label label-default">/</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('backups::statuses.titles.backups') }}</h2>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <thead>
                                <tr>
                                    <th>{{ trans('backups::statuses.attributes.date') }}</th>
                                    <th>{{ trans('backups::statuses.attributes.path') }}</th>
                                    <th>{{ trans('backups::statuses.attributes.size') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($backups as $backup)
                                    <tr>
                                        <td>
                                            <small>{{ $backup->date() }}</small>
                                        </td>
                                        <td>
                                            <span class="label label-inverse">{{ $backup->path() }}</span>
                                        </td>
                                        <td>
                                            <span class="label label-default">
                                                {{ Spatie\Backup\Helpers\Format::humanReadableSize($backup->size()) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <span class="label label-default">There is no backups for the time being</span>
                                        </td>
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
