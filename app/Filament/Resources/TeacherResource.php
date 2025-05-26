<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\Select;
use Forms\Components\Textarea;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TeacherResource\Pages;

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
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->maxLength(100),
                Forms\Components\TextInput::make('subject')
                    ->label('Subject')
                    ->maxLength(100),
                Forms\Components\Select::make('gender')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->maxLength(100),
                Forms\Components\TextInput::make('contact')
                    ->label('Contact')
                    ->maxLength(100),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('User Name')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('subject')->label('Subject'),
                Tables\Columns\TextColumn::make('gender')->label('Gender'),
                Tables\Columns\TextColumn::make('address')->label('Address'),
                Tables\Columns\TextColumn::make('contact')->label('Contact'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
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