<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width('60px'),
                TextColumn::make('order_code')
                    ->label('Mã đơn hàng')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('customer_name')
                    ->label('Khách hàng')
                    ->getStateUsing(function ($record) {
                        $customer = \App\Models\Customer::find($record->customer_id);
                        return $customer ? $customer->customer_name : 'N/A';
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product_name')
                    ->label('Sản phẩm')
                    ->getStateUsing(function ($record) {
                        $product = \App\Models\Product::find($record->product_id);
                        return $product ? $product->name : 'N/A';
                    })
                    ->searchable()
                    ->limit(30),
                TextColumn::make('quantity')
                    ->label('Số lượng')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_revenue')
                    ->label('Tổng tiền')
                    ->money('VND')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn ($state) => match($state) {
                        0 => 'Chưa xác nhận',
                        1 => 'Đã xác nhận',
                        2 => 'Đã hủy',
                        default => 'Không xác định',
                    })
                    ->colors([
                        'warning' => 0,
                        'success' => 1,
                        'danger' => 2,
                    ]),
                TextColumn::make('order_date')
                    ->label('Ngày đặt')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Không có Edit action cho Orders
            ])
            ->toolbarActions([
                // Không có Bulk actions cho Orders
            ]);
    }
}
