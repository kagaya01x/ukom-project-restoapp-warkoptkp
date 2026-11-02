@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="mb-4">
    <a href="{{ route('categories.index') }}" class="text-decoration-none text-muted">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Kategori
    </a>
</div>

<div class="card shadow-sm" style="max-width:520px;">
    <div class="card-header">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="category_name" class="form-label fw-semibold">
                    Nama Kategori <span class="text-danger">*</span>
                </label>
                <input type="text"
                       class="form-control @error('category_name') is-invalid @enderror"
                       id="category_name"
                       name="category_name"
                       value="{{ old('category_name', $category->category_name) }}"
                       maxlength="100"
                       autofocus>
                @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

