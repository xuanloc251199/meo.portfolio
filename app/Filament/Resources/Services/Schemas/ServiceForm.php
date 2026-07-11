<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Tiêu đề (EN)')
                    ->required(),
                TextInput::make('title_vi')
                    ->label('Tiêu đề (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.'),
                Select::make('tags')
                    ->relationship('tags', 'name', fn ($query) => $query->orderBy('type')->orderBy('name'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => "[{$record->type_label}] {$record->name}")
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Mô tả (EN)')
                    ->columnSpanFull(),
                Textarea::make('description_vi')
                    ->label('Mô tả (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('services')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
