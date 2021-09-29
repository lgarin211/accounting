<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" class="form-control  @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}">
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
            <select id="kelompok" class="form-control  @error('kelompok') is-invalid @enderror" id="kelompok" onchange="OnSelect()" name="kelompok">
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
            <label for="date">Tanggal Beli</label>
            <input type="date" id="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" name="date">
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
    <div class="col-md-3">
        <div class="form-group">
            <label for="harga_beli">Harga Beli</label>
            <input type="text" id="harga_beli" onkeyup="ChangeToFormatter(this)" value="{{ old('harga_beli') }}" class="form-control  @error('harga_beli') is-invalid @enderror" name="harga_beli">
            @error('harga_beli')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="nilai_residu">Nilai Residu</label>
            <input type="text" id="nilai_residu" onkeyup="ChangeToFormatter(this)" value="{{ old('nilai_residu') }}" class="form-control  @error('nilai_residu') is-invalid @enderror" name="nilai_residu">
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
            <input type="text" id="umur_ekonomis" readonly value="{{ old('umur_ekonomis') }}" class="form-control @error('umur_ekonomis') is-invalid @enderror" name="umur_ekonomis">
            @error('umur_ekonomis')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <textarea type="text" id="lokasi" value="{{ old('lokasi') }}" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"></textarea>
            @error('lokasi')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="metode">Metode</label>
            <input type="text" id="metode" readonly value="{{ old('metode') }}" class="form-control @error('metode') is-invalid @enderror" name="metode" id="metode">
            @error('metode')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nomor_aktiva">nomor aktiva</label>
            <input type="text" id="nomor_aktiva" value="{{ old('nomor_aktiva') }}" class="form-control @error('nomor_aktiva') is-invalid @enderror" name="nomor_aktiva">
            @error('nomor_aktiva')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="departemen">departemen</label>
            <select class="form-control @error('departemen') is-invalid @enderror" name="departemen">
                <option value="1">Gedung</option>
            </select>
            @error('departemen')
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
            <label for="akumulasi_beban">akumulasi beban</label>
            <input type="text" id="akumulasi_beban" onkeyup="ChangeToFormatter(this)" value="{{ old('akumulasi_beban') }}" class="form-control @error('akumulasi_beban') is-invalid @enderror" name="akumulasi_beban">
            @error('akumulasi_beban')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="beban_tahun">beban per tahun ini</label>
            <input type="text" id="beban_tahun" onkeyup="ChangeToFormatter(this)" value="{{ old('beban_tahun') }}" class="form-control @error('beban_tahun') is-invalid @enderror" name="beban_tahun">
            @error('beban_tahun')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="terhitung_tanggal">terhitung tanggal</label>
            <input type="date" id="terhitung_tanggal" value="{{ old('terhitung_tanggal') }}" class="form-control @error('terhitung_tanggal') is-invalid @enderror" name="terhitung_tanggal">
            @error('terhitung_tanggal')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="nilai_buku">nilai buku</label>
            <input type="text" id="nilai_buku" onkeyup="ChangeToFormatter(this)" value="{{ old('nilai_buku') }}" class="form-control @error('nilai_buku') is-invalid @enderror" name="nilai_buku">
            @error('nilai_buku')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="beban_bulan">beban bulan</label>
            <input type="text" id="beban_bulan" onkeyup="ChangeToFormatter(this)" value="{{ old('beban_bulan') }}" class="form-control @error('beban_bulan') is-invalid @enderror" name="beban_bulan">
            @error('beban_bulan')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
    </div>
</div>
<script>
    const formatter = function(num) {
        var str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (var j = 0, len = str.length; j < len; j++) {
            if (str[j] != ",") {
                output.push(str[j]);
                if (i % 3 == 0 && j < (len - 1)) {
                    output.push(",");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
    };
    function ChangeToFormatter(qr)
    {
        qr.value = formatter(qr.value)
    }
</script>
