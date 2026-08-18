@php $book = $book ?? null; @endphp

<div class="field">
    <label for="title">Judul Buku</label>
    <input type="text" id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required autofocus>
</div>

<div class="field">
    <label for="author">Penulis</label>
    <input type="text" id="author" name="author" value="{{ old('author', $book->author ?? '') }}" required>
</div>

<div class="field">
    <label for="publisher">Penerbit</label>
    <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher ?? '') }}">
</div>

<div class="field">
    <label for="year">Tahun Terbit</label>
    <input type="number" id="year" name="year" value="{{ old('year', $book->year ?? '') }}" min="1900" max="{{ date('Y') + 1 }}">
</div>

<div class="field">
    <label for="description">Deskripsi</label>
    <textarea id="description" name="description">{{ old('description', $book->description ?? '') }}</textarea>
</div>

<div class="field">
    <label for="stock">Stok (jumlah eksemplar)</label>
    <input type="number" id="stock" name="stock" value="{{ old('stock', $book->stock ?? 0) }}" min="0" required>
</div>

<div class="field">
    <label for="cover">Cover Buku</label>
    @if (($book->cover ?? null))
        <div style="margin-bottom:8px;">
            <img src="{{ asset('covers/' . $book->cover) }}" alt="Cover saat ini" style="width:90px; border-radius: var(--radius-sm); border:1px solid var(--border);">
        </div>
    @endif
    <input type="file" id="cover" name="cover" accept="image/*">
    <div class="help-text">Format JPG/PNG/WEBP, maksimal 2MB. {{ ($book->cover ?? null) ? 'Kosongkan jika tidak ingin mengganti cover.' : '' }}</div>
</div>
