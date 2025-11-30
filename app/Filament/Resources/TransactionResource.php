<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\TransactionResource\Pages;
    use App\Filament\Resources\TransactionResource\RelationManagers;
    use App\Models\Transaction;
    use App\Models\Product; // <-- Import Model Product untuk ambil harga
    use Filament\Forms;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\SoftDeletingScope;

    // --- IMPORT KOMPONEN PENTING ---
    use Filament\Forms\Components\Select;
    use Filament\Forms\Components\Repeater;
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\Hidden;
    use Filament\Forms\Get;
    use Filament\Forms\Set;
    use Filament\Tables\Columns\TextColumn;

    class TransactionResource extends Resource
    {
        protected static ?string $model = Transaction::class;

        protected static ?string $navigationIcon = 'heroicon-o-shopping-cart'; // Icon Keranjang
        
        protected static ?string $navigationLabel = 'Kasir / Transaksi';

        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    // 1. DATA KASIR (Otomatis & Readonly)
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Kasir')
                        ->default(auth()->id())
                        ->required()
                        ->disabled() // User tidak bisa ubah ini
                        ->dehydrated(), // Tetap dikirim ke database meski disabled

                    // 2. STATUS PEMBAYARAN
                    Select::make('payment_status')
                        ->options([
                            'paid' => 'Lunas',
                            'pending' => 'Pending',
                        ])
                        ->required()
                        ->default('paid'),

                    // 3. KERANJANG BELANJA (Repeater)
                    // Ini akan menyimpan data ke tabel 'transaction_details'
                    Repeater::make('details')
                        ->relationship() // Relasi 'details' di model Transaction
                        ->schema([
                            // PILIH BARANG
                            Select::make('product_id')
                                ->label('Produk')
                                ->options(Product::query()->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->reactive() // Agar bisa trigger fungsi update harga
                                ->afterStateUpdated(function ($state, Set $set) {
                                    // Ambil harga barang dari database saat produk dipilih
                                    $product = Product::find($state);
                                    if ($product) {
                                        $set('price', $product->price);
                                    }
                                })
                                ->columnSpan(2),

                            // JUMLAH BELI
                            TextInput::make('quantity')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required()
                                ->reactive() // Agar bisa trigger hitung total
                                ->columnSpan(1),

                            // HARGA SATUAN (Otomatis terisi)
                            TextInput::make('price')
                                ->label('Harga @')
                                ->numeric()
                                ->prefix('Rp')
                                ->disabled() // Tidak boleh diedit manual
                                ->dehydrated() // Tetap simpan ke database
                                ->required()
                                ->columnSpan(1),
                        ])
                        ->columns(4)
                        // LOGIKA HITUNG TOTAL BAYAR (Live)
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updateTotal($get, $set);
                        }),

                    // 4. TOTAL BAYAR (Otomatis Dihitung)
                    TextInput::make('total_amount')
                        ->label('Total Transaksi')
                        ->prefix('Rp')
                        ->numeric()
                        ->default(0)
                        ->disabled() // Readonly
                        ->dehydrated() // Wajib simpan ke database
                        ->columnSpanFull()
                        ->extraInputAttributes(['style' => 'font-size: 1.5rem; font-weight: bold;']),
                ]);
        }

        // Fungsi Bantuan untuk Menghitung Total
        public static function updateTotal(Get $get, Set $set): void
        {
            $details = $get('details'); // Ambil semua data di repeater
            $total = 0;

            if (is_array($details)) {
                foreach ($details as $item) {
                    $qty = intval($item['quantity'] ?? 0);
                    $price = floatval($item['price'] ?? 0);
                    $total += $qty * $price;
                }
            }

            $set('total_amount', $total); // Update field total_amount
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    TextColumn::make('created_at')
    ->dateTime('d M Y, H:i') // Format tanggal biar lebih rapi
    ->timezone('Asia/Jakarta') // <-- Paksa konversi ke WIB
    ->label('Waktu')
    ->sortable(),
                    TextColumn::make('user.name')
                        ->label('Kasir')
                        ->sortable(),

                    TextColumn::make('total_amount')
                        ->money('IDR')
                        ->label('Total Bayar')
                        ->sortable(),

                    TextColumn::make('payment_status')
                        ->badge()
                        ->color(fn (string $state): string => match (strtolower($state)) {
    'paid' => 'success',
    'pending' => 'warning',
    default => 'gray', // fallback agar tidak error
})

                        ->label('Status'),
                ])
                ->filters([
                    //
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
                ->defaultSort('created_at', 'desc');
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
                'index' => Pages\ListTransactions::route('/'),
                'create' => Pages\CreateTransaction::route('/create'),
                'edit' => Pages\EditTransaction::route('/{record}/edit'),
            ];
        }
    }