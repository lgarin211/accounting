@extends('_layouts.main')
@section('title', 'Laporan - Buku Besar')
@push('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('admin.report.menu') }}">Laporan Keuangan</a>
</li>
<li class="breadcrumb-item" aria-current="page">Buku Besar</li>
@endpush
@section('content')
<div class="row">
    <!-- end message area-->
    <div class="col-lg-12 col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    @if (request('startDate') && request('endDate'))
                    <a href="{{ route('admin.report.keuangan.jurnalumum') }}" class="btn btn-danger btn-sm mr-1"><i class="fa fa-arrow-left"></i></a>
                    <h2 class="badge badge-success p-1"><u>Laporan Dari : {{ $startDate }} &middot; Sampai :
                            {{ $endDate }}</u></h2>
                    @else
                    <h2 class="badge badge-success p-1"><u>SILAHKAN CARI DATA SESUAI TANGGAL.</u></h2>
                    @endif
                </div>
                <div>
                    <form action="{{ route('admin.report.keuangan.bukubesar.cari') }}" method="GET">
                        @csrf
                        <div class="d-flex">
                            <div class="form-group">
                                <label for="">Akun</label>
                                <select name="kontak" id="" class="form-control">
                                    <option @isset($selected) @if($selected == 'all') selected  @endif @endisset value="all">All</option>
                                    @foreach ($kontak as $value)
                                    <option @isset($selected) @if($selected == $value->id) selected @endif @endisset  value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ml-1">
                                <label for="startDate" class="mr-2">Start Date</label>
                                <input type="date" value="{{ $startDate ?? '' }}" class="form-control @error('startDate') is-invalid @enderror" name="startDate" id="startDate" required>
                                @error('startDate')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group ml-1">
                                <label for="endDate" class="mr-2">End Date</label>
                                <input type="date" value="{{ $endDate ?? '' }}" class="form-control @error('endDate') is-invalid @enderror mr-1" name="endDate" id="endDate" required>
                                @error('endDate')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-btn ml-1">
                                <button type="submit" class="btn btn-success mt-2"><i data-feather="search"></i></button>
                                <a href="{{ route('admin.report.keuangan.bukubesar') }}" class="btn btn-info mt-2"><i data-feather='rotate-cw'></i></a>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('admin.bukubesar.laporan.excel.export') }}" method="post">
                        @csrf
                        <div class="d-flex">
                            <input type="text" name="select" hidden value="{{ $selected ?? 'all' }}">
                            <input type="text" name="start" hidden value="{{ $startDate ?? '' }}">
                            <input type="text" name="end" hidden value="{{ $endDate ?? '' }}">
                            <button class="btn btn-primary">Excel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @foreach ($akun as $row)
                <br>
                <hr>
                <br>
                <div class="d-flex justify-content-between">
                    <h3>{{ $row->name }} - {{ $row->id }}</h3>
                    <h3>{{ $row->name }}</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>No.Ref</th>
                                <th>Uraian</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">Saldo Awal</td>
                                <td>0</td>
                            </tr>
                            @foreach ($row->jurnalumumdetails as $data)
                            <tr class="bg-info">
                                <td>{{ $data->jurnalumum->tanggal }}</td>
                                <td>Jurnal Umum</td>
                                <td>{{ $data->jurnalumum->kode_jurnal }}</td>
                                <td>{{ $data->jurnalumum->uraian }}</td>
                                <td>{{ $data->debit }}</td>
                                <td colspan="2">{{ $data->kredit }}</td>

                            </tr>
                            @endforeach
                            @foreach ($row->bkk as $data)
                            <tr class="bg-warning">
                                <td>{{ $data->tanggal }}</td>
                                <td>Buku dan Kas</td>
                                @if ($rowsCount > 0)
                                    @if ($data->id < 9)
                                    <td>
                                        KK0000{{ $data->id }}
                                    </td>
                                        @elseif ($data->id < 99)
                                        <td>KK000{{ $data->id }}

                                        </td>
                                            @elseif ($data->id < 999)
                                             <td>KK00{{ $data->id }}

                                             </td>
                                    @elseif ($data->id < 9999)
                                     <td>
                                         KK0{{ $data->id }}
                                     </td>
                                    @else
                                        <td>KK{{ $data->id }}</td>
                                    @endif
                                @endif
                                                <td>{{ $data->desk }}</td>
                                                @if ($data->status == "BKK")
                                                <td></td>
                                                @endif
                                                <td colspan="3">{{ $data->value }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4">Saldo Awal</td>
                                <td>{{ $row->jurnalumumdetails->sum('debit') }}</td>
                                <td>{{ $row->jurnalumumdetails->sum('kredit') }}</td>
                            </tr>
                            <tr class="bg-primary text-light">
                                <td colspan="6">Saldo Akhir</td>
                                <td>{{ $row->jurnalumumdetails->sum('debit') - $row->jurnalumumdetails->sum('kredit') + $row->bkk->sum('value') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
