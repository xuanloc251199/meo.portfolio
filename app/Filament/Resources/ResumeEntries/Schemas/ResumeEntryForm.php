<?php

namespace App\Filament\Resources\ResumeEntries\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ResumeEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options([
                        'education' => 'Education',
                        'experience' => 'Experience',
                    ])
                    ->required(),
                TextInput::make('period')
                    ->label('Giai đoạn (EN)')
                    ->required(),
                TextInput::make('period_vi')
                    ->label('Giai đoạn (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.'),
                TextInput::make('title')
                    ->label('Tiêu đề (EN)')
                    ->required(),
                TextInput::make('title_vi')
                    ->label('Tiêu đề (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.'),
                TextInput::make('source_name'),
                TextInput::make('source_url')
                    ->url(),
                Textarea::make('description')
                    ->label('Mô tả (EN)')
                    ->columnSpanFull(),
                Textarea::make('description_vi')
                    ->label('Mô tả (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.')
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
