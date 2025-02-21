<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\Action;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Event Details')
                    ->description('Provide event information')
                    ->schema([
                        TextInput::make('name')->required()->columnSpan(2),
                        Textarea::make('description')->columnSpan(2),
                    ])
                    ->columns(2),

                Section::make('Event Scheduling')
                    ->description('Set event dates and status')
                    ->schema([
                        DatePicker::make('start_date')->required(),
                        DatePicker::make('end_date'),
                        Select::make('status')
                            ->options([
                                'Pending' => 'Pending',
                                'Upcoming' => 'Upcoming',
                                'Completed' => 'Completed',
                                'Postponed' => 'Postponed',
                            ])
                            ->required(),
                        Toggle::make('is_active')->label('Active')->default(true),
                    ])
                    ->columns(2),

                Section::make('Additional Information')
                    ->description('Assign responsible person, term, and branch')
                    ->schema([
                        TextInput::make('in_charge')->label('Responsible Person')->required(),
                        Select::make('term')
                            ->label('Term')
                            ->options([
                                'Term 1' => 'Term 1',
                                'Term 2' => 'Term 2',
                                'Term 3' => 'Term 3',
                            ])
                            ->required(),
                        TextInput::make('event_week')
                            ->label('Event Week')
                            ->numeric()
                            ->step(1)
                            ->minValue(1)
                            ->maxValue(15)
                            ->required(),
                        Select::make('branch')
                            ->label('Branch')
                            ->options([
                                'South C' => 'South C',
                                'Kitisuru' => 'Kitisuru',
                                'Juja Rd' => 'Juja Rd',
                            ])
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Class Assignment')
                    ->description('Select the classes for this event')
                    ->schema([
                        Select::make('classes')
                            ->relationship('classes', 'name', fn ($query) => $query->orderBy('name'))
                            ->multiple()
                            ->preload(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('Generate PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn () => route('events.pdf'))
                    ->openUrlInNewTab(),
            ])
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('start_date')->sortable(),
                TextColumn::make('in_charge')->label('In-Charge'),
                TextColumn::make('event_week')->label('Week')->sortable(),

                TextColumn::make('term')
                    ->label('Term')
                    ->badge()
                    ->colors([
                        'primary' => 'Term 1',
                        'success' => 'Term 2',
                        'warning' => 'Term 3',
                    ]),

                TextColumn::make('branch')->label('Branch')->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'Pending',
                        'info' => 'Upcoming',
                        'success' => 'Completed',
                        'danger' => 'Postponed',
                    ])
                    ->icon(fn ($state) => match ($state) {
                        'Pending' => 'heroicon-o-clock',
                        'Upcoming' => 'heroicon-o-calendar',
                        'Completed' => 'heroicon-o-check-circle',
                        'Postponed' => 'heroicon-o-x-circle',
                        default => null
                    }),

                BooleanColumn::make('is_active')->label('Active'),

                BadgeColumn::make('classes.name')->label('Assigned Classes'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Upcoming' => 'Upcoming',
                        'Completed' => 'Completed',
                        'Postponed' => 'Postponed',
                    ])
                    ->placeholder('Filter by Status'),

                SelectFilter::make('branch')
                    ->options([
                        'South C' => 'South C',
                        'Kitisuru' => 'Kitisuru',
                        'Juja Rd' => 'Juja Rd',
                    ])
                    ->placeholder('Filter by Branch'),

                SelectFilter::make('term')
                    ->options([
                        'Term 1' => 'Term 1',
                        'Term 2' => 'Term 2',
                        'Term 3' => 'Term 3',
                    ])
                    ->placeholder('Filter by Term'),

                SelectFilter::make('classes.name')
                    ->relationship('classes', 'name')
                    ->multiple()
                    ->preload()
                    ->placeholder('Filter by Class'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->icon('heroicon-o-ellipsis-vertical'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'asc')
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
