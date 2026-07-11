<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                Textarea::make('value')
                    ->label('Giá trị (EN)')
                    ->columnSpanFull(),
                Textarea::make('value_vi')
                    ->label('Giá trị (VI)')
                    ->helperText('Bỏ trống sẽ dùng bản tiếng Anh.')
                    ->columnSpanFull(),
                TextInput::make('label'),
            ]);
    }
}
