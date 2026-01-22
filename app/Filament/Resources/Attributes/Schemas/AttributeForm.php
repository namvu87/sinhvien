<?php

namespace App\Filament\Resources\Attributes\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class AttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên thuộc tính')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                TextInput::make('code')
                    ->label('Mã (code)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Mã duy nhất để nhận diện thuộc tính')
                    ->columnSpan(1),
                Select::make('type')
                    ->label('Kiểu dữ liệu')
                    ->options([
                        'text' => 'Văn bản',
                        'number' => 'Số',
                        'boolean' => 'Đúng/Sai',
                        'select' => 'Chọn 1',
                        'multiselect' => 'Chọn nhiều',
                    ])
                    ->default('text')
                    ->required()
                    ->live()
                    ->columnSpan(1),
                TextInput::make('unit')
                    ->label('Đơn vị (ví dụ: W, L, kg)')
                    ->maxLength(50)
                    ->placeholder('VD: W, L, kg, m²')
                    ->columnSpan(1),
                KeyValue::make('options')
                    ->label('Tùy chọn (cho Select/Multiselect)')
                    ->keyLabel('Giá trị')
                    ->valueLabel('Nhãn hiển thị')
                    ->visible(fn (Set $get) => in_array($get('type'), ['select', 'multiselect']))
                    ->columnSpanFull()
                    ->helperText('Thêm các tùy chọn. Ví dụ: key="red" => value="Màu đỏ"'),
                Textarea::make('options_text')
                    ->label('Tùy chọn (JSON) - Dùng nếu KeyValue không đủ')
                    ->rows(4)
                    ->visible(fn (Set $get) => in_array($get('type'), ['select', 'multiselect']))
                    ->helperText('Nhập JSON: {"value1": "Label 1", "value2": "Label 2"}')
                    ->columnSpanFull()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record && $record->options) {
                            $component->state(json_encode($record->options, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        }
                    })
                    ->afterStateUpdated(function ($state, $record, Set $set) {
                        if ($state) {
                            try {
                                $decoded = json_decode($state, true);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    $set('options', $decoded);
                                }
                            } catch (\Exception $e) {
                                // Ignore invalid JSON
                            }
                        }
                    }),
                Toggle::make('is_active')
                    ->label('Kích hoạt')
                    ->default(true)
                    ->columnSpan(1),
                TextInput::make('display_order')
                    ->label('Thứ tự hiển thị')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->columnSpan(1),
            ]);
    }
}
