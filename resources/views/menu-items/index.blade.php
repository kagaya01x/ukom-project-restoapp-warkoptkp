@extends('layouts.app')

@section('title', 'Daftar Menu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Daftar Menu</h4>
        <small class="text-muted">Kelola item makanan dan minuman</small>
    </div>
    <a href="{{ route('menu-items.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Menu
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width:60px">#</th>
                        <th style="width:70px">Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuItems as $item)
                    <tr>
                        <td class="text-muted">{{ $menuItems->firstItem() + $loop->index }}</td>
                        <td>
                            @if($item->item_menu_img_link)
                                <img src="{{ $item->item_menu_img_link }}"
                                     alt="{{ $item->item_menu_name }}"
                                     class="rounded"
                                     style="width:48px;height:48px;object-fit:cover;"
                                     onerror="this.src='https://via.placeholder.com/48x48?text=No+Img'">
                            @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                     style="width:48px;height:48px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $item->item_menu_name }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $item->category->category_name ?? '-' }}
                            </span>
                        </td>
                        <td class="text-nowrap">
                            Rp {{ number_format($item->item_menu_price, 0, ',', '.') }}
                        </td>
                        <td class="text-muted" style="max-width:200px;">
                            <span class="d-inline-block text-truncate" style="max-width:180px;">
                                {{ $item->item_menu_desc ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('menu-items.edit', $item->menu_item_id) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('menu-items.destroy', $item->menu_item_id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus menu \'{{ $item->item_menu_name }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada menu. <a href="{{ route('menu-items.create') }}">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($menuItems->hasPages())
    <div class="card-footer">
        {{ $menuItems->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

