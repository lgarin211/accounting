@extends('_layouts.main')
@section('title', 'Laba Rugi')
@push('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.report.menu') }}">Laporan Keuangan</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Laba Rugi</li>
@endpush
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-8">

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <a target="_blank" href="{{ route('admin.report.keuangan.labarugi.pdf', ['tempat' => $tempat, 'kodam' => $kodam, 'jabatan_fungsional' => $jabatan_fungsional, 'nama' => $nama, 'pangkat' => $pangkat, 'pangkat' => $pangkat, 'nrp' => $nrp]) }}" class="btn btn-danger">PDF</a>
                        {{-- Takeout sementara --}}
                        {{-- <a target="_blank" href="{{ route('admin.report.keuangan.labarugi.excel') }}" class="btn btn-success">EXCEL</a> --}}
                    </div>
                </div>
            </div>
                <div class="card rounded">
                    <p class="text-black text-center pt-2 font-weight-bolder">Direktorat Keuangan TNI Angkatan Darat</p>
                    <h2 class="text-center text-primary">Laba Rugi</h2>
                    <p class="text-black text-center">{{ date('F Y') }}</p>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless border">
                                <tr>
                                    <th class="text-primary">
                                        Pendapatan
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($pendapatan, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="border-top border-bottom">
                                    <th class="text-primary">
                                        Pendapatan Lain
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($PendapatanLain, 0, ',', '.') }}</td>
                                </tr>
                                {{-- <tr>
                                    <th class="text-primary">
                                        Beban atas pendapatan
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($beban, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="border-top border-bottom">
                                    <th class="text-primary">
                                        Laba Kotor
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($laba_kotor, 0, ',', '.') }}</td>
                                </tr> --}}
                                <tr >        
                                    <th class="text-primary">
                                        Biaya Operasional
                                    </th>
                                    <td class="text-right">Total = {{ 'Rp. ' . number_format($BiayaOperasional, 0, ',', '.') }}</td>
                                </tr>
                                @foreach ($Biaya_JU as $item)
                                <tr >
                                    <th class="text-primary">
                                       -> Jurnal Umum - {{$item->akun->name}}
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($item->debit, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                @foreach ($Biaya as $item)
                                <tr >
                                    <th class="text-primary">
                                       -> Kas & Bank - {{$item->name}}
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($item->jml_uang, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="border-top border-bottom">
                                    <th class="text-primary">
                                        Laba Bersih
                                    </th>
                                    <td class="text-right">{{ 'Rp. ' . number_format($laba_bersih, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                            <div class="form-group text-right mt-2">
                                <label>{{ $tempat . ', ' . $nowDate }}</label>
                                <br>
                                <label>a.n {{ $kodam }}</label>
                                <br>
                                <label>{{ $jabatan_fungsional }}</label>
                                <p style="height: 50px;"></p>
                                <label>{{ $nama }}</label>
                                <br>
                                <label>{{ $pangkat . ' NRP ' . $nrp }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
