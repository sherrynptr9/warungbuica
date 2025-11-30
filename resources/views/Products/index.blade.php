<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Bu Ica - Belanja Mudah & Terjangkau</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #059669;
            --accent: #f59e0b;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        .gradient-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }
        
        .gradient-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .product-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            background: white;
            border-radius: 16px;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        
        .product-image {
            transition: transform 0.6s ease;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.1);
        }
        
        .category-btn {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .category-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        
        .search-box {
            transition: all 0.3s ease;
            background: white;
        }
        
        .search-box:focus-within {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }
        
        .cart-pulse {
            animation: pulse 2s infinite;
            position: relative;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }
        
        .sticky-cart {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
        
        .empty-state {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 2px dashed #e2e8f0;
        }
        
        .price-tag {
            background: linear-gradient(135deg, var(--secondary) 0%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stock-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 10;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .loading-spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.9) 0%, rgba(59, 130, 246, 0.8) 100%), url('https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            margin: 20px auto;
            padding: 60px 40px;
            color: white;
            text-align: center;
        }
        
        .floating-action {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .footer-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        
        .footer-wave {
            position: relative;
            overflow: hidden;
        }
        
        .footer-wave::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-position: center;
        }
        
        .notification-toast {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 1000;
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Header yang Ditingkatkan -->
    <header class="gradient-header text-white shadow-2xl sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 relative z-10">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-4 hover:opacity-90 transition-opacity">
                        <div class="bg-white p-3 rounded-2xl shadow-lg floating-action">
                            <i class="fas fa-store text-2xl" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">Warung Bu Ica</h1>
                            <p class="text-blue-100 text-sm font-medium">Belanja mudah, harga terjangkau</p>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('cart.index') }}" class="relative group">
                        <div class="bg-white/20 p-3 rounded-2xl cart-pulse transition-all duration-300 group-hover:bg-white/30 group-hover:scale-110">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        @if(session('cart'))
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center shadow-lg">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <div class="flex items-center gap-4 border-l pl-6 border-blue-400">
                        @guest
                            <a href="{{ route('kasir.login') }}" class="bg-white/20 hover:bg-white/30 py-3 px-5 rounded-xl transition-all duration-300 flex items-center gap-3 font-semibold hover:shadow-lg">
                                <i class="fas fa-sign-in-alt"></i> 
                                <span>Login Kasir</span>
                            </a>
                        @else
                            @if(Auth::user()->role === 'kasir')
                                <div class="flex items-center gap-4">
                                    <div class="bg-white/20 p-3 rounded-xl">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold">{{ Auth::user()->name }}</p>
                                        <p class="text-blue-200 text-sm">Kasir</p>
                                    </div>
                                </div>
                                
                                <form action="{{ route('kasir.logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-red-200 font-medium p-3 rounded-xl hover:bg-white/10 transition-all duration-300" onclick="return confirm('Yakin ingin keluar?')">
                                        <i class="fas fa-sign-out-alt text-lg"></i>
                                    </button>
                                </form>
                            @else
                                <a href="/admin" class="bg-white text-blue-600 hover:bg-blue-50 py-3 px-5 rounded-xl transition-all duration-300 flex items-center gap-3 font-semibold shadow-lg hover:shadow-xl">
                                    <i class="fas fa-cogs"></i> 
                                    <span>Panel Admin</span>
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="container mx-auto px-4 mt-6">
        <div class="hero-section">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di Warung Bu Ica</h2>
            <p class="text-xl text-blue-100 mb-6 max-w-2xl mx-auto">Temukan berbagai kebutuhan harian dengan kualitas terbaik dan harga terjangkau</p>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <i class="fas fa-shipping-fast text-2xl mb-2"></i>
                    <p class="font-semibold">Gratis Ongkir</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <i class="fas fa-award text-2xl mb-2"></i>
                    <p class="font-semibold">Kualitas Terjamin</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                    <i class="fas fa-clock text-2xl mb-2"></i>
                    <p class="font-semibold">Buka 24/7</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div class="container mx-auto px-4 mt-6">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-lg mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-green-800 font-bold text-lg">Berhasil!</p>
                        <p class="text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-lg mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-red-800 font-bold text-lg">Terjadi Kesalahan!</p>
                        <ul class="list-disc list-inside text-red-700 mt-2 space-y-1">
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
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-6">
            <div class="text-center lg:text-left">
                <h2 class="text-4xl font-bold text-gray-900 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Katalog Produk</h2>
                <p class="text-gray-600 mt-3 text-lg">Temukan kebutuhan harian dengan mudah dan cepat</p>
            </div>
            
            <div class="w-full lg:w-auto flex flex-col sm:flex-row gap-4">
                <!-- Pencarian -->
                <div class="relative search-box rounded-2xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari produk..." class="pl-12 pr-6 py-4 w-full lg:w-80 rounded-2xl border-0 focus:outline-none focus:ring-0 text-gray-700 placeholder-gray-400">
                </div>
                
                <!-- Filter Kategori -->
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                    <button class="category-btn active bg-white text-gray-700 px-5 py-3 rounded-xl font-semibold whitespace-nowrap shadow-sm">Semua Produk</button>
                    <button class="category-btn bg-white text-gray-700 px-5 py-3 rounded-xl font-semibold whitespace-nowrap shadow-sm">Makanan</button>
                    <button class="category-btn bg-white text-gray-700 px-5 py-3 rounded-xl font-semibold whitespace-nowrap shadow-sm">Minuman</button>
                    <button class="category-btn bg-white text-gray-700 px-5 py-3 rounded-xl font-semibold whitespace-nowrap shadow-sm">Snack</button>
                    <button class="category-btn bg-white text-gray-700 px-5 py-3 rounded-xl font-semibold whitespace-nowrap shadow-sm">Kebutuhan Rumah</button>
                </div>
            </div>
        </div>

        <!-- Grid Produk -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @forelse($products as $product)
                <div class="product-card group">
                    <!-- Badge Stok -->
                    <div class="stock-badge 
                        @if($product->stock > 10) bg-green-500 text-white
                        @elseif($product->stock > 0) bg-yellow-500 text-white
                        @else bg-red-500 text-white @endif">
                        @if($product->stock > 10) Tersedia
                        @elseif($product->stock > 0) Terbatas
                        @else Habis @endif
                    </div>
                    
                    <!-- Gambar Produk -->
                    <div class="h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover product-image">
                        @else
                            <div class="text-center p-4 text-gray-400">
                                <i class="fas fa-image text-6xl mb-3"></i>
                                <p class="text-sm">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Produk -->
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                            <p class="price-tag text-2xl font-extrabold mb-4">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 mb-4 bg-gray-50 p-3 rounded-xl">
                                <i class="fas fa-box mr-3 text-gray-400"></i> 
                                <span class="text-gray-700 font-semibold">{{ $product->stock }}</span>
                                <span class="ml-1">stok tersisa</span>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-auto">
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 font-semibold shadow-lg hover:shadow-xl active:scale-95">
                                        <i class="fas fa-cart-plus"></i> 
                                        <span>Tambah ke Keranjang</span>
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-100 text-gray-400 py-4 px-6 rounded-xl cursor-not-allowed font-semibold border-2 border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-ban mr-2"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- State Kosong -->
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-center empty-state rounded-3xl">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-full p-10 mb-8 shadow-inner">
                        <i class="fas fa-search text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-600 mb-4">Belum ada produk yang dijual</h3>
                    <p class="text-gray-500 text-lg max-w-md mb-8">Silakan login sebagai admin untuk menambahkan produk ke katalog.</p>
                    @guest
                        <a href="{{ route('kasir.login') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 px-8 rounded-xl transition-all duration-300 font-semibold inline-flex items-center gap-3 shadow-lg hover:shadow-xl">
                            <i class="fas fa-sign-in-alt"></i> 
                            <span>Login sebagai Admin</span>
                        </a>
                    @endguest
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($products->count() > 0)
            <div class="mt-16 flex justify-center">
                <nav class="flex items-center gap-2 bg-white p-2 rounded-2xl shadow-lg">
                    <a href="#" class="px-5 py-3 text-gray-500 bg-white rounded-xl hover:bg-gray-50 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="px-5 py-3 text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl font-semibold shadow-md">1</a>
                    <a href="#" class="px-5 py-3 text-gray-700 bg-white rounded-xl hover:bg-gray-50 transition-colors font-semibold">2</a>
                    <a href="#" class="px-5 py-3 text-gray-700 bg-white rounded-xl hover:bg-gray-50 transition-colors font-semibold">3</a>
                    <span class="px-2 text-gray-400">...</span>
                    <a href="#" class="px-5 py-3 text-gray-700 bg-white rounded-xl hover:bg-gray-50 transition-colors font-semibold">10</a>
                    <a href="#" class="px-5 py-3 text-gray-500 bg-white rounded-xl hover:bg-gray-50 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        @endif
    </main>

    <!-- Tombol Keranjang Sticky untuk Mobile -->
    @if(session('cart') && count(session('cart')) > 0)
        <div class="sticky-cart md:hidden">
            <a href="{{ route('cart.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 px-8 rounded-full shadow-2xl flex items-center gap-3 font-bold transition-all duration-300 hover:scale-105">
                <i class="fas fa-shopping-cart"></i>
                <span>Lihat Keranjang ({{ count(session('cart')) }})</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif

    <!-- Footer -->
    <footer class="footer-gradient text-white footer-wave mt-20">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-white/10 p-3 rounded-2xl">
                            <i class="fas fa-store text-2xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">Warung Bu Ica</h3>
                            <p class="text-blue-200 mt-1">Solusi belanja kebutuhan sehari-hari</p>
                        </div>
                    </div>
                    <p class="text-blue-200 mb-6 max-w-md">
                        Menyediakan berbagai kebutuhan harian dengan kualitas terbaik dan harga terjangkau sejak 2010.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-all duration-300">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Tentang Kami</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Katalog Produk</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Promo</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Kontak</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Hubungi Kami</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-blue-200">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Merdeka No. 123, Jakarta</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-200">
                            <i class="fas fa-phone"></i>
                            <span>(021) 1234-5678</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-200">
                            <i class="fas fa-envelope"></i>
                            <span>info@warungbuica.com</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-200">
                            <i class="fas fa-clock"></i>
                            <span>Buka Setiap Hari 06:00 - 22:00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-blue-800/50 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-blue-300 text-sm">
                    &copy; {{ date('Y') }} Warung Bu Ica. All rights reserved.
                </div>
                <div class="flex items-center gap-2 text-blue-300 text-sm">
                    <span>Dibuat dengan</span>
                    <i class="fas fa-heart text-red-400"></i>
                    <span>dan Laravel</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript untuk Interaktivitas -->
    <script>
        // Fungsi pencarian produk
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const products = document.querySelectorAll('.product-card');
            let visibleCount = 0;
            
            products.forEach(product => {
                const productName = product.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(searchTerm) || searchTerm === '') {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });
            
            // Tampilkan pesan jika tidak ada hasil
            const emptyState = document.querySelector('.empty-state');
            if (visibleCount === 0 && searchTerm !== '') {
                if (!emptyState) {
                    const grid = document.querySelector('.grid');
                    const noResults = document.createElement('div');
                    noResults.className = 'col-span-full flex flex-col items-center justify-center py-20 text-center empty-state rounded-3xl';
                    noResults.innerHTML = `
                        <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-full p-10 mb-8 shadow-inner">
                            <i class="fas fa-search text-6xl text-gray-400"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-600 mb-4">Produk tidak ditemukan</h3>
                        <p class="text-gray-500 text-lg max-w-md">Coba gunakan kata kunci lain atau lihat kategori yang tersedia.</p>
                    `;
                    grid.appendChild(noResults);
                }
            } else if (emptyState && searchTerm === '') {
                emptyState.remove();
            }
        });
        
        // Fungsi filter kategori
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Hapus kelas active dari semua tombol
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active', 'text-white');
                    btn.classList.add('bg-white', 'text-gray-700');
                });
                
                // Tambahkan kelas active ke tombol yang diklik
                this.classList.remove('bg-white', 'text-gray-700');
                this.classList.add('active', 'text-white');
                
                // Simulasi filter (dalam implementasi nyata, ini akan request ke server)
                const category = this.textContent.trim();
                showNotification(`Menampilkan kategori: ${category}`);
            });
        });
        
        // Animasi saat produk ditambahkan ke keranjang
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = this.querySelector('button');
                const originalText = button.innerHTML;
                
                // Animasi loading
                button.innerHTML = '<i class="fas fa-spinner loading-spinner"></i> Menambahkan...';
                button.disabled = true;
                
                // Simulasi request
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-check"></i> Ditambahkan!';
                    button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                    
                    // Tampilkan notifikasi
                    showNotification('Produk berhasil ditambahkan ke keranjang!');
                    
                    // Reset setelah 2 detik
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        button.style.background = '';
                    }, 2000);
                }, 1000);
            });
        });
        
        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `notification-toast p-4 rounded-xl shadow-2xl max-w-sm ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            toast.innerHTML = `
                <div class="flex items-center gap-3">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle text-xl"></i>
                    <div>
                        <p class="font-semibold">${type === 'success' ? 'Berhasil!' : 'Error!'}</p>
                        <p class="text-sm opacity-90">${message}</p>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Hapus notifikasi setelah 3 detik
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>