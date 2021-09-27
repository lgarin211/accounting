@extends('_layouts.main')
@section('title', 'Asset')
@push('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('admin.data-store') }}">Data Master</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.asset.index') }}">Asset</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Create</li>
@endpush
@section('content')
<input type="hidden" value="{{ $attr['harga_beli'] }}" id="harga_beli">
<input type="hidden" value="{{ $attr['umur_ekonomis'] }}" id="umur">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $attr['nama'] }}</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <th>Nama</th>
                                <th>:</th>
                                <th>{{ $attr['nama'] }}</th>
                            </tr>
                            <tr>
                                <th>kelompok</th>
                                <th>:</th>
                                <th>{{ $attr['kelompok'] }}</th>
                            </tr>
                            <tr>
                                <th>date</th>
                                <th>:</th>
                                <th>{{ $attr['date'] }}</th>
                            </tr>
                            <tr>
                                <th>harga_beli</th>
                                <th>:</th>
                                <th>{{ number_format($attr['harga_beli']) }}</th>
                            </tr>
                            <tr>
                                <th>nilai_residu</th>
                                <th>:</th>
                                <th>{{ number_format($attr['nilai_residu']) }}</th>
                            </tr>
                            <tr>
                                <th>umur_ekonomis</th>
                                <th>:</th>
                                <th>{{ $attr['umur_ekonomis'] }}</th>
                            </tr>
                            <tr>
                                <th>lokasi</th>
                                <th>:</th>
                                <th>{{ $attr['lokasi'] }}</th>
                            </tr>
                            <tr>
                                <th>metode</th>
                                <th>:</th>
                                <th>{{ $attr['metode'] }}</th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <th>nomor_aktiva</th>
                                <th>:</th>
                                <th>{{ $attr['nomor_aktiva'] }}</th>
                            </tr>
                            <tr>
                                <th>departemen</th>
                                <th>:</th>
                                <th>{{ $attr['departemen'] }}</th>
                            </tr>
                            <tr>
                                <th>akumulasi_beban</th>
                                <th>:</th>
                                <th>{{ number_format($attr['akumulasi_beban']) }}</th>
                            </tr>
                            <tr>
                                <th>beban_tahun</th>
                                <th>:</th>
                                <th>{{ number_format($attr['beban_tahun']) }}</th>
                            </tr>
                            <tr>
                                <th>terhitung_tanggal</th>
                                <th>:</th>
                                <th>{{ $attr['terhitung_tanggal'] }}</th>
                            </tr>
                            <tr>
                                <th>nilai_buku</th>
                                <th>:</th>
                                <th>{{ number_format($attr['nilai_buku']) }}</th>
                            </tr>
                            <tr>
                                <th>beban_bulan</th>
                                <th>:</th>
                                <th>{{ number_format($attr['beban_bulan']) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penyusutan_per_tahun">penyusutan per tahun</label>
                            <input type="text" id="penyusutan_per_tahun" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penyusutan_per_bulan">penyusutan per bulan</label>
                            <input type="text" id="penyusutan_per_bulan" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <th>Tanggal</th>
                            <th>Akumulasi Penyusutan</th>
                            <th>Penyusutan Bulanan</th>
                            <th>Nilai Buku</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" onclick="TheFormSubmit()">Submit</button>
            </div>
        </div>
    </div>
</div>
@stop
@push('script')
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
    hitung()

    function hitung() {
        let penyusutan_per_tahun = parseInt($('#harga_beli').val() / parseInt($('#umur').val()))
        let penyusutan_per_bulan = parseInt(penyusutan_per_tahun) / 12
        $('#penyusutan_per_tahun').val(formatter(penyusutan_per_tahun))
        $('#penyusutan_per_bulan').val(formatter(penyusutan_per_bulan))
    }

    function TheFormSubmit() {
        $('#form').submit()
    }
</script>
@endpush
