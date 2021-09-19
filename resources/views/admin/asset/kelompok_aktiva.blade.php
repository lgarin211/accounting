@extends('_layouts.main')
@section('title', 'Kelompok Aktiva')
@push('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.data-store') }}">Data Master</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Kelompok Aktiva</li>
@endpush
@section('content')
    
    @livewire('admin.kelompok-aktiva.data')
    
@endsection
@push('script')
    <script src="{{ asset('js/helpers.js') }}"></script>
@endpush