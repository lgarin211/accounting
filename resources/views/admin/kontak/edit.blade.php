@extends('_layouts.main')
@section('title', 'Kontak')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>Kontak</h5>
                            <span>Form edit kontak person</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Edit Kontak Person</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h3>Edit Kontak Person</h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('admin.kontak.update', $kontak->id) }}">
                            @csrf
                            @method('PUT')
                            <p><strong>Umum</strong></p>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nama">{{ __('Nama') }}<span class="text-red">*</span></label>
                                        <input id="nama" type="text" value="{{$kontak->nama}}"
                                            class="form-control @error('nama') is-invalid @enderror" name="nama" required>
                                        <div class="help-block with-errors"></div>
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}<span class="text-red">*</span></label>
                                        <input id="email" type="email" value="{{$kontak->email}}"
                                            class="form-control @error('email') is-invalid @enderror" name="email" required>
                                        <div class="help-block with-errors"></div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="telepon">Telepon<span class="text-red">*</span></label>
                                        <input id="telepon" type="text" value="{{$kontak->telepon}}"
                                            class="form-control @error('telepon') is-invalid @enderror" name="telepon"
                                            minlength="11" maxlength="13" onkeypress="return hanyaAngka(event)">
                                        <div class="help-block with-errors"></div>
                                        @error('telepon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="border-checkbox-section">
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox" type="checkbox" id="pelanggan" name="pelanggan" {{ ($kontak->pelanggan == 1 ? ' checked' : '') }}>
                                                <label class="border-checkbox-label" for="pelanggan">{{ __('Pelanggan')}}</label>
                                            </div>
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox" type="checkbox" id="pemasok" name="pemasok" {{ ($kontak->pemasok == 1 ? ' checked' : '') }}>
                                                <label class="border-checkbox-label" for="pemasok">{{ __('Pemasok')}}</label>
                                            </div>
                                            <div class="border-checkbox-group border-checkbox-group-primary">
                                                <input class="border-checkbox" type="checkbox" id="karyawan" name="karyawan" {{ ($kontak->karyawan == 1 ? ' checked' : '') }}>
                                                <label class="border-checkbox-label" for="karyawan">{{ __('Karyawan')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p><strong>Alamat</strong></p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="alamat">alamat</label>
                                        <textarea name="alamat" id="alamat"
                                            class="form-control @error('alamat') is-invalid @enderror">{{$kontak->alamat}}</textarea>
                                        <div class="help-block with-errors"></div>
                                        @error('alamat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="kota">kota</label>
                                        <input id="kota" type="text" value="{{$kontak->kota}}"
                                            class="form-control @error('kota') is-invalid @enderror" name="kota">
                                        <div class="help-block with-errors"></div>
                                        @error('kota')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="kode_pos">kode pos</label>
                                        <input id="kode_pos" type="text" value="{{$kontak->kode_pos}}"
                                            class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos">
                                        <div class="help-block with-errors"></div>
                                        @error('kode_pos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p><strong>Data Lainnya</strong></p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="kode_kontak">Kode Kontak</label>
                                        <input id="kode_kontak" type="text" value="{{$kontak->kode_kontak}}"
                                            class="form-control @error('kode_kontak') is-invalid @enderror" name="kode_kontak" required>
                                        <div class="help-block with-errors"></div>
                                        @error('kode_kontak')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mata_uang">{{ __('Mata Uang') }}</label>
                                        <select name="mata_uang" id="mata_uang" value="{{$kontak->mata_uang}}"
                                            class="form-control @error('mata_uang') is-invalid @enderror">
                                            <option value="IDR">IDR</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                        @error('mata_uang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input id="nik" type="text" value="{{$kontak->nik}}"
                                            class="form-control @error('nik') is-invalid @enderror" name="nik"
                                            onkeypress="return hanyaAngka(event)" minlength="16" maxlength="16">
                                        <div class="help-block with-errors"></div>
                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="kontak_person">Kontak Person</label>
                                        <input id="kontak_person" type="text" value="{{$kontak->kontak_person}}"
                                            class="form-control @error('kontak_person') is-invalid @enderror" name="kontak_person">
                                        <div class="help-block with-errors"></div>
                                        @error('kontak_person')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input id="website" type="text" value="{{$kontak->website}}"
                                            class="form-control @error('website') is-invalid @enderror" name="website">
                                        <div class="help-block with-errors"></div>
                                        @error('website')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-xl-4 mb-30">
                                    <p><strong>Aktif</strong></p>
                                    <input type="checkbox" class="js-single" name="aktif" {{ ($kontak->aktif == 1 ? ' checked' : '') }} />
                                </div>
                            </div>


                                <div class="col-md-12 mt-4">
                                    <div class="form-group">
                                        <a href="{{ route('admin.kontak.index') }}"
                                            class="btn btn-danger">KEMBALI</a>
                                        <button type="submit" class="btn btn-primary">
                                            UPDATE</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function hanyaAngka(e){
            let charCode = (e.which) ? e.which : e.keyCode
            if (charCode > 32 && (charCode < 48 || charCode > 57)) {
                return false
            }
            return true
        }
    </script>
@endpush
