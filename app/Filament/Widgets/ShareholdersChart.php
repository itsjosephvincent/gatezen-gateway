<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class ShareholdersChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Shareholders among projects';

    protected function getData(): array
    {
        $shareholders = $this->getShareHolders();

        $labels = [];
        $data = [];
        foreach ($shareholders as $shareholder) {
            array_push($labels, $shareholder->project_name);
            array_push($data, $shareholder->user_count);
        }
        $chartData = [
            'datasets' => [
                [
                    'label' => 'Shareholders',
                    'data' => $data,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $labels,
        ];

        return $chartData;
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getShareHolders()
    {
        $shareholders = User::selectRaw('COUNT(*) as user_count, projects.name as project_name')
            ->leftJoin('wallets', 'wallets.holdable_id', '=', 'users.id')
            ->leftJoin('tickers', 'tickers.id', '=', 'wallets.belongable_id')
            ->leftJoin('projects', 'projects.id', '=', 'tickers.project_id')
            ->where('wallets.balance', '>', 0)
            ->groupBy('projects.name')
            ->get();

        return $shareholders;
    }
}
