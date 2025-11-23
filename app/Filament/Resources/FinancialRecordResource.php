<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialRecordResource\Pages;
use App\Filament\Resources\FinancialRecordResource\RelationManagers;
use App\Models\FinancialRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// --- IMPORT KOMPONEN (PENTING) ---
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;

class FinancialRecordResource extends Resource
{
    protected static ?string $model = FinancialRecord::class;

    // Ganti icon agar sesuai konteks keuangan
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationLabel = 'Laporan Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                Select::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required()
                    ->native(false),

                TextInput::make('amount')
                    ->label('Nominal')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Textarea::make('description')
                    ->label('Keterangan')
                    ->columnSpanFull(),

                // Field User ID kita sembunyikan (Hidden) 
                // dan otomatis diisi dengan ID user yang sedang login
                Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label('Tanggal'),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'income' => 'success', // Hijau
                        'expense' => 'danger', // Merah
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    }),

                TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Nominal'),

                TextColumn::make('description')
                    ->limit(30)
                    ->label('Keterangan'),

                TextColumn::make('user.name')
                    ->label('Dicatat Oleh')
                    ->sortable(),
            ])
            ->filters([
                // Anda bisa menambahkan filter berdasarkan tipe (Pemasukan/Pengeluaran) disini nanti
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc'); // Urutkan dari tanggal terbaru
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFinancialRecords::route('/'),
        ];
    }
}