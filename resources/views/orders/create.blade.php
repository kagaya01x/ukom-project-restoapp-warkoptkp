@extends('layouts.app')

@section('title', 'Kasir — Buat Pesanan')

@push('styles')
<style>
    .menu-card {
        cursor: pointer;
        border: 2px solid transparent;
    }
    .menu-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12) !important;
        border-color: #0d6efd;
    }
    .menu-card .card-img-top {
        height: 120px;
        object-fit: cover;
    }
    .cart-panel {
        position: sticky;
        top: 1rem;
        max-height: calc(100vh - 2rem);
        overflow-y: auto;
    }
    .cart-item-row {
        border-bottom: 1px solid #eee;
        padding: 0.5rem 0;
    }
    .qty-btn {
        width: 28px;
        height: 28px;
        padding: 0;
        font-size: 0.85rem;
        line-height: 1;
    }
    #empty-cart-msg { min-height: 100px; }
</style>
@endpush

@section('content')
<div class="mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-cart-plus me-2"></i>Kasir — Buat Pesanan</h4>
</div>

<div class="row g-3">
    <!-- Panel Kiri: Daftar Menu -->
    <div class="col-lg-7 col-xl-8">

        <!-- Filter Kategori -->
        <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
            <button class="btn btn-sm btn-primary category-filter active" data-category="all">
                Semua
            </button>
            @foreach($categories as $cat)
                <button class="btn btn-sm btn-outline-secondary category-filter"
                        data-category="{{ $cat->category_id }}">
                    {{ $cat->category_name }}
                </button>
            @endforeach
        </div>

        <!-- Grid Menu -->
        <div class="row g-3" id="menu-grid">
            @forelse($menuItems as $item)
            <div class="col-6 col-md-4 col-xl-3 menu-item-col"
                 data-category="{{ $item->category_id }}">
                <div class="card menu-card h-100 shadow-sm"
                     onclick="addToCart({{ $item->menu_item_id }}, '{{ addslashes($item->item_menu_name) }}', {{ $item->item_menu_price }})">
                    <!-- Image setting -->
                    @if($item->item_menu_img_link)
                        <img src="{{ asset('storage/' . $item->item_menu_img_link) }}"
                             class="card-img-top"
                             alt="{{ $item->item_menu_name }}"
                             onerror="this.src='https://via.placeholder.com/200x120?text=No+Image'">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                        </div>
                    @endif

                    <!-- Title dan harga makanan -->
                    <div class="card-body p-2">
                        <p class="card-title mb-1 fw-semibold" style="font-size:0.85rem;line-height:1.3;">
                            {{ $item->item_menu_name }}
                        </p>
                        <p class="text-primary fw-bold mb-0" style="font-size:0.85rem;">
                            Rp {{ number_format($item->item_menu_price, 0, ',', '.') }}
                        </p>
                        @if($item->category)
                            <span class="badge bg-light text-secondary" style="font-size:0.7rem;">
                                {{ $item->category->category_name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Belum ada menu tersedia.
                    <a href="{{ route('menu-items.create') }}">Tambah menu</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Panel Kanan: Keranjang -->
    <div class="col-lg-5 col-xl-4">
        <div class="card shadow-sm cart-panel">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2"></i>Keranjang</h6>
                <button class="btn btn-sm btn-outline-danger" onclick="clearCart()">
                    <i class="bi bi-trash me-1"></i>Kosongkan
                </button>
            </div>

            <div class="card-body p-3">
                <!-- Empty state -->
                <div id="empty-cart-msg" class="text-center text-muted py-4">
                    <i class="bi bi-cart-x fs-2 d-block mb-2"></i>
                    Keranjang kosong.<br>
                    <small>Klik menu untuk menambahkan.</small>
                </div>

                <!-- Item list -->
                <div id="cart-items"></div>

                <!-- Summary -->
                <div id="cart-summary" class="d-none">
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                        <span>Grand Total</span>
                        <span class="text-primary" id="grand-total-display">Rp 0</span>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Metode Pembayaran</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="payment_method" id="pay-cash"
                                       value="Cash" checked>
                                <label class="form-check-label" for="pay-cash">
                                    <i class="bi bi-cash me-1"></i>Cash
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="payment_method" id="pay-qris"
                                       value="QRIS">
                                <label class="form-check-label" for="pay-qris">
                                    <i class="bi bi-qr-code me-1"></i>QRIS
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            QRIS membutuhkan konfirmasi pembayaran manual dari kasir.
                        </small>
                    </div>

                    <!-- Tombol Checkout -->
                    <button class="btn btn-success w-100 btn-lg" id="btn-checkout" onclick="checkout()">
                        <i class="bi bi-check-circle me-2"></i>Buat Pesanan &amp; Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form untuk submit ke server -->
<form id="checkout-form" action="{{ route('orders.store') }}" method="POST" class="d-none">
    @csrf
    <div id="form-items-container"></div>
    <input type="hidden" name="payment_method" id="form-payment-method" value="Cash">
</form>
@endsection

@push('scripts')
<script>
// ============================================================
// State keranjang: { menu_item_id: { name, price, qty } }
// ============================================================
let cart = {};

function addToCart(id, name, price) {
    if (cart[id]) {
        cart[id].qty++;
    } else {
        cart[id] = { name, price, qty: 1 };
    }
    renderCart();
}

function updateQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) {
        delete cart[id];
    }
    renderCart();
}

function removeItem(id) {
    delete cart[id];
    renderCart();
}

function clearCart() {
    cart = {};
    renderCart();
}

function formatRupiah(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

function renderCart() {
    const cartItemsEl = document.getElementById('cart-items');
    const emptyMsg = document.getElementById('empty-cart-msg');
    const summary = document.getElementById('cart-summary');

    const keys = Object.keys(cart);

    if (keys.length === 0) {
        cartItemsEl.innerHTML = '';
        emptyMsg.classList.remove('d-none');
        summary.classList.add('d-none');
        return;
    }

    emptyMsg.classList.add('d-none');
    summary.classList.remove('d-none');

    let html = '';
    let grandTotal = 0;

    keys.forEach(id => {
        const item = cart[id];
        const subTotal = item.price * item.qty;
        grandTotal += subTotal;

        html += `
        <div class="cart-item-row">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <span class="fw-semibold" style="font-size:0.85rem;max-width:160px;">${item.name}</span>
                <button class="btn btn-sm btn-link text-danger p-0 ms-1"
                        onclick="removeItem(${id})" title="Hapus">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-secondary qty-btn"
                            onclick="updateQty(${id}, -1)">−</button>
                    <span class="fw-bold" style="min-width:24px;text-align:center;">${item.qty}</span>
                    <button class="btn btn-outline-secondary qty-btn"
                            onclick="updateQty(${id}, 1)">+</button>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">${formatRupiah(item.price)}/pcs</small>
                    <span class="fw-bold text-primary">${formatRupiah(subTotal)}</span>
                </div>
            </div>
        </div>`;
    });

    cartItemsEl.innerHTML = html;
    document.getElementById('grand-total-display').textContent = formatRupiah(grandTotal);
}

function checkout() {

    const keys = Object.keys(cart);
    if (keys.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    const btn = document.querySelector('#btn-checkout');
    btn.disabled = true;
    btn.innerHTML = 'Memproses...';

    // Ambil metode pembayaran yang dipilih
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    document.getElementById('form-payment-method').value = paymentMethod;

    // Bangun input hidden untuk setiap item
    const container = document.getElementById('form-items-container');
    container.innerHTML = '';
    let i = 0;
    Object.keys(cart).forEach(id => {
        container.innerHTML += `
            <input type="hidden" name="items[${i}][menu_item_id]" value="${id}">
            <input type="hidden" name="items[${i}][quantity]" value="${cart[id].qty}">
        `;
        i++;
    });

    document.getElementById('checkout-form').submit();
}

// ============================================================
// Filter Kategori
// ============================================================
document.querySelectorAll('.category-filter').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.category-filter').forEach(b => {
            b.classList.remove('btn-primary', 'active');
            b.classList.add('btn-outline-secondary');
        });
        this.classList.remove('btn-outline-secondary');
        this.classList.add('btn-primary', 'active');

        const selected = this.dataset.category;
        document.querySelectorAll('.menu-item-col').forEach(col => {
            if (selected === 'all' || col.dataset.category === selected) {
                col.style.display = '';
            } else {
                col.style.display = 'none';
            }
        });
    });
});
</script>
@endpush

