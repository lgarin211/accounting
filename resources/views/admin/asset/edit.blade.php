@extends('_layouts.main')
@section('title', 'Asset')
@push('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('admin.data-store') }}">Data Master</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('admin.asset.index') }}">Asset</a>
</li>
<li class="breadcrumb-item active" aria-current="page">Edit</li>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aktiva Tetap (Fixed Asset)</h3>
                <a href="{{ route('admin.asset.index') }}" class="btn btn-info">Back</a>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.asset.print_update', $asset->id) }}" method="post" id="form">
                    @csrf
                    @method('put')
                    @include('admin.asset.form')
                </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" onclick="TheFormSubmit()">Update</button>
            </div>
        </div>
    </div>
</div>
@stop
@push('script')
<script>
    function OnSelectKelompok() {
        console.log($('#kelompok').val())
        $.ajax({
            url: '/api/asset/kelompok/' + $('#kelompok').val(),
            success: function(response) {
                $('#metode').val(response.metode)
                $('#umur_ekonomis').val(response.umur)
            },
            error: function(err) {
                alert(err)
            }
        })
    }

    function OnSelectCategory() {
        console.log($('#category').val())
        $.ajax({
            url: '/api/asset/kategori/' + $('#category').val(),
            success: function(response) {
                $('#asset_harta').html('')
                $('#akumulasi_depresiasi').html('')
                $('#depresiasi').html('')
                $('#asset_harta').append('<option>--Pilih Asset Harta--</option>')
                $('#akumulasi_depresiasi').append('<option>--Pilih Akumulasi Depresiasi--</option>')
                $('#depresiasi').append('<option>--Pilih Depresiasi--</option>')
                $.each(response, function() {
                    $('#asset_harta').append('<option value="' + this.id + '">' + this.kode + ' - ' + this.name + '</option>')
                    $('#akumulasi_depresiasi').append('<option value="' + this.id + '">' + this.kode + ' - ' + this.name + '</option>')
                    $('#depresiasi').append('<option value="' + this.id + '">' + this.kode + ' - ' + this.name + '</option>')
                })
            },
            error: function(err) {
                Swal.fire(
                    'Alert!',
                    'Akun Kategori Tidak Ditemukan!',
                    'warning'
                )
            }
        })
    }

    function TheFormSubmit() {
        $('#form').submit()
    }
</script>
@endpush
