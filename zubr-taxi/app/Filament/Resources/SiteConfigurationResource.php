<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteConfigurationResource\Pages;
use App\Filament\Resources\SiteConfigurationResource\RelationManagers;
use App\Models\SiteConfiguration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class SiteConfigurationResource extends Resource
{
    protected static ?string $model = SiteConfiguration::class;

    protected static ?string $navigationIcon = 'heroicon-m-cog-8-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $slug = 'site-configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('phone_number')
                    ->label('Phone number')
                    ->placeholder('+380')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->placeholder('test@example.com')
                    ->required(),
                TextInput::make('telegram_link')
                    ->label('Telegram link')
                    ->url()
                    ->placeholder('https://t.me/test')
                    ->required(),
                FileUpload::make('logo')
                    ->label('Logotype')
                    ->image()
                    ->directory('logos')
                    ->required(),
                FileUpload::make('favicon')
                    ->label('Icon')
                    ->image()
                    ->directory('favicon')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone_number'),
                TextColumn::make('telegram_link')->url(fn($record) => $record->telegram_link)->openUrlInNewTab(),
                TextColumn::make('email'),
                ImageColumn::make('logo')->label('Logotype'),
                ImageColumn::make('favicon')
            ])
            ->paginationPageOptions([0])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteConfigurations::route('/'),
            'create' => Pages\CreateSiteConfiguration::route('/create'),
            'edit' => Pages\EditSiteConfiguration::route('/{record}/edit'),
        ];
    }
}
