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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h4 class="card-title">List Asset</h4>
                </div>
                <div>
                    <a class="btn btn-info" href="{{ route('admin.kelompok-index') }}">
                        <i data-feather="book-open"></i>
                        Kelompok Aktiva
                    </a>
                    <a href="{{ route('admin.asset.create') }}" class="btn btn-success">
                        <i data-feather="plus"></i>
                        Buat Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kelompok</th>
                                <th>Tanggal Beli</th>
                                <th>Harga Beli</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset as $data)
                            <tr>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->kelompok->nama ?? 'Kosong' }}</td>
                                <td>{{ $data->tanggal_beli }}</td>
                                <td>{{ $data->harga_beli }}</td>
                                <td><div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                            data-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.asset.show', $data->id) }}">
                                                <i data-feather="eye"></i>
                                                <span class="ml-1">Show</span>
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.asset.edit', $data->id) }}">
                                                <i data-feather="edit"></i>
                                                <span class="ml-1">Edit</span>
                                            </a>
                                            <a href="javascript:void('delete')" class="dropdown-item text-danger"
                                                onclick="deleteConfirm('form-delete', '{{ $data->id }}')">
                                                <i data-feather="trash"></i>
                                                <span class="ml-1">Delete</span>
                                            </a>
                                            <form id="form-delete{{ $data->id }}" action="{{ route('admin.asset.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </div>
                                    </div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
