<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thông tin cơ bản')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên sản phẩm')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set): void {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug((string) $state));
                                }
                            })
                            ->columnSpan(2),
                        TextInput::make('slug')
                            ->label('Đường dẫn (slug)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),
                        Select::make('category_id')
                            ->label('Danh mục')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        Select::make('brand_id')
                            ->label('Thương hiệu')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->columnSpan(1),
                        TextInput::make('sku')
                            ->label('Mã SKU')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->placeholder('VD: PROD-001')
                            ->columnSpan(1),
                        Textarea::make('short_description')
                            ->label('Mô tả ngắn')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('Mô tả chi tiết')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'min-h-64']),
                    ])
                    ->columns(3),

                Section::make('Giá và tồn kho')
                    ->schema([
                        TextInput::make('price')
                            ->label('Giá bán')
                            ->required()
                            ->numeric()
                            ->prefix('VND')
                            ->default(0)
                            ->columnSpan(1),
                        TextInput::make('sale_price')
                            ->label('Giá khuyến mãi')
                            ->numeric()
                            ->prefix('VND')
                            ->nullable()
                            ->columnSpan(1),
                        TextInput::make('quantity')
                            ->label('Số lượng tồn kho')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Hình ảnh')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Hình ảnh đại diện')
                            ->image()
                            ->disk('public')
                            ->directory('products')
                            ->imageEditor()
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),

                Section::make('Trạng thái và tính năng')
                    ->schema([
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'active' => 'Kích hoạt',
                                'inactive' => 'Vô hiệu',
                                'out_of_stock' => 'Hết hàng',
                            ])
                            ->default('active')
                            ->required()
                            ->columnSpan(1),
                        Toggle::make('is_featured')
                            ->label('Sản phẩm nổi bật')
                            ->default(false)
                            ->columnSpan(1),
                        Toggle::make('is_new')
                            ->label('Sản phẩm mới')
                            ->default(false)
                            ->columnSpan(1),
                        Toggle::make('is_bestseller')
                            ->label('Bán chạy')
                            ->default(false)
                            ->columnSpan(1),
                    ])
                    ->columns(4),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->maxLength(255)
                            ->placeholder('VD: điện thoại, smartphone, apple')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Thông tin kỹ thuật')
                    ->schema([
                        Textarea::make('specifications')
                            ->label('Thông số kỹ thuật (JSON)')
                            ->rows(6)
                            ->helperText('Nhập dữ liệu JSON hoặc để trống')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
