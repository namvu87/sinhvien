<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width('60px'),
                TextColumn::make('customer_name')
                    ->label('Tên khách hàng')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('customer_phone')
                    ->label('SĐT')
                    ->searchable()
                    ->icon('heroicon-o-phone'),
                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->copyable(),
                TextColumn::make('customer_address')
                    ->label('Địa chỉ')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->customer_address)
                    ->wrap(),
                BadgeColumn::make('payments')
                    ->label('Thanh toán')
                    ->formatStateUsing(fn ($state) => $state ? 'Đã thanh toán' : 'Chưa thanh toán')
                    ->colors([
                        'success' => 1,
                        'danger' => 0,
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 1,
                        'heroicon-o-x-circle' => 0,
                    ]),
                TextColumn::make('orders_count')
                    ->label('Số đơn hàng')
                    ->counts('orders')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('user_code')
                    ->label('Mã người dùng')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('payments')
                    ->label('Trạng thái thanh toán')
                    ->options([
                        0 => 'Chưa thanh toán',
                        1 => 'Đã thanh toán',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
