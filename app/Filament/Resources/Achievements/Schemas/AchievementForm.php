<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AchievementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->required(),
                TextInput::make('label')
                    ->label('Nhãn (EN)')
                    ->required(),
                TextInput::make('label_vi')
                    ->label('Nhãn (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
