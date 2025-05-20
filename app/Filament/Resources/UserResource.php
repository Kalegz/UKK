<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Teacher;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn ($record) => $record === null)
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state)),
                Forms\Components\Select::make('role')
                    ->options([
                        'student' => 'Student',
                        'teacher' => 'Teacher',
                        'admin' => 'Admin',
                    ])
                    ->required(),
                Forms\Components\Section::make('Teacher Details')
                    ->visible(fn ($get) => $get('teacher_fields_visible'))
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->required(),
                    ]),
                Forms\Components\FileUpload::make('profile_photo')
                    ->image()
                    ->directory('profile_photos')
                    ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('role')->badge(),
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->defaultImageUrl(asset('images/default-profile.png')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'teacher' => 'Teacher',
                        'admin' => 'Admin',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (Model $record) => $record->isAdmin()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        return static::mutateUserData($data);
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        return static::mutateUserData($data);
    }

    protected static function mutateUserData(array $data): array
    {
        if ($data['role'] === 'teacher') {
            $teacherData = [
                'subject' => $data['subject'],
            ];
            unset($data['subject']);
            $data['teacher_data'] = $teacherData;
        }

        return $data;
    }

    public static function afterCreate(Model $record, array $data): void
    {
        static::saveRelatedData($record, $data);
    }

    public static function afterSave(Model $record, array $data): void
    {
        static::saveRelatedData($record, $data);
    }

    protected static function saveRelatedData(Model $record, array $data): void
    {
        // Update kolom role di users
        $record->role = $data['role'];
        $record->save();

        // Assign role ke Spatie
        if ($record->hasRole($data['role']) === false) {
            $record->syncRoles([$data['role']]); // aman, otomatis hapus role sebelumnya
        }

        // Jika role = teacher, simpan data tambahan
        if (isset($data['teacher_data'])) {
            $teacher = $record->teacher ?? new Teacher(['user_id' => $record->id]);
            $teacher->fill($data['teacher_data'])->save();
        }
    }
}