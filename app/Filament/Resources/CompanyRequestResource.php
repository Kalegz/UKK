<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyRequestResource\Pages;
use App\Models\Company;
use App\Models\CompanyRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyRequestResource extends Resource
{
    protected static ?string $model = CompanyRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->maxLength(65535),
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'nis')
                    ->required(),
                Forms\Components\Toggle::make('is_approved')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('address')->limit(50),
                Tables\Columns\TextColumn::make('student.user.name')->label('Student'),
                Tables\Columns\BooleanColumn::make('is_approved'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (CompanyRequest $record) {
                        Company::create([
                            'name' => $record->name,
                            'address' => $record->address,
                            'is_approved' => true,
                        ]);
                        $record->update(['is_approved' => true]);
                    })
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->hidden(fn (CompanyRequest $record) => $record->is_approved),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCompanyRequests::route('/'),
            'create' => Pages\CreateCompanyRequest::route('/create'),
            'edit' => Pages\EditCompanyRequest::route('/{record}/edit'),
        ];
    }
}