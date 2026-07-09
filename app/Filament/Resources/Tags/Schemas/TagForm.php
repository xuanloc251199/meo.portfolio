<?php

namespace App\Filament\Resources\Tags\Schemas;

use App\Models\Tag;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('type')
                    ->label('Loại')
                    ->options(Tag::TYPE_LABELS)
                    ->default(Tag::TYPE_CATEGORY)
                    ->required(),
            ]);
    }
}
