<?php

namespace App\Filament\Resources\SegmentResource\Pages;

use App\Filament\Resources\SegmentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSegment extends ViewRecord
{
    protected static string $resource = SegmentResource::class;

    protected static string $view = 'filament.user.segment-users';
}
