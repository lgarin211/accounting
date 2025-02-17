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
    @if (count($errors) > 0)
    <div class="col-md-12">
        <div class="alert alert-warning">
            <h5 class="text-center">Validation</h5>
            <ul>
                @foreach ($errors->all() as $error)
                <li><strong> {{ $error }} </strong></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title"><strong>{{ $attr['nama'] }}</strong></h2>
                </div>
                <div class="btn-group">
                    <button class="btn btn-success" data-toggle="tooltip" data-html="true" title="{{ $attr['btn_asset_harta']->kode }}">
                        {{ $attr['btn_asset_harta']->name }}
                    </button>
                    <button class="btn btn-primary" data-toggle="tooltip" data-html="true" title="{{ $attr['btn_akumulasi_depresiasi']->kode }}">
                        {{ $attr['btn_akumulasi_depresiasi']->name }}
                    </button>
                    <button class="btn btn-warning" data-toggle="tooltip" data-html="true" title="{{ $attr['btn_depresiasi']->kode }}">
                        {{ $attr['btn_depresiasi']->name }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <table cellpadding="10">
                            <tr>
                                <th>Nama</th>
                                <th>:</th>
                                <th>{{ $attr['nama'] }}</th>
                            </tr>
                            <tr>
                                <th>Kelompok Aktiva</th>
                                <th>:</th>
                                <th>{{ $attr['kelompok']->nama }}</th>
                            </tr>
                            <tr>
                                <th>Tanggal Beli</th>
                                <th>:</th>
                                <th>{{ $attr['tanggal_beli'] }}</th>
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <th>:</th>
                                <th>{{ number_format($attr['harga_beli']) }}</th>
                            </tr>
                            <tr>
                                <th>Nilai Residu</th>
                                <th>:</th>
                                <th>{{ number_format($attr['nilai_residu']) }}</th>
                            </tr>
                            <tr>
                                <th>Umur Ekonomis</th>
                                <th>:</th>
                                <th>{{ $attr['umur_ekonomis'] }}</th>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <th>:</th>
                                <th>{{ $attr['lokasi'] }}</th>
                            </tr>
                            <tr>
                                <th>Metode</th>
                                <th>:</th>
                                <th>{{ $attr['metode'] }}</th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table cellpadding="10">
                            <tr>
                                <th>Nomor Aktiva</th>
                                <th>:</th>
                                <th>{{ $attr['nomor_aktiva'] ?? 'Kosong/Null' }}</th>
                            </tr>
                            <tr>
                                <th>Departemen</th>
                                <th>:</th>
                                <th>{{ $attr['departemen'] }}</th>
                            </tr>
                            <tr>
                                <th>Akumulasi Beban</th>
                                <th>:</th>
                                <th>Kosong/Null</th>
                            </tr>
                            <tr>
                                <th>Beban Per Tahun ini</th>
                                <th>:</th>
                                <th>{{ number_format($attr['beban_tahun']) }}</th>
                            </tr>
                            <tr>
                                <th>Terhitung Tanggal</th>
                                <th>:</th>
                                <th id="terhitung_tanggal">{{ $attr['terhitung_tanggal'] }}</th>
                            </tr>
                            <tr>
                                <th>Nilai Buku</th>
                                <th>:</th>
                                <th id="nilai_buku">{{ number_format($attr['nilai_buku']) }}</th>
                            </tr>
                            <tr>
                                <th>Beban Perbulan</th>
                                <th>:</th>
                                <th id="beban_bulan">{{ number_format($attr['beban_bulan']) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr class="bg-primary">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Akumulasi Penyusutan</th>
                                <th>Penyusutan Bulanan</th>
                                <th>Nilai Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collection as $data)
                            <tr onclick="ClickTheRow(this)">
                                <th>{{ $loop->iteration }}.</th>
                                <td class="text-center">
                                    <h5>{{ $data->tanggal }}</h5>
                                </td>
                                <td class="text-center"><span class="badge badge-info">{{ $data->akumulasi_penyusutan }}</span></td>
                                <td class="text-right"><strong>{{ number_format($data->penyusutan_bulanan) }}</strong></td>
                                <td class="text-right"><strong>{{ number_format($data->nilai_buku) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <form action="{{ route('admin.asset.store') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $attr['nama'] }}" name='nama'>
                    <input type="hidden" value="{{ $attr['kelompok']->id }}" name="kelompok_id">
                    <input type="hidden" value="{{ $attr['tanggal_beli'] }}" name="tanggal_beli">
                    <input type="hidden" value="{{ $attr['harga_beli'] }}" name="harga_beli">
                    <input type="hidden" value="{{ $attr['nilai_residu'] }}" name="nilai_residu">
                    <input type="hidden" value="{{ $attr['umur_ekonomis'] }}" name="umur_ekonomis">
                    <input type="hidden" value="{{ $attr['lokasi'] }}" name="lokasi">
                    <input type="hidden" value="{{ $attr['departemen'] }}" name="departemen">
                    <input type="hidden" value="{{ $attr['terhitung_tanggal'] }}" name="terhitung_tanggal">
                    <input type="hidden" value="{{ $attr['asset_harta'] }}" name="asset_harta">
                    <input type="hidden" value="{{ $attr['akumulasi_depresiasi'] }}" name="akumulasi_depresiasi">
                    <input type="hidden" value="{{ $attr['depresiasi'] }}" name="depresiasi">
                    <input type="hidden" value="{{ $attr['total_penyusutan'] }}" name="total_penyusutan">
                    <button class="btn btn-success" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@push('script')
<script>
    function ClickTheRow(row) {
        console.log($(row).children()[3])
        let beban_bulan = $($(row).children()[2])[0].innerHTML
        let nilai_buku = $(row)
        $('#beban_bulan').html(beban_bulan)
    }
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
</script>
@endpush
