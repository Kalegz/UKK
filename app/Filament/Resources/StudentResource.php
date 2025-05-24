<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        $studentRole = Role::where('name', 'student')->first();
                        return User::role($studentRole)->pluck('name', 'id');
                    })
                    ->required()
                    ->searchable()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('class')
                    ->label('Class')
                    ->required(),
                Forms\Components\TextInput::make('major')
                    ->label('Major')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User Name')->searchable(),
                Tables\Columns\TextColumn::make('nis')->label('NIS')->searchable(),
                Tables\Columns\TextColumn::make('class')->label('Class')->searchable(),
                Tables\Columns\TextColumn::make('major')->label('Major')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->options(function () {
                        $studentRole = Role::where('name', 'student')->first();
                        return User::role($studentRole)->pluck('name', 'id');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $studentRole = Role::where('name', 'student')->first();
        return parent::getEloquentQuery()->whereHas('user', function (Builder $query) use ($studentRole) {
            $query->role($studentRole);
        });
    }
}