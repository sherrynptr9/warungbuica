<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Keranjang Belanja</h4>
        </div>
        <div class="card-body">
            
            {{-- Menampilkan Pesan Error / Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Cek apakah keranjang ada isinya --}}
            @if(session('cart') && count(session('cart')) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th>Subtotal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach(session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $details['name'] }}</div>
                                    </td>
                                    <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                    
                                    {{-- BAGIAN TOMBOL TAMBAH KURANG --}}
                                    <td class="text-center" width="20%">
                                        <div class="input-group justify-content-center" style="width: 120px; margin: auto;">
                                            {{-- Tombol Kurang --}}
                                            <a href="{{ route('cart.decrease', $id) }}" class="btn btn-outline-secondary btn-sm">
                                                -
                                            </a>
                                            
                                            {{-- Angka Quantity --}}
                                            <input type="text" class="form-control form-control-sm text-center bg-white" value="{{ $details['quantity'] }}" readonly>
                                            
                                            {{-- Tombol Tambah --}}
                                            <a href="{{ route('cart.add', $id) }}" class="btn btn-outline-secondary btn-sm">
                                                +
                                            </a>
                                        </div>
                                    </td>

                                    <td class="fw-bold">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                    
                                    <td class="text-center">
                                        <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus {{ $details['name'] }}?')">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold fs-5">Total Bayar:</td>
                                <td colspan="2" class="fw-bold fs-5 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        &laquo; Lanjut Belanja
                    </a>
                    
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg">
                            Checkout Sekarang &raquo;
                        </button>
                    </form>
                </div>

            @else
                <div class="text-center py-5">
                    <h4>Keranjang Anda Kosong</h4>
                    <p class="text-muted">Belum ada barang yang ditambahkan.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Mulai Belanja</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>