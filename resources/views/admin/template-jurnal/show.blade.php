@extends('_layouts.main')
@section('title', 'Template Jurnal')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.ledger') }}">Jurnal</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.template-jurnal.index') }}">Template Jurnal</a>
        </li>
        <li class="breadcrumb-item active">Show</li>
    @endpush
        <div class="row">
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card py-2">
                    <div class="card-body pt-2">
                        <table class="table">
                            <tr>
                                <th class="head">
                                    Nama Template
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->nama_template }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Keterangan
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Frekuensi
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->frekuensi }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Per Tanggal
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->per_tanggal }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Sumber
                                    <span class="float-right">:</span>
                                </th>
                                @php
                                    switch ($template->sumber) {
                                        case 'KK':
                                            $sumber = 'Kas Keluar';
                                            break;
                                        
                                        case 'KM':
                                            $sumber = 'Kas Masuk';
                                            break;
                                        
                                        case 'JU':
                                            $sumber = 'Jurnal Umum';
                                            break;
                                    }
                                @endphp
                                <td>{{ $sumber }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Kontak
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->kontak->nama }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Divisi
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->divisi->nama }}</td>
                            </tr>
                            <tr>
                                <th>
                                    Uraian
                                    <span class="float-right">:</span>
                                </th>
                                <td>{{ $template->uraian }}</td>
                            </tr>
                        </table>
                        <div class="table-responsive">
                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Divisi</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($template->template_details as $key)
                                        <tr>
                                            <td>{{ $key->akun->kode }}</td>
                                            <td>{{ $key->akun->name }}</td>
                                            <td>{{ $template->divisi->nama }}</td>
                                            <td>{{ 'Rp. ' . number_format($key->debit, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($key->kredit, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ 'Rp. ' . number_format($template->template_details->sum('debit'), 0, ',', '.') }}
                                        </th>
                                        <th>{{ 'Rp. ' . number_format($template->template_details->sum('kredit'), 0, ',', '.') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('head')
    <style>
        .head {
            width: 300px;
        }

        @media only screen and (max-width: 768px) {
            .head {
                width: 200px;
            }
        }
    </style>
@endpush
