<?php

namespace App\Filament\Resources\Attributes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AttributesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width('60px'),
                TextColumn::make('name')
                    ->label('Tên thuộc tính')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('code')
                    ->label('Mã')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('type')
                    ->label('Kiểu dữ liệu')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'text' => 'Văn bản',
                        'number' => 'Số',
                        'boolean' => 'Đúng/Sai',
                        'select' => 'Chọn 1',
                        'multiselect' => 'Chọn nhiều',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'text',
                        'blue' => 'number',
                        'yellow' => 'boolean',
                        'green' => 'select',
                        'purple' => 'multiselect',
                    ]),
                TextColumn::make('unit')
                    ->label('Đơn vị')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Kích hoạt')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('display_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Kiểu dữ liệu')
                    ->options([
                        'text' => 'Văn bản',
                        'number' => 'Số',
                        'boolean' => 'Đúng/Sai',
                        'select' => 'Chọn 1',
                        'multiselect' => 'Chọn nhiều',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Kích hoạt'),
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
