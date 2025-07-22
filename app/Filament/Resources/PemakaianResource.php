<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemakaianResource\Pages;
use App\Filament\Resources\PemakaianResource\RelationManagers;
use App\Models\Pemakaian;
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
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemakaianResource extends Resource
{
    protected static ?string $model = Pemakaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengajuan';
    }

    protected static ?int $navigationSort = 2;

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
        
                                // Nama Pemakaian
                                TextInput::make('nama_pemakaian')
                                    ->label('Deskripsi')
                                    ->placeholder('Masukkan deskripsi pemakaian')
                                    ->required()
                                    ->maxLength(255),
        
                                // Status
                                Hidden::make('status_id')
                                    ->default(1),
                            ]),

                        Forms\Components\Section::make('Daftar Barang Persediaan')
                            ->headerActions([
                                Forms\Components\Actions\Action::make('reset')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Forms\Set $set) => $set('detail_pemakaian', [])),
                                    ])
                            ->schema([
                                //Detail Pemakaian
                                Repeater::make('detail_pemakaian')
                                    ->relationship()
                                    ->schema([
                                        Select::make('referensi_id')
                                            ->label('Referensi')
                                            ->options(function () {
                                                return \App\Models\Referensi::all()
                                                    ->mapWithKeys(function ($ref) {
                                                        $label = $ref->nama_barang . ' (' . $ref->satuan->nama_satuan . ')';
                                                        return [$ref->id => $label];
                                                    });
                                            })
                                            ->searchable()
                                            ->required()
                                            ->columnSpan([
                                                    'md' => 2,
                                                ]),
                                        TextInput::make('volume')
                                            ->numeric()
                                            ->columnSpan([
                                                'md' => 1,
                                            ])
                                            ->required()
                                            ->default(1),
                                    ])
                                    ->columns([
                                        'md' => 3])
                                    ->hiddenLabel()
                                    ->addActionLabel('Tambahkan barang'),
                                    ]),
                    ])
                    ->visible(fn () => auth()->user()?->role == 'pegawai'),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                // User
                                Placeholder::make('user')
                                    ->label('Nama')
                                    ->content(fn ($record) => $record->user?->name)
                                    ->columnSpan([
                                        'md' => 3,
                                    ]),
        
                                // Nama Pemakaian
                                Placeholder::make('nama_pemakaian')
                                    ->label('Deskripsi')
                                    ->content(fn ($record) =>$record->nama_pemakaian)
                                    ->columnSpan([
                                        'md' => 4,
                                    ]),
        
                                // Status
                                Placeholder::make('status')
                                    ->label('Status')
                                    ->content(fn ($record) => match (strtolower($record->status?->nama_status)) {
                                        'diajukan' => '✨ Diajukan',
                                        'direkap' => '📄 Direkap',
                                        'disetujui' => '✅ Disetujui',
                                        'ditolak' => '❌ Ditolak',
                                        default => 'Tidak diketahui',
                                    }),
                            ])
                                ->columns([
                                    'md' => 10]),

                        Forms\Components\Section::make('Daftar Barang Persediaan')
                            ->schema([
                                //Detail Pemakaian
                                Repeater::make('detail_pemakaian')
                                    ->relationship()
                                    ->schema([
                                        Select::make('referensi_id')
                                            ->label('Referensi')
                                            ->options(function () {
                                                return \App\Models\Referensi::all()
                                                    ->mapWithKeys(function ($ref) {
                                                        $label = $ref->nama_barang . ' (' . $ref->satuan->nama_satuan . ')';
                                                        return [$ref->id => $label];
                                                    });
                                            })
                                            ->disabled()
                                            ->required()
                                            ->columnSpan([
                                                    'md' => 2,
                                                ]),
                                        TextInput::make('volume')
                                            ->numeric()
                                            ->columnSpan([
                                                'md' => 1,
                                            ])
                                            ->disabled()
                                            ->default(1),                              
                                    ])
                                    ->columns([
                                        'md' => 3])
                                    ->hiddenLabel()
                                    ->addable(false)
                                    ->deletable(false),
                                    ]),

                    ])
                    ->visible(fn () => auth()->user()?->role !== 'pegawai'),
            ])
            ->columns('full');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->getStateUsing(fn ($record, $livewire) => $livewire->getTableRecords()->search(fn ($item) => $item->id === $record->id) + 1),
                TextColumn::make('user.name')
                    ->label('Nama'),
                TextColumn::make('nama_pemakaian')
                    ->searchable()
                    ->label('Deskripsi'),
                TextColumn::make('status.nama_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match (strtolower($state)) {
                        'diajukan' => 'info',
                        'direkap' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'secondary',
                    })
                    ->icon(fn ($state) => match (strtolower($state)) {
                        'diajukan' => 'heroicon-m-sparkles',
                        'direkap' => 'heroicon-m-document-text',
                        'disetujui' => 'heroicon-m-check-circle',
                        'ditolak' => 'heroicon-m-x-circle',
                        default => null,
                    }),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPemakaians::route('/'),
            'create' => Pages\CreatePemakaian::route('/create'),
            'view' => Pages\ViewPemakaian::route('/{record}'),
            'edit' => Pages\EditPemakaian::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest(); // artinya urut dari yang terbaru
    }
}
