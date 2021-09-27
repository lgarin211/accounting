<?php

namespace App\Exports;

use App\Models\Akun;
use App\Models\Bkk;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class LaporanBukuBesarExport implements FromCollection, ShouldAutoSize, WithHeadings,WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $attr;
    public function __construct($attr)
    {
        $this->attr = $attr;
    }
    public function collection()
    {
        $attr = $this->attr;
        $from = $attr['start'];
        $to = $attr['end'];
        $kontak = $attr['select'];
        if ($kontak == 'all' and $from == '' and $to == '') {
            $akun = Akun::get();
        }
        if ($kontak == 'all' and $from != '' and $to != '') {
            $akun = Akun::whereHas('jurnalumumdetails', function ($q) use ($from, $to) {
                return $q->whereHas('jurnalumum', function ($qr) use ($from, $to) {
                    return
                    $qr->whereBetween('tanggal', [$from, $to]);
                });
            })->get();
        }
        if($kontak != 'all' and $from != '' and $to != ''){
            $akun = Akun::where('id', $kontak)->whereHas('jurnalumumdetails', function ($q) use ($from, $to) {
                return $q->whereHas('jurnalumum', function ($qr) use ($from, $to) {
                    return
                        $qr->whereBetween('tanggal', [$from, $to]);
                });
            })->get();
        }
        $collection = new Collection();
        foreach ($akun as $row) {
            foreach ($row->jurnalumumdetails as $data) {
                $collection->push((object)[
                    'akun' => $data->akun->name,
                    'tanggal' => $data->jurnalumum->tanggal,
                    'tipe' => 'Jurnal Umum',
                    'no' => $data->jurnalumum->kode_jurnal,
                    'uraian' => $data->jurnalumum->uraian,
                    'debit' => $data->debit,
                    'kredit' => $data->kredit,
                    'saldo' => 0,
                ]);
            }
            foreach ($row->bkk as $data) {
                $collection->push((object)[
                    'akun' => $data->akun->name,
                    'tanggal' => $data->tanggal,
                    'tipe' => 'Buku dan Kas',
                    'no' => $this->CheckAndCount($data->id),
                    'uraian' => $data->desk,
                    'debit' => $data->value,
                    'kredit' => 0,
                    'saldo' => 0,
                ]);
            }
            $collection->push((object)[
                'akun' => 'saldo awal : '.$row->name,
                'tanggal' => '',
                'tipe' => '',
                'no' => '',
                'uraian' => '',
                'debit' => $row->jurnalumumdetails->sum('debit'),
                'kredit' => $row->jurnalumumdetails->sum('kredit'),
                'saldo' => 0,
            ]);
            $collection->push((object)[
                'akun' => 'saldo akhir : '.$row->name,
                'tanggal' => '',
                'tipe' => '',
                'no' => '',
                'uraian' => '',
                'debit' => '',
                'kredit' => '',
                'saldo' => $row->jurnalumumdetails->sum('debit') - $row->jurnalumumdetails->sum('kredit') + $row->bkk->sum('value'),
            ]);
        }
        return $collection;
    }
    public function CheckAndCount($data)
    {
        $rowsCount = Bkk::orderBy('id', 'DESC')->get()->count();
        if ($rowsCount > 0) {
            if ($data < 9) {

                return 'KK0000' . $data;
            } elseif ($data < 99) {
                return 'KK000' . $data;
            } elseif ($data < 999) {
                return 'KK00' . $data;
            } elseif ($data < 9999) {
                return 'KK0' . $data;
            } else {
                return 'KK' . $data;
            }
        }
    }
    public function headings(): array
    {
        return [
            [
                'AKUN',
                'TANGGAL',
                'TIPE',
                'NO.REF',
                'KONTAK',
                'DEBIT',
                'KREDIT',
                'SALDO'
            ]
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $string = 'A1:H1';
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle($string)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
}
