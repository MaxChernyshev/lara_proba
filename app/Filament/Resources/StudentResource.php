<?php

namespace App\Filament\Resources;

use App\Exports\StudentsExport;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Klass;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use PHPUnit\TextUI\Output\Default\UnexpectedOutputPrinter;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->unique()
                    ->autofocus()
                    ->placeholder('new Student'),

                TextInput::make('email')
                    ->required()
                    ->unique()
                    ->autofocus()
                    ->placeholder('enter email'),

                TextInput::make('phone_number')
                    ->required()
                    ->unique()
                    ->tel()
                    ->placeholder('enter phone number'),

                TextInput::make('address')
                    ->required()
                    ->autofocus()
                    ->placeholder('enter address'),

                Select::make('klass_id')
                    ->relationship('klass', 'name')
                    ->reactive(),


                Select::make('section_id')
                    ->label('select Section')
                    ->options(function (callable $get) {
                        $klassId = $get('klass_id');

                        if ($klassId) {
                            return Section::where('klass_id', $klassId)->pluck('name', 'id')->toArray();
                        }
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Student Name')
                    ->toggleable()
                    ->color('danger'),

                TextColumn::make('klass.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('section.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('address')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                DeleteBulkAction::make('delete')
                    ->icon('heroicon-o-adjustments')
                    ->label('delete selected'),

                BulkAction::make('export')
                    ->label('export selected to excel')
                    ->icon('heroicon-o-adjustments')
                    ->action(fn(Collection $records) => (new StudentsExport($records))->download(now() . 'students.xlsx'))
                    ->deselectRecordsAfterCompletion()
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
