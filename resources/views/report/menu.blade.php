@extends('_layouts.main')

@section('title', 'Laporan')
@if(request()->routeIs('admin.report.keuangan.menu'))
@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.report.menu') }}">Report</a></li>
<li class="breadcrumb-item active">Keuangan</li>
@endpush
@section('content')
<section id="card-content-types">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Keuangan</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Laporan Keuangan
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i> Arus Kas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Laba Rugi Standar</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Laba Rugi 12 Bulan</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Neraca</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Neraca 12 Bulan</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Neraca Saldo</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buku Besar</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Buku Besar
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Daftar Rekening</a></li>
                        <li class="list-group-item"><a href="{{ route('admin.report.keuangan.jurnalumum') }}"><i class=""></i> Jurnal Umum</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Jurnal - Semua Transaksi</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Buku Besar - Sederhana</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Buku Besar - Lengkap</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Jejak Audit - Ringkasan</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Jejak Audit - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Jejak Audit - Histori Transaksi</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Kas & Bank</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Kas & Bank
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i> Jurnal Pengeluaran</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Jurnal Penerimaan</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Rekonsiliasi Bank per Rekening Koran</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Rekonsiliasi Bank per Buku Besar</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Giro Masuk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Giro Masuk - hari Jatuh Tempo</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Giro Keluar</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i> Giro Keluar - hari Jatuh Tempo</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@endif
@if(request()->routeIs('admin.report.penjualandanpiutang.menu'))
@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.report.menu') }}">Report</a></li>
<li class="breadcrumb-item active">Penjualan dan Piutang</li>
@endpush
@section('content')
<section id="card-content-types">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Penjualan</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Penjualan
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Penawaran Harga - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Penawaran Harga - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Penawaran Harga - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pesanan Penjualan - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pesanan Penjualan - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pesanan Penjualan - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Status Pengiriman Pesanan Penjualan - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Penjualan - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Penjualan - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Penjualan - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Penjualan - Dengan Pengiriman Pesanan</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Penjualan - Rangkuman Per Penjual</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Pajak Penjualan</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Retur Penjualan - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Retur Penjualan - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Retur Penjualan - Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Piutang Usaha</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Daftar Piutang Usaha
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Umur Piutang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Kartu Piutang Usaha</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Mutasi Piutang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Analisa Pembayaran Piutang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pembayaran Piutang Usaha</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Surat Tagihan untuk Pelanggan</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pengiriman</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Pengiriman
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Pengiriman Pesanan - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pengiriman Pesanan - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pengiriman Pesanan - Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@endif
@if(request()->routeIs('admin.report.pembeliandanutang.menu'))
@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.report.menu') }}">Report</a></li>
<li class="breadcrumb-item active">Pembelian dan Utang</li>
@endpush
@section('content')
<section id="card-content-types">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Pembelian</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Pembelian
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Permintaan Penawaran Harga - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Permintaan Penawaran Harga - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Permintaan Penawaran Harga - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pesanan Pembelian - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pesanan Pembelian - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pesanan Pembelian - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Status Penerimaan Pesanan Pembelian - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Pembelian - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Pembelian - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Pembelian - Detail</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Faktur Pembelian - Dengan Pembelian Masuk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pajak Faktur Pembelian</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Retur Pembelian - Ringkas</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Retur Pembelian - Rangkuman</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Retur Pembelian - Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Utang Usaha</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Daftar Utang Usaha
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Umur Utang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Rincian Utang Usaha</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Mutasi Utang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pembayaran Utang Usaha</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Analisa Pembayaran Utang</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Penerimaan Barang</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Penerimaan Barang
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Pembelian Masuk - Simple</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pembelian Masuk - Summary</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pembelian Masuk - Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@endif

@if(request()->routeIs('admin.report.produk.menu'))
@push('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.report.menu') }}">Report</a></li>
<li class="breadcrumb-item active">Produk</li>
@endpush
@section('content')
<section id="card-content-types">
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Produk</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Produk
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Daftar Produk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Daftar Produk Per Gudang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Daftar Harga Jual Produk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Mutasi Produk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Mutasi Produk per Gudang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Produk Terjual</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Produk Dibeli</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Kartu Stok Persediaan Umum</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Kartu Stok Persediaan Per Gudang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Katalog Produk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Informasi Stok Minus</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Transaksi Produk</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Transaksi Produk
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Penyesuaian Barang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Pindah Gudang</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Stok Opname</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Persediaan Produksi</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Konsinyasi</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Konsinyasi
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Consignment Out Simple</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Consignment Out Summary</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Consignment Out Detail</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Analisa Produk</h4>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <p class="card-text">
                            Analisa Produk
                        </p>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href=""><i class=""></i>Produk Terlaris</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Total Analisis Profitablitas Produk</a></li>
                        <li class="list-group-item"><a href=""><i class=""></i>Inventory Analysis</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@endif
