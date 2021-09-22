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
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@stop
