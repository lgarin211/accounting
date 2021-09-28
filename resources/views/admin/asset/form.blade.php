<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama">
            @error('nama')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">

            <label for="kelompok">Kelompok</label>
            <select class="form-control" name="kelompok">
                @foreach($kelompok as $data)
                <option value="{{ $data->id }}">{{ $data->nama }} - {{ $data->umur }} - {{ $data->metode }}</option>
                @endforeach
            </select>
            @error('kelompok')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="date">date</label>
            <input type="date" class="form-control" name="date">
            @error('date')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="harga_beli">Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli">
            @error('harga_beli')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nilai_residu">Nilai Residu</label>
            <input type="number" class="form-control" name="nilai_residu">
            @error('nilai_residu')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="umur_ekonomis">Umur Ekonomis</label>
            <input type="number" class="form-control @error('umur_ekonomis') is-invalid @enderror" name="umur_ekonomis">
            @error('is-invalid')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>