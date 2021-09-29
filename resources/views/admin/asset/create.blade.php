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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Harga Tetap (Fixed Asset)</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.asset.print') }}" method="post" id="form">
                    @csrf
                    @include('admin.asset.form')
                </form>
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
    function OnSelect()
    {
        console.log($('#kelompok').val())
        $.ajax({
            url: '/api/asset/kelompok/'+$('#kelompok').val(),
            success: function(response){
                $('#metode').val(response.metode)
                $('#umur_ekonomis').val(response.umur)
            },
            error: function(err){
                alert(err)
            }
        })
    }
    function TheFormSubmit() {
        $('#form').submit()
    }
</script>
@endpush
