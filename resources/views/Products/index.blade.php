<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Warung Bu Ica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .product-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .gradient-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        
        .category-btn {
            transition: all 0.2s ease;
        }
        
        .category-btn.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .search-box {
            transition: all 0.3s ease;
        }
        
        .search-box:focus-within {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }
        
        .cart-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .sticky-cart {
            position: sticky;
            bottom: 20px;
            z-index: 40;
        }
        
        .empty-state {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans pb-20">

    <!-- Header yang Ditingkatkan -->
    <header class="gradient-header text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="bg-white p-2 rounded-lg">
                            <i class="fas fa-store text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Warung Bu Ica</h1>
                            <p class="text-blue-100 text-xs">Belanja mudah, harga terjangkau</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('cart.index') }}" class="relative text-white hover:text-blue-200 transition-all duration-300 transform hover:scale-110">
                        <div class="bg-white/20 p-3 rounded-full cart-pulse">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        @if(session('cart'))
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center shadow-lg">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <div class="flex items-center gap-3 border-l pl-4 border-blue-400">
                        @guest
                            <a href="{{ route('kasir.login') }}" class="bg-white/20 hover:bg-white/30 py-2 px-4 rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                <i class="fas fa-sign-in-alt"></i> Login Kasir
                            </a>
                        @else
                            @if(Auth::user()->role === 'kasir')
                                <div class="flex items-center gap-3">
                                    <div class="bg-white/20 p-2 rounded-full">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                                        <p class="text-blue-200 text-xs">Kasir</p>
                                    </div>
                                </div>
                                
                                <form action="{{ route('kasir.logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-red-200 font-medium ml-2 p-2 rounded-full hover:bg-white/10 transition" onclick="return confirm('Yakin ingin keluar?')">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            @else
                                <a href="/admin" class="bg-white text-blue-600 hover:bg-blue-50 py-2 px-4 rounded-lg transition-all duration-200 flex items-center gap-2 font-medium">
                                    <i class="fas fa-cogs"></i> Panel Admin
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Notifikasi -->
    <div class="container mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm mb-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700 font-medium">Berhasil!</p>
                        <p class="text-green-600 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm mb-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-700 font-medium">Terjadi Kesalahan!</p>
                        <ul class="list-disc list-inside text-red-600 text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Konten Utama -->
    <main class="container mx-auto px-4 py-8">
        <!-- Header dengan Pencarian dan Filter -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Katalog Produk</h2>
                <p class="text-gray-500 mt-1">Temukan kebutuhan harian dengan mudah dan cepat</p>
            </div>
            
            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                <!-- Pencarian -->
                <div class="relative search-box">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari produk..." class="pl-10 pr-4 py-3 w-full md:w-64 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Filter Kategori (contoh) -->
                <div class="flex gap-2 overflow-x-auto pb-2">
                    <button class="category-btn active bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-medium whitespace-nowrap">Semua</button>
                    <button class="category-btn bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium whitespace-nowrap">Makanan</button>
                    <button class="category-btn bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium whitespace-nowrap">Minuman</button>
                    <button class="category-btn bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium whitespace-nowrap">Snack</button>
                </div>
            </div>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @forelse($products as $product)
                <div class="product-card bg-white rounded-xl overflow-hidden border border-gray-100 flex flex-col h-full">
                    <!-- Badge Stok -->
                    <div class="absolute top-3 left-3 z-10">
                        @if($product->stock > 10)
                            <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Tersedia</span>
                        @elseif($product->stock > 0)
                            <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">Terbatas</span>
                        @else
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">Habis</span>
                        @endif
                    </div>
                    
                    <!-- Gambar Produk -->
                    <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400 overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        @else
                            <div class="text-center p-4">
                                <i class="fas fa-image text-5xl mb-2 text-gray-300"></i>
                                <p class="text-gray-400 text-sm">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Produk -->
                    <div class="p-5 flex-col flex flex-grow">
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-green-600 font-bold text-xl mb-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 mb-4 bg-gray-50 p-2 rounded-lg">
                                <i class="fas fa-box mr-2"></i> 
                                <span class="text-gray-700 font-medium">{{ $product->stock }}</span>
                                <span class="ml-1">tersisa</span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-auto">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-4 rounded-lg hover:from-blue-700 hover:to-blue-800 active:bg-blue-900 transition duration-200 flex items-center justify-center gap-2 font-medium shadow-md hover:shadow-lg">
                                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-200 text-gray-500 py-3 px-4 rounded-lg cursor-not-allowed font-medium border border-gray-300 flex items-center justify-center">
                                    <i class="fas fa-ban mr-2"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- State Kosong -->
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center empty-state rounded-2xl">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-full p-8 mb-6">
                        <i class="fas fa-search text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum ada produk yang dijual</h3>
                    <p class="text-gray-500 max-w-md">Silakan login sebagai admin untuk menambahkan produk ke katalog.</p>
                    @guest
                        <a href="{{ route('kasir.login') }}" class="mt-6 bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200 font-medium inline-flex items-center gap-2">
                            <i class="fas fa-sign-in-alt"></i> Login sebagai Admin
                        </a>
                    @endguest
                </div>
            @endforelse
        </div>
        
        <!-- Pagination (contoh) -->
        @if($products->count() > 0)
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center gap-1">
                    <a href="#" class="px-4 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="px-4 py-2 text-blue-600 bg-blue-50 border border-blue-300 rounded-lg font-medium">1</a>
                    <a href="#" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">3</a>
                    <a href="#" class="px-4 py-2 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        @endif
    </main>

    <!-- Tombol Keranjang Sticky untuk Mobile -->
    @if(session('cart') && count(session('cart')) > 0)
        <div class="sticky-cart md:hidden">
            <div class="flex justify-center">
                <a href="{{ route('cart.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-full shadow-lg flex items-center gap-2 font-medium">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Lihat Keranjang ({{ count(session('cart')) }})</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <i class="fas fa-store text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Warung Bu Ica</h3>
                            <p class="text-gray-500 text-sm">Belanja kebutuhan sehari-hari</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center md:text-right">
                    <p class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} Warung Bu Ica. 
                        <span class="hidden md:inline">Dibuat dengan <i class="fas fa-heart text-red-500"></i> dan Laravel.</span>
                    </p>
                    <p class="text-gray-400 text-xs mt-1">
                        <i class="fas fa-map-marker-alt mr-1"></i> Jl. Contoh No. 123, Kota Contoh
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript untuk Interaktivitas -->
    <script>
        // Fungsi pencarian sederhana
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                const productName = product.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(searchTerm)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
        
        // Fungsi filter kategori
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Hapus kelas active dari semua tombol
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active', 'bg-blue-100', 'text-blue-700');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                
                // Tambahkan kelas active ke tombol yang diklik
                this.classList.remove('bg-gray-100', 'text-gray-700');
                this.classList.add('active', 'bg-blue-100', 'text-blue-700');
                
                // Di sini bisa ditambahkan logika untuk memfilter produk berdasarkan kategori
            });
        });
        
        // Animasi saat produk ditambahkan ke keranjang
        document.querySelectorAll('form[action*="cart.add"] button').forEach(button => {
            button.addEventListener('click', function() {
                // Animasi sederhana
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-check"></i> Ditambahkan!';
                }, 800);
            });
        });
    </script>
</body>
</html>