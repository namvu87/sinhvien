<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên danh mục')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpan(1),
                Select::make('parent_id')
                    ->label('Danh mục cha')
                    ->options(function () {
                        $currentId = request()->route('record') ?? 0;
                        return \App\Models\Category::query()
                            ->where('id', '!=', $currentId)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Chọn danh mục cha (nếu có)')
                    ->getOptionLabelUsing(fn ($value): ?string => \App\Models\Category::find($value)?->name)
                    ->columnSpan(1),
                TextInput::make('display_order')
                    ->label('Thứ tự hiển thị')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->columnSpan(1),
                Textarea::make('description')
                    ->label('Mô tả')
                    ->rows(4)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Hình ảnh')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->columnSpan(1),
                TextInput::make('icon')
                    ->label('Icon')
                    ->maxLength(100)
                    ->placeholder('VD: fa fa-home')
                    ->columnSpan(1),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'active' => 'Kích hoạt',
                        'inactive' => 'Vô hiệu',
                    ])
                    ->default('active')
                    ->required()
                    ->columnSpan(1),
            ]);
    }
}
