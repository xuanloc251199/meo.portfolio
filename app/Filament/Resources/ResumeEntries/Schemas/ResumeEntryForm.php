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
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('source_name'),
                TextInput::make('source_url')
                    ->url(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
