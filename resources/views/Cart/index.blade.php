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

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('cart') && count(session('cart')) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th>Subtotal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php $total = 0; @endphp

                        @foreach(session('cart') as $id => $details)
                            @php
                                $subtotal = $details['price'] * $details['quantity'];
                                $total += $subtotal;
                                $product = \App\Models\Product::find($id);
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $details['name'] }}</strong><br>
                                    <small class="text-muted">Sisa stok: {{ $product->stock }}</small>
                                </td>
                                <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td class="text-center" width="20%">
                                    <div class="input-group justify-content-center" style="width: 120px;">
                                        <a href="{{ route('cart.decrease', $id) }}" class="btn btn-outline-secondary btn-sm">-</a>
                                        <input type="text" class="form-control form-control-sm text-center" value="{{ $details['quantity'] }}" readonly>
                                        <form action="{{ route('cart.add', $id) }}" method="GET">
                                            <button class="btn btn-outline-secondary btn-sm">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Hapus {{ $details['name'] }}?')">Hapus</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                            <td colspan="2" class="fw-bold fs-5 text-primary">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ url('/') }}" class="btn btn-secondary">&laquo; Lanjut Belanja</a>
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-lg">Checkout &raquo;</button>
                    </form>
                </div>

            @else
                <div class="text-center py-5">
                    <h4>Keranjang Kosong</h4>
                    <p class="text-muted">Belum ada produk di keranjang.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Mulai Belanja</a>
                </div>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    