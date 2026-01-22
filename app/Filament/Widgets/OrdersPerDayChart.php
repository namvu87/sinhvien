<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersPerDayChart extends ChartWidget
{
    protected ?string $heading = 'Đơn hàng theo ngày (14 ngày)';

    protected function getData(): array
    {
        $start = now()->subDays(13)->startOfDay();
        $dates = collect(range(0, 13))->map(fn ($i) => $start->copy()->addDays($i)->toDateString());

        $counts = Order::query()
            ->selectRaw('DATE(order_date) as order_date, COUNT(*) as c')
            ->whereDate('order_date', '>=', $start->toDateString())
            ->groupBy('order_date')
            ->pluck('c', 'order_date');

        $data = $dates->map(fn ($d) => (int) ($counts[$d] ?? 0))->all();
        $labels = $dates->map(fn ($d) => now()->parse($d)->format('d/m'))->all();

        return [
            'datasets' => [
                [
                    'label' => 'Số đơn hàng',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => '#3b82f6',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
