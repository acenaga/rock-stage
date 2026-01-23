<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_youtube')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('thumbnail_url')
                    ->url(),
                TextInput::make('duration')
                    ->numeric(),
                TextInput::make('band_name'),
                TextInput::make('region'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
            ]);
    }
}
