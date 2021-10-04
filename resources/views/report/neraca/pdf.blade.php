<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div style="text-align: center;">
            <h5 class="">MARKAS BESAR TNI ANGKATAN DARAT DIREKTORAT KEUANGAN</h5>
            <!-- <hr>
            <table>
                <tr>
                    <th>Nomor</th>
                    <th>:</th>
                    <th>B/ /VIII/2021</th>
                </tr>
                <tr>
                    <th>Klasifikasi</th>
                    <th>:</th>
                    <th>Biasa</th>
                </tr>
                <tr>
                    <th>Lampiran</th>
                    <th>:</th>
                    <th>Satu Bundel</th>
                </tr>
                <tr>
                    <th>Perihal</th>
                    <th>:</th>
                    <th>Permohonan <i>Salary Crediting</i> BRI untuk Batlab TWP AD Agustus 2021</th>
                </tr>
            </table> -->
            <hr>
        </div>
    </div>

    <div class="border p-4">
        <div class="m-2">
            <h3 class="text-info">Aktiva</h3>
            @foreach($aktiva->unique('id') as $row)
            <ul class="list-unstyled ml-4">
                <li>
                    <h4>
                        {{ $row->kode }} - {{ $row->name }}
                    </h4>
                    @foreach($row->where('level', $row->level) as $data)
                    <ul class="list-unstyled ml-4">
                        <li>
                            <label for="" class="text-primary">{{ $data->name }}</label>
                            {{-- <h4>Rp. {{ number_format($data->debit - $data->kredit) }}</h4> --}}
                        </li>
                    </ul>
                    @endforeach
                    <label for="" class="text-primary">Total {{ $row->name }}</label>
                    <h4 class="text-right">Rp. {{ number_format($row->debit - $row->kredit) }}</h4>
                </li>

            </ul>
            @endforeach
            <h5 class="text-info">Total Aktiva</h5>
            <h4 class="text-right">Rp. {{ number_format($total_aktiva) }}</h4>
        </div>
        <br>
        <div class="m-2">
            <h3 class="text-info">Kewajiban</h3>
            @foreach($kewajiban->unique('id') as $row)
            <ul class="list-unstyled ml-4">
                <li>
                    <h4>
                        {{ $row->kode }} - {{ $row->name }}
                    </h4>
                    @foreach($row->where('level', $row->level) as $data)
                    <ul class="list-unstyled ml-4">
                        <li>
                            <label for="" class="text-primary">{{ $data->name }}</label>
                            {{-- <h4>Rp. {{ number_format($data->debit - $data->kredit) }}</h4> --}}
                        </li>
                    </ul>
                    @endforeach
                    <label for="" class="text-primary">Total {{ $row->name }}</label>
                    <h4 class="text-right">Rp. {{ number_format($row->debit - $row->kredit) }}</h4>
                </li>
            </ul>
            @endforeach
            <h5 class="text-info">Total Kewajiban</h5>
            <h4 class="text-right">Rp. {{ number_format($total_kewajiban) }}</h4>
        </div>
        <br>
        <div>
            <h3 class="text-info">Modal</h3>
            @foreach($modal->unique('id') as $row)
            <ul class="list-unstyled ml-4">
                <li>
                    <h4>
                        {{ $row->kode }} - {{ $row->name }}
                    </h4>
                    @foreach($row->where('level', $row->level) as $data)
                    <ul class="list-unstyled ml-4">
                        <li>
                            <label for="" class="text-primary">{{ $data->name }}</label>
                            {{-- <h4>Rp. {{ number_format($data->debit - $data->kredit) }}</h4> --}}
                        </li>
                    </ul>
                    @endforeach
                    <label class="text-primary">Total {{ $row->name }}</label>
                    <h4 class="text-right">Rp. {{ number_format($row->debit - $row->kredit) }}</h4>
                </li>
            </ul>
            @endforeach
            <h5 class="text-info">Total Modal</h5>
            <h4 class="text-right">Rp. {{ number_format($total_modal) }}</h4>
            <hr>
            <h6 class="text-right">{{ $tempat . ', ' . $nowDate }}</h6>
            <h6 class="text-right">a.n {{ $kodam }}</h6>
            <h6 class="text-right">{{ $jabatan_fungsional }}</h6>
            <p style="height: 65px;"></p>
            <h6 class="text-right">{{ $nama }}</h6>
            <h6 class="text-right">{{ $pangkat}}</h6>
            <h6 class="text-right">{{ $nrp }}</h6>
        </div>
    </div>
</body>

</html>
