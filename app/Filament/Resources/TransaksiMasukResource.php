<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiMasukResource\Pages;
use App\Filament\Resources\TransaksiMasukResource\RelationManagers;
use App\Models\TransaksiMasuk;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class TransaksiMasukResource extends Resource
{
    protected static ?string $model = TransaksiMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right';

    public static function getNavigationGroup(): ?string
    {
        return 'Transaksi';
    }

    protected static ?int $navigationSort = 1;

    protected function afterSave(): void
    {
        $transaksi = $this->record;

        $barang = Barang::find($transaksi->barang_id);

        if ($barang) {
            $barang->increment('stok', $transaksi->jumlah);

            Notification::make()
                ->title('Test')
                ->body('afterCreate dijalankan')
                ->success()
                ->send();
        }      
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        // Barang
                        Select::make('barang_id')
                            ->label('Barang')
                            ->relationship('barang', 'nama_barang') // pastikan relasi ada di model
                            ->searchable()
                            ->required(),

                        // Satuan
                        Select::make('satuan_id')
                            ->label('Satuan')
                            ->relationship('satuan', 'nama_satuan') // pastikan relasi ada di model
                            ->required(),

                        // Jumlah
                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->placeholder('Masukkan jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required(),

                        // user_id disembunyikan, terisi otomatis dari user login
                        Hidden::make('user_id')
                            ->default(fn () => auth()->id()),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang.nama_barang')->searchable(),
                TextColumn::make('satuan.nama_satuan'),
                TextColumn::make('jumlah'),
                TextColumn::make('user.name'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksiMasuks::route('/'),
            'create' => Pages\CreateTransaksiMasuk::route('/create'),
            'edit' => Pages\EditTransaksiMasuk::route('/{record}/edit'),
        ];
    }


}
