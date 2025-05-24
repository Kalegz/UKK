<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Models\Teacher;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        $teacherRole = Role::where('name', 'teacher')->first();
                        return User::role($teacherRole)->pluck('name', 'id');
                    })
                    ->required()
                    ->searchable()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('subject')
                    ->label('Subject')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User Name')->searchable(),
                Tables\Columns\TextColumn::make('subject')->label('Subject')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->options(function () {
                        $teacherRole = Role::where('name', 'teacher')->first();
                        return User::role($teacherRole)->pluck('name', 'id');
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $teacherRole = Role::where('name', 'teacher')->first();
        return parent::getEloquentQuery()->whereHas('user', function (Builder $query) use ($teacherRole) {
            $query->role($teacherRole);
        });
    }
}