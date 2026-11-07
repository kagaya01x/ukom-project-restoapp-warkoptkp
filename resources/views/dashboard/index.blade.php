@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Dashboard</h4>
        <small class="text-muted">
            Selamat datang, <strong>{{ Auth::user()->username }}</strong>
            @if(request('start_date') || request('end_date'))
                — Filter:
                <strong>{{ request('start_date', $startDate) }}</strong>
                s.d.
                <strong>{{ request('end_date', $endDate) }}</strong>
            @else
                — Hari ini, <strong>{{ \Carbon\Carbon::now()->format('d F Y') }}</strong>
            @endif
        </small>
    </div>
</div>

{{-- Filter Tanggal --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label fw-semibold mb-1" style="font-size:0.85rem;">Dari Tanggal</label>
                <input type="date" name="start_date"
                       class="form-control form-control-sm @error('start_date') is-invalid @enderror"
                       value="{{ request('start_date', $startDate) }}">
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto">
                <label class="form-label fw-semibold mb-1" style="font-size:0.85rem;">Sampai Tanggal</label>
                <input type="date" name="end_date"
                       class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                       value="{{ request('end_date', $endDate) }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-funnel me-1"></i>Terapkan
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Kartu Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card shadow-sm h-100 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size:0.7rem;">
                            Total Pendapatan
                        </small>
                        <h4 class="fw-bold text-success mb-0">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h4>
                    </div>
                    <i class="bi bi-currency-dollar text-success" style="font-size:2rem;opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card shadow-sm h-100 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size:0.7rem;">
                            Total Transaksi
                        </small>
                        <h4 class="fw-bold text-primary mb-0">{{ number_format($totalTransactions) }}</h4>
                    </div>
                    <i class="bi bi-receipt text-primary" style="font-size:2rem;opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card shadow-sm h-100 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size:0.7rem;">
                            Jumlah Pesanan
                        </small>
                        <h4 class="fw-bold text-warning mb-0">{{ number_format($totalOrders) }}</h4>
                    </div>
                    <i class="bi bi-bag-check text-warning" style="font-size:2rem;opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Rekapitulasi Transaksi --}}
<div class="card shadow-sm table-wrapper" id="rekapitulasi" >
    <div class="card-header">
        <h6 class="mb-0 fw-bold"><i class="bi bi-table me-2"></i>Rekapitulasi Transaksi</h6>
    </div>
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
                                    <i class="bi bi-qr-code me-1"></i>QRIS
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="bi bi-cash me-1"></i>Cash
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
    @if($transactions->hasPages())
    <div class="card-footer">
        {{ $transactions->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

