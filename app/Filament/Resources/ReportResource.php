<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup= 'Admin Reports';

    protected static ?string $slug= 'organization-reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category')
                    ->required()
                    ->label('Category')
                    ->options([
                        'General Reports' => 'General Reports',
                        'Academic Reports' => 'Academic Reports',
                        'Admin Reports' => 'Admin Reports',
                    ])
                    ->placeholder('Select a Category'),

                TextInput::make('subject')
                    ->required()
                    ->label('Subject'),

                Textarea::make('summary')
                    ->required()
                    ->label('Summary'),

                MultiSelect::make('recipients')
                    ->relationship('recipients', 'name')
                    ->label('Recipients'),

                FileUpload::make('attachments')
                    ->multiple()
                    ->label('Attachments')
                    ->disk('public')
                    ->directory('attachments'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')
                    ->sortable()
                    ->searchable()
                    ->label('Category'),

                TextColumn::make('subject')
                    ->sortable()
                    ->searchable()
                    ->label('Subject'),

                TextColumn::make('user.name')
                    ->label('Sender')
                    ->sortable()
                    ->searchable(),

                TagsColumn::make('recipients.name')
                    ->label('Recipients'),

                TextColumn::make('created_at') // Add Created Date column
                    ->label('Created Date')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('M d, Y')), // Gmail-like format

                TextColumn::make('updated_at') // Add Updated Date column
                    ->label('Updated Date')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('M d, Y')), // Gmail-like format
            ])


            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Report Deleted.')
                            ->body('The Report is Deleted Successfully!')
                    )
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
 
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('category')->label('Report Category'),
                TextEntry::make('subject')->label('Report Subject'),
                TextEntry::make('summary')->label('Report Summary'),
                TextEntry::make('user.name')->label('Report Sender'),
                TextEntry::make('recipients.name')->label('Report Recipent')
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
