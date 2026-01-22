<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStats extends BaseWidget
{
    protected function getCards(): array
    {
        $usersCount = User::query()->count();
        $ordersCount = Order::query()->count();
        $approvedOrders = Order::query()->where('status', 1)->count();
        $pendingOrders = Order::query()->where('status', 0)->count();

        return [
            Stat::make('Tổng số người dùng', $usersCount)
                ->description('Tổng số tài khoản trong hệ thống')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),
            
            Stat::make('Tổng số đơn hàng', $ordersCount)
                ->description('Tất cả đơn hàng đã tạo')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('info'),
            
            Stat::make('Đơn hàng đã duyệt', $approvedOrders)
                ->description('Đơn hàng đã được phê duyệt')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            
            Stat::make('Đơn hàng chờ duyệt', $pendingOrders)
                ->description('Đơn hàng đang chờ xử lý')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
        ];
    }
}
