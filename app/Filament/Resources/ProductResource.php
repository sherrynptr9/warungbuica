<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// --- IMPORT KOMPONEN (PENTING) ---
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // Saya ganti icon agar lebih cocok untuk "Barang/Gudang"
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $navigationLabel = 'Data Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Harga Satuan')
                    ->numeric() // Wajib angka
                    ->prefix('Rp') // Tampilkan Rp di depan
                    ->required(),

                TextInput::make('stock')
                    ->label('Stok Awal')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable() // Bisa dicari
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR') // Format otomatis ke Rupiah
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Sisa Stok')
                    ->numeric()
                    ->sortable()
                    // Fitur tambahan: Warnai merah jika stok kurang dari 5
                    ->color(fn (string $state): string => $state <= 5 ? 'danger' : 'success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Tambahkan tombol hapus
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc'); // Urutkan nama A-Z
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}