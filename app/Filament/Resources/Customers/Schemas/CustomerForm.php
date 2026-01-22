<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->label('Tên khách hàng')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Nhập tên khách hàng')
                    ->columnSpan(1),
                TextInput::make('user_code')
                    ->label('Mã người dùng')
                    ->maxLength(10)
                    ->placeholder('Nhập mã người dùng (tùy chọn)')
                    ->columnSpan(1),
                TextInput::make('customer_phone')
                    ->label('Số điện thoại')
                    ->required()
                    ->tel()
                    ->maxLength(50)
                    ->placeholder('VD: 0901234567')
                    ->columnSpan(1),
                TextInput::make('customer_email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(150)
                    ->placeholder('VD: customer@example.com')
                    ->unique(ignoreRecord: true)
                    ->columnSpan(1),
                Textarea::make('customer_address')
                    ->label('Địa chỉ')
                    ->required()
                    ->rows(3)
                    ->placeholder('Nhập địa chỉ đầy đủ')
                    ->columnSpanFull(),
                Select::make('payments')
                    ->label('Trạng thái thanh toán')
                    ->options([
                        0 => 'Chưa thanh toán',
                        1 => 'Đã thanh toán',
                    ])
                    ->default(0)
                    ->required()
                    ->columnSpan(1),
                Textarea::make('customer_note')
                    ->label('Ghi chú')
                    ->rows(3)
                    ->placeholder('Ghi chú về khách hàng (tùy chọn)')
                    ->columnSpanFull(),
            ]);
    }
}
