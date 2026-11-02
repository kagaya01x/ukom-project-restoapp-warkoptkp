@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Dashboard RestoApp</h3>
        <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ Auth::user()->username ?? 'Kasir' }}</strong>!</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="bi bi-cart-plus me-1"></i>Buka Kasir
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-primary border-4 p-3">
            <h6 class="text-muted text-uppercase mb-2" style="font-size:0.75rem;">Menu Cepat</h6>
            <a href="{{ route('orders.create') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-cart-check me-1"></i>Mulai Transaksi Baru
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-success border-4 p-3">
            <h6 class="text-muted text-uppercase mb-2" style="font-size:0.75rem;">Kelola Menu</h6>
            <a href="{{ route('menu-items.index') }}" class="btn btn-outline-success btn-sm">
                <i class="bi bi-card-list me-1"></i>Lihat Daftar Menu
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-warning border-4 p-3">
            <h6 class="text-muted text-uppercase mb-2" style="font-size:0.75rem;">Kelola Kategori</h6>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-warning btn-sm">
                <i class="bi bi-tags me-1"></i>Lihat Kategori
            </a>
        </div>
    </div>
</div>
@endsection
