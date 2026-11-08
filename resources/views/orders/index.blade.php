@extends('layouts.app')

@section('title', 'List Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">List Pesanan</h4>
        <small class="text-muted">Kelola pesanan pelanggan</small>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i>Tambah Pesanan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice</th>
                        <th>Order ID</th>
                        <th>Kasir</th>
                        <th>Metode</th>
                        <th class="text-end">Grand Total</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td>
                            <a href="{{ route('orders.show', $trx->transaction_id) }}"
                               class="text-decoration-none fw-semibold">
                                {{ $trx->invoice }}
                            </a>
                        </td>
                        <td><span class="text-muted">#{{ $trx->order_id }}</span></td>
                        <td>{{ $trx->user->username ?? '-' }}</td>
                        <td>
                            @if($trx->payment_method === 'QRIS')
                                <span class="badge bg-warning text-dark">
                                    </i>QRIS
                                </span>
                            @else
                                <span class="badge bg-success">
                                    </i>Cash
                                </span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold text-nowrap">
                            Rp {{ number_format($trx->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="text-nowrap text-muted" style="font-size:0.85rem;">
                            {{ \Carbon\Carbon::parse($trx->datetime)->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            @if($trx->order)
                                @if($trx->order->order_status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($trx->order->order_status === 'cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">{{ $trx->order->order_status }}</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Tidak ada transaksi pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    @endif --}}
</div>
@endsection

