<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsulanResource\Pages;
use App\Filament\Resources\UsulanResource\RelationManagers;
use App\Models\Usulan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class UsulanResource extends Resource
{
    protected static ?string $model = Usulan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengajuan';
    }

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                        ->schema([
                            // user_id disembunyikan, terisi otomatis dari user login
                            Hidden::make('user_id')
                                ->default(fn () => auth()->id()),
    
                            // Nama Usulan
                            TextInput::make('nama_usulan')
                                ->label('Deskripsi')
                                ->placeholder('Masukkan deskripsi usulan')
                                ->required()
                                ->maxLength(255),
    
                            // Status
                            Hidden::make('status_id')
                                ->default(1),
                        ]),

                        Forms\Components\Section::make('Daftar Barang')
                            ->headerActions([
                                Forms\Components\Actions\Action::make('reset')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Forms\Set $set) => $set('detail_pemakaian', [])),
                                ])
                            ->schema([
                                //Detail Usulan
                                Repeater::make('detail_usulan')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('nama_barang')
                                            ->label('Nama Barang')
                                            ->placeholder('Masukkan nama barang')
                                            ->columnSpan([
                                                'md' => 6,
                                            ])
                                            ->required(),
                                        TextInput::make('jumlah')
                                            ->numeric()
                                            ->columnSpan([
                                                'md' => 2,
                                            ])
                                            ->required()
                                            ->default(1),                              
                                        Select::make('satuan_id')
                                            ->label('Satuan')
                                            ->relationship('satuan', 'nama_satuan') // pastikan relasi ada di model
                                            ->columnSpan([
                                                'md' => 2,
                                            ])
                                            ->required(),
                                    ])
                                    ->columns([
                                        'md' => 10])
                                    ->hiddenLabel()
                                    ->addActionLabel('Tambahkan barang'),
                            ])
                    ])
            ])
            ->columns('full');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([                
                TextColumn::make('id')
                    ->label('No.'),
                TextColumn::make('user.name')
                    ->label('Nama'),
                TextColumn::make('nama_usulan')
                    ->searchable()
                    ->label('Deskripsi'),
                TextColumn::make('status.nama_status')
                    ->label('Status'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsulans::route('/'),
            'create' => Pages\CreateUsulan::route('/create'),
            'edit' => Pages\EditUsulan::route('/{record}/edit'),
        ];
    }
}
