@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="mb-4">
    <a href="{{ route('menu-items.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Menu
    </a>
</div>

<div class="card shadow-sm" style="max-width:600px;">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Menu</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('menu-items.update', $menuItem->menu_item_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">
                    Kategori <span class="text-danger">*</span>
                </label>
                <select class="form-select @error('category_id') is-invalid @enderror"
                        id="category_id" name="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}"
                            {{ old('category_id', $menuItem->category_id) == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="item_menu_name" class="form-label fw-semibold">
                    Nama Menu <span class="text-danger">*</span>
                </label>
                <input type="text"
                       class="form-control @error('item_menu_name') is-invalid @enderror"
                       id="item_menu_name" name="item_menu_name"
                       value="{{ old('item_menu_name', $menuItem->item_menu_name) }}"
                       maxlength="200">
                @error('item_menu_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="item_menu_price" class="form-label fw-semibold">
                    Harga (Rp) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number"
                           class="form-control @error('item_menu_price') is-invalid @enderror"
                           id="item_menu_price" name="item_menu_price"
                           value="{{ old('item_menu_price', $menuItem->item_menu_price) }}"
                           min="0">
                    @error('item_menu_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="item_menu_desc" class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control @error('item_menu_desc') is-invalid @enderror"
                          id="item_menu_desc" name="item_menu_desc"
                          rows="3">{{ old('item_menu_desc', $menuItem->item_menu_desc) }}</textarea>
                @error('item_menu_desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="item_menu_img_link" class="form-label fw-semibold">URL Gambar</label>
                @if($menuItem->item_menu_img_link)
                    <div class="mb-2">
                        <img src="{{ $menuItem->item_menu_img_link }}"
                             alt="Preview"
                             class="rounded"
                             style="height:60px;object-fit:cover;"
                             onerror="this.style.display='none'">
                    </div>
                @endif
                <input type="url"
                       class="form-control @error('item_menu_img_link') is-invalid @enderror"
                       id="item_menu_img_link" name="item_menu_img_link"
                       value="{{ old('item_menu_img_link', $menuItem->item_menu_img_link) }}">
                @error('item_menu_img_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
                <a href="{{ route('menu-items.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

