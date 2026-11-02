@extends('layouts.app')

@section('title', 'Kategori Menu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold">Kategori Menu</h4>
        <small class="text-muted">Kelola kategori makanan dan minuman</small>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Nama Kategori</th>
                        <th style="width:120px">Jumlah Menu</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-muted">{{ $categories->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $category->category_name }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $category->menu_items_count ?? $category->menuItems()->count() }} menu
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('categories.edit', $category->category_id) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category->category_id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori \'{{ $category->category_name }}\'?')">
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
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                            Belum ada kategori. <a href="{{ route('categories.create') }}">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

