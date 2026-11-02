@extends('layouts.app')

@section('title', 'Detail Transaksi — ' . $transaction->invoice)

@section('content')
<div class="mb-3">
    <a href="{{ route('orders.create') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Kasir
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">

        <!-- Header Invoice -->
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center py-4">
                <div class="mb-2">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-success mb-1">Pesanan Berhasil Dibuat!</h4>
                <p class="text-muted mb-0">
                    Metode:
                    @if($transaction->payment_method === 'QRIS')
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-qr-code me-1"></i>QRIS
                        </span>
                        <br><small class="text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Konfirmasi pembayaran QRIS dilakukan secara manual oleh kasir.
                        </small>
                    @else
                        <span class="badge bg-success">
                            <i class="bi bi-cash me-1"></i>Cash
                        </span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Info Invoice -->
        <div class="card shadow-sm mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Invoice</h6>
                <span class="badge bg-dark fs-6">{{ $transaction->invoice }}</span>
            </div>
            <div class="card-body">
                <div class="row g-2 text-sm">
                    <div class="col-6">
                        <small class="text-muted d-block">Order ID</small>
                        <strong>#{{ $transaction->order->order_id }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Kasir</small>
                        <strong>{{ $transaction->user->username }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Tanggal & Waktu</small>
                        <strong>{{ \Carbon\Carbon::parse($transaction->datetime)->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-success">{{ ucfirst($transaction->order->order_status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Item -->
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul me-2"></i>Detail Item</h6>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th class="text-center" style="width:70px">Qty</th>
                            <th class="text-end" style="width:120px">Harga</th>
                            <th class="text-end" style="width:130px">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->order->orderItems as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td class="text-center">{{ $item->item_quantity }}</td>
                            <td class="text-end text-nowrap">
                                Rp {{ number_format($item->item_price, 0, ',', '.') }}
                            </td>
                            <td class="text-end text-nowrap fw-semibold">
                                Rp {{ number_format($item->sub_total, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold fs-5">Grand Total</td>
                            <td class="text-end fw-bold fs-5 text-primary text-nowrap">
                                Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Aksi -->
        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Pesanan Baru
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </div>

    </div>
</div>
@endsection

