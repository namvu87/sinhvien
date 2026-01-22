<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên thương hiệu')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                        if ($operation === 'create') {
                            $set('slug', Str::slug((string) $state));
                        }
                    }),
                TextInput::make('slug')
                    ->label('Đường dẫn (slug)')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique(table: 'brands', column: 'slug', ignoreRecord: true),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('brands')
                    ->imageEditor()
                    ->visibility('public')
                    ->columnSpan(1),
                RichEditor::make('description')
                    ->label('Mô tả')
                    ->default(null)
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'min-h-64']),
                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->default(null)
                    ->columnSpan(1),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options(['active' => 'Đang hoạt động', 'inactive' => 'Ngưng hoạt động'])
                    ->default('active')
                    ->required()
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
