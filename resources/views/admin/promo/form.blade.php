<div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $promo->nama ?? '' }}" required>
</div>
<div class="mb-3">
    <label for="foto" class="form-label">Foto</label>
    <input type="file" class="form-control" id="foto" name="foto" {{ $promo ? '' : 'required' }}>
</div>
<div class="mb-3">
    <label for="tipe" class="form-label">Tipe</label>
    <select class="form-control" id="tipe" name="tipe" required>
        <option value="videografi" {{ isset($promo) && $promo->tipe == 'videografi' ? 'selected' : '' }}>Videografi
        </option>
        <option value="fotografi" {{ isset($promo) && $promo->tipe == 'fotografi' ? 'selected' : '' }}>Fotografi
        </option>
    </select>
</div>
<div class="mb-3">
    <label for="harga" class="form-label">Harga</label>
    <input type="number" class="form-control" id="harga" name="harga" value="{{ $promo->harga ?? '' }}" required>
</div>
<div class="mb-3">
    <label for="waktu" class="form-label">Waktu</label>
    <input type="text" class="form-control" id="waktu" name="waktu" value="{{ $promo->waktu ?? '' }}" required>
</div>
<div class="mb-3">
    <label for="tenaga_kerja" class="form-label">Tenaga Kerja</label>
    <input type="text" class="form-control" id="tenaga_kerja" name="tenaga_kerja"
        value="{{ $promo->tenaga_kerja ?? '' }}" required>
</div>
<div class="mb-3">
    <label for="penyimpanan" class="form-label">Penyimpanan</label>
    <input type="text" class="form-control" id="penyimpanan" name="penyimpanan"
        value="{{ $promo->penyimpanan ?? '' }}" required>
</div>
<div class="mb-3">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ $promo->deskripsi ?? '' }}</textarea>
</div>
