<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    
    protected static ?string $navigationLabel = 'Đơn hàng';
    
    protected static ?string $modelLabel = 'Đơn hàng';
    
    protected static ?string $pluralModelLabel = 'Đơn hàng';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            // Disable Create and Edit for Orders - chỉ cho phép xem danh sách
            // 'create' => CreateOrder::route('/create'),
            // 'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false; // Không cho phép tạo mới
    }
    
    public static function canEdit($record): bool
    {
        return false; // Không cho phép chỉnh sửa
    }
    
    public static function canDelete($record): bool
    {
        return false; // Không cho phép xóa
    }
}
