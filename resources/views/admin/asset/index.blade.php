@extends('_layouts.main')
@section('title', 'Asset')
@push('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.data-store') }}">Data Master</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Asset</li>
@endpush
@section('content')
    <div class="row">
        <!-- end message area-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h4 class="card-title">List Asset</h4>
                    </div>
                    <a href="{{ route('admin.asset.create') }}" class="btn btn-success">
                        <i data-feather="plus"></i>
                        Buat Baru
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
