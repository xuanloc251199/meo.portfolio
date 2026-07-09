<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Select::make('type')
                    ->label('Loại dự án')
                    ->options(\App\Models\Project::TYPE_LABELS)
                    ->default('design')
                    ->required(),
                FileUpload::make('image')
                    ->label('Ảnh đại diện')
                    ->image()
                    ->disk('public')
                    ->directory('works')
                    ->required(),
                FileUpload::make('images')
                    ->label('Album ảnh (thiết kế / photo)')
                    ->helperText('Upload nhiều ảnh; bấm vào card trên trang chủ sẽ mở album này. Kéo thả để đổi thứ tự.')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('public')
                    ->directory('works/albums')
                    ->columnSpanFull(),
                TextInput::make('size')
                    ->helperText('Kích thước ảnh gốc cho lightbox, ví dụ 1400x1400')
                    ->required()
                    ->default('1400x1400'),
                Select::make('tags')
                    ->relationship('tags', 'name', fn ($query) => $query->orderBy('type')->orderBy('name'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => "[{$record->type_label}] {$record->name}")
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('link'),
                Toggle::make('opposite')
                    ->label('Opposite (đảo màu chữ trên nền card)')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
