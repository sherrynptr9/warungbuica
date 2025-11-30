<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialRecordResource\Pages;
use App\Models\FinancialRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class FinancialRecordResource extends Resource
{
    protected static ?string $model = FinancialRecord::class;

    // Ganti Icon Duit/Keuangan
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Laporan Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. TANGGAL
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                // 2. TIPE (Pemasukan / Pengeluaran)
                Select::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required()
                    ->native(false),

                // 3. NOMINAL
                TextInput::make('amount')
                    ->label('Nominal')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                // 4. USER (Otomatis pengisi)
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Dicatat Oleh')
                    ->default(auth()->id())
                    ->required(),

                // 5. KETERANGAN
                Textarea::make('description')
                    ->label('Keterangan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom Tanggal
                TextColumn::make('date')
                    ->date('d M Y')
                    ->label('Tanggal')
                    ->sortable(),

                // Kolom Tipe (Badge Warna)
                TextColumn::make('type')
                    ->badge()
                    ->label('Jenis')
                    ->color(fn (string $state): string => match ($state) {
                        'income' => 'success', // Hijau
                        'expense' => 'danger', // Merah
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    }),

                // Kolom Nominal
                TextColumn::make('amount')
                    ->money('IDR')
                    ->label('Nominal')
                    ->sortable(),

                // Kolom Keterangan
                TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(30)
                    ->searchable(),

                // Kolom User
                TextColumn::make('user.name')
                    ->label('Oleh'),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                // Filter berdasarkan jenis (Income/Expense)
                SelectFilter::make('type')
                    ->label('Jenis')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFinancialRecords::route('/'),
        ];
    }
}