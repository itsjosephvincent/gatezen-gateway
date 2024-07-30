<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\User;
use App\Models\Wallet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use function Filament\Support\format_number;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
                ->description('Total users')
                ->color('success')
                ->chart([1, 3, 2, 5, 7, 5]),
            Stat::make('Projects', Project::count())
                ->description('Total projects')
                ->color('primary')
                ->chart([1, 3, 2, 5, 7, 5]),
            Stat::make('Wallet', format_number(Wallet::sum('balance'), 4, '.', ','))
                ->description('Sum of all user wallet balance')
                ->color('warning')
                ->chart([1, 3, 2, 5, 7, 5]),
        ];
    }
}
