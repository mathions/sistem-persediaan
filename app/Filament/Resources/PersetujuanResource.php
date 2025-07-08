<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersetujuanResource\Pages;
use App\Models\Persetujuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class PersetujuanResource extends Resource
{
    protected static ?string $model = Persetujuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function getNavigationGroup(): ?string
    {
        return 'Persetujuan';
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
                                //Status
                                Select::make('status_id')
                                    ->label('Status')
                                    ->relationship('status', 'nama_status') // pastikan relasi ada di model
                                    ->required(),

                                // Catatan
                                TextInput::make('catatan')
                                    ->label('Catatan')
                                    ->placeholder('Masukkan catatan')
                                    ->required()
                                    ->maxLength(255),

                                // Nama Pemakaian
                                Placeholder::make('nama_pemakaian')
                                    ->label('Nama Pemakaian')
                                    ->content(fn ($record) => $record->pemakaian?->nama_pemakaian)
                            ]),

                            Forms\Components\Section::make('Detail Pemakaian')
                                ->schema([
                                 //Detail Pemakaian
                                Repeater::make('detail_pemakaian')
                                    ->relationship()
                                    ->schema([
                                        Select::make('barang_id')
                                            ->label('Nama Barang')
                                            ->relationship('barang', 'nama_barang') // pastikan relasi ada di model
                                            ->searchable()
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
                                    ]),
                            
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
                TextColumn::make('pemakaian.nama_pemakaian')
                    ->searchable()
                    ->label('Deskripsi'),
                TextColumn::make('status.nama_status')
                    ->label('Status'),
            ])
            ->filters([
                //
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersetujuans::route('/'),
            'create' => Pages\CreatePersetujuan::route('/create'),
            'edit' => Pages\EditPersetujuan::route('/{record}/edit'),
        ];
    }
}
