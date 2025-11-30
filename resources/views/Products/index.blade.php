<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Bu Ica - Belanja Praktis & Terjangkau</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fafafa;
        }
        
        .navbar {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }
        
        .product-card {
            background: white;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }
        
        .category-btn {
            background: white;
            border: 1px solid #e5e5e5;
            transition: all 0.2s ease;
        }
        
        .category-btn.active {
            background: #1f2937;
            color: white;
            border-color: #1f2937;
        }
        
        .search-box {
            background: white;
            border: 1px solid #e5e5e5;
            transition: all 0.3s ease;
        }
        
        .search-box:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .cart-indicator {
            background: #ef4444;
            animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        @keyframes ping {
            75%, 100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        
        .sticky-cart {
            background: white;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .footer {
            background: #1f2937;
        }
        
        .price {
            color: #059669;
        }
        
        .stock-low {
            color: #dc2626;
        }
        
        .stock-medium {
            color: #d97706;
        }
        
        .stock-high {
            color: #059669;
        }
        
        .btn-primary {
            background: #1f2937;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #374151;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #3b82f6;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .notification {
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border-left: 4px solid;
        }
        
        .notification.success {
            border-left-color: #10b981;
        }
        
        .notification.error {
            border-left-color: #ef4444;
        }
        
        .empty-state {
            background: white;
            border: 2px dashed #e5e5e5;
        }
        
        .pagination-btn {
            background: white;
            border: 1px solid #e5e5e5;
            transition: all 0.2s ease;
        }
        
        .pagination-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }
        
        .pagination-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        .hero {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #1f2937 0%, #6b7280 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header -->
    <header class="navbar sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Warung Bu Ica</h1>
                        <p class="text-xs text-gray-500">Belanja praktis & terjangkau</p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if(session('cart'))
                            <span class="cart-indicator absolute -top-1 -right-1 w-3 h-3 rounded-full"></span>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-medium">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    <!-- Auth -->
                    <div class="flex items-center space-x-3">
                        @guest
                            <a href="{{ route('kasir.login') }}" class="btn-primary px-4 py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login Kasir
                            </a>
                        @else
                            @if(Auth::user()->role === 'kasir')
                                <div class="flex items-center space-x-3 bg-gray-50 px-3 py-2 rounded-lg">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-gray-500">Kasir</p>
                                    </div>
                                    <form action="{{ route('kasir.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="/admin" class="btn-secondary px-4 py-2 rounded-lg text-sm font-medium">
                                    <i class="fas fa-cogs mr-2"></i>Panel Admin
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="notification success rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-900">Berhasil</p>
                        <p class="text-gray-600 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="notification error rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-900">Terjadi Kesalahan</p>
                        <ul class="text-gray-600 text-sm mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Hero Section -->
            <div class="hero rounded-2xl p-8 mb-8 text-white">
                <div class="max-w-2xl">
                    <h2 class="text-4xl font-bold mb-4">Selamat Datang di Warung Bu Ica</h2>
                    <p class="text-gray-300 text-lg mb-6">Temukan berbagai kebutuhan harian dengan kualitas terbaik dan harga terjangkau. Belanja jadi lebih mudah dan praktis.</p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center space-x-2 bg-white/10 px-4 py-2 rounded-lg">
                            <i class="fas fa-shipping-fast"></i>
                            <span class="text-sm">Gratis Ongkir</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-white/10 px-4 py-2 rounded-lg">
                            <i class="fas fa-award"></i>
                            <span class="text-sm">Kualitas Terjamin</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-white/10 px-4 py-2 rounded-lg">
                            <i class="fas fa-clock"></i>
                            <span class="text-sm">Buka 24/7</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:mb-0">
                    <h2 class="text-3xl font-bold gradient-text">Katalog Produk</h2>
                    <p class="text-gray-600 mt-2">Temukan produk yang Anda butuhkan</p>
                </div>
                
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Search -->
                    <div class="search-box rounded-lg">
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Cari produk..." class="w-full sm:w-64 pl-10 pr-4 py-3 bg-transparent focus:outline-none text-gray-700 placeholder-gray-500">
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="flex space-x-2 overflow-x-auto">
                        <button class="category-btn active px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">Semua</button>
                        <button class="category-btn px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">Makanan</button>
                        <button class="category-btn px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">Minuman</button>
                        <button class="category-btn px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">Snack</button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="product-card rounded-xl overflow-hidden">
                        <!-- Product Image -->
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-3 left-3">
                                @if($product->stock > 10)
                                    <span class="stock-high bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Tersedia</span>
                                @elseif($product->stock > 0)
                                    <span class="stock-medium bg-yellow-50 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Terbatas</span>
                                @else
                                    <span class="stock-low bg-red-50 text-red-700 px-2 py-1 rounded-full text-xs font-medium">Habis</span>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            <p class="price text-xl font-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-box"></i>
                                    <span>{{ $product->stock }} stok tersisa</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full py-3 rounded-lg font-medium flex items-center justify-center space-x-2">
                                        <i class="fas fa-cart-plus"></i>
                                        <span>Tambah ke Keranjang</span>
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full py-3 rounded-lg font-medium bg-gray-100 text-gray-400 border border-gray-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-ban"></i>
                                    <span>Stok Habis</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full empty-state rounded-2xl p-12 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada produk</h3>
                        <p class="text-gray-600 mb-6">Silakan login sebagai admin untuk menambahkan produk.</p>
                        @guest
                            <a href="{{ route('kasir.login') }}" class="btn-primary inline-flex items-center space-x-2 px-6 py-3 rounded-lg">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login Admin</span>
                            </a>
                        @endguest
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->count() > 0)
                <div class="flex justify-center mt-12">
                    <div class="flex space-x-2">
                        <button class="pagination-btn w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chevron-left text-sm"></i>
                        </button>
                        <button class="pagination-btn active w-10 h-10 rounded-lg flex items-center justify-center">1</button>
                        <button class="pagination-btn w-10 h-10 rounded-lg flex items-center justify-center">2</button>
                        <button class="pagination-btn w-10 h-10 rounded-lg flex items-center justify-center">3</button>
                        <button class="pagination-btn w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Sticky Cart for Mobile -->
    @if(session('cart') && count(session('cart')) > 0)
        <div class="sticky-cart fixed bottom-0 left-0 right-0 p-4 lg:hidden">
            <a href="{{ route('cart.index') }}" class="btn-secondary w-full py-4 rounded-xl font-semibold flex items-center justify-center space-x-3">
                <i class="fas fa-shopping-cart"></i>
                <span>Lihat Keranjang ({{ count(session('cart')) }})</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif

    <!-- Footer -->
    <footer class="footer text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-gray-900"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Warung Bu Ica</h3>
                            <p class="text-gray-400 text-sm">Belanja praktis & terjangkau</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Menyediakan berbagai kebutuhan harian dengan kualitas terbaik dan harga terjangkau sejak 2010.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-600 transition-colors">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Katalog Produk</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Promo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <div class="space-y-3 text-gray-400">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span>Jl. Contoh No. 123, Jakarta</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone w-5"></i>
                            <span>(021) 1234-5678</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope w-5"></i>
                            <span>info@warungbuica.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Warung Bu Ica. All rights reserved.
                </p>
                <p class="text-gray-400 text-sm flex items-center space-x-2">
                    <span>Dibuat dengan</span>
                    <i class="fas fa-heart text-red-400"></i>
                    <span>dan Laravel</span>
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Simple search functionality
        document.querySelector('input[type="text"]').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
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

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add to cart animation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                const originalText = button.innerHTML;
                
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
                button.disabled = true;
                
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-check"></i> Ditambahkan!';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 1500);
                }, 800);
            });
        });
    </script>
</body>
</html>