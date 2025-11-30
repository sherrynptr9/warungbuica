<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Warung Bu Ica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans pb-20">

    <header class="bg-white shadow sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800 hover:text-gray-600 transition">
                Warung Bu Ica
            </a>

            <div class="flex items-center gap-6">
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    @if(session('cart'))
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <div class="flex items-center gap-3 border-l pl-4 border-gray-300">
                    @guest
                        <a href="{{ route('kasir.login') }}" class="text-sm font-semibold text-gray-600 hover:text-blue-600 flex items-center gap-1">
                            <i class="fas fa-sign-in-alt"></i> Login Kasir
                        </a>
                    @else
                        @if(Auth::user()->role === 'kasir')
                            <a href="#" class="text-sm font-semibold text-green-600 hover:text-green-800 cursor-default">
                                <i class="fas fa-user-check"></i> {{ Auth::user()->name }} (Kasir)
                            </a>
                            
                            <form action="{{ route('kasir.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium ml-2" onclick="return confirm('Yakin ingin keluar?')">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        @else
                            <a href="/admin" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                <i class="fas fa-cogs"></i> Panel Admin
                            </a>
                        @endif
                    @endguest
                </div>

            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                <strong class="font-bold"><i class="fas fa-check-circle"></i> Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-sm">
                <strong class="font-bold">Error!</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Pilih Barang</h2>
                <p class="text-gray-500 mt-1">Belanja kebutuhan harian jadi lebih mudah</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col h-full">
                    <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400 overflow-hidden relative group">
                        @if($product->image)
                             <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        @else
                             <i class="fas fa-image text-4xl"></i>
                        @endif
                    </div>

                    <div class="p-5 flex-col flex flex-grow">
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight">{{ $product->name }}</h3>
                            <p class="text-green-600 font-bold text-xl mb-2">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 mb-4 bg-gray-50 p-2 rounded">
                                <i class="fas fa-box mr-2"></i> Stok tersedia: <strong class="ml-1 text-gray-700">{{ $product->stock }}</strong>
                            </div>
                        </div>

                        <div class="mt-auto">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-lg hover:bg-blue-700 active:bg-blue-800 transition duration-200 flex items-center justify-center gap-2 font-medium shadow-sm hover:shadow">
                                        <i class="fas fa-cart-plus"></i> Tambah
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-200 text-gray-500 py-2.5 px-4 rounded-lg cursor-not-allowed font-medium border border-gray-300">
                                    <i class="fas fa-ban mr-2"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="bg-gray-200 rounded-full p-6 mb-4">
                        <i class="fas fa-search text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600">Belum ada barang yang dijual.</h3>
                    <p class="text-gray-500">Silakan login sebagai admin untuk menambahkan produk.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-white border-t mt-12 py-8">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Warung Bu Ica. Dibuat dengan <i class="fas fa-heart text-red-500"></i> dan Laravel.
        </div>
    </footer>

</body>
</html>