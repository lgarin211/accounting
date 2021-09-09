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
            <p class="text-right">{{ date('F Y') }}</p>
            <hr>
        </div>
    </div>
    <div class="border p-4">

        <table cellpadding="15">
            <tr>
                <th>
                    Pendapatan
                </th>
                <th>:</th>
                <th>{{ 'Rp. ' . number_format($pendapatan, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th>
                    Beban atas pendapatan
                </th>
                <th>:</th>
                <th>{{ 'Rp. ' . number_format($beban, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th>
                    Laba Kotor
                </th>
                <th>:</th>
                <th>{{ 'Rp. ' . number_format($laba_kotor, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th>
                    Biaya Operasional
                </th>
                <th>:</th>
                <th>{{ 'Rp. ' . number_format($BiayaOperasional, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th>
                    Laba Bersih
                </th>
                <th>:</th>
                <th>{{ 'Rp. ' . number_format($laba_bersih, 0, ',', '.') }}</th>
            </tr>
        </table>
    </div>
</body>

</html>
