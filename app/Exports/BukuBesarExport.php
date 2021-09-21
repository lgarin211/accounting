<?php

namespace App\Exports;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;


class BukuBesarExport implements FromCollection, ShouldAutoSize, WithHeadings,WithStyles
{
    /**
     * return \Illuminate\Support\Collection
     */
    protected $id;
    public function __construct($id)
    {
        //why dont just put var to properti?
        //ngak bisa bang
        $this->TheSetFunc($id);
    }
    public function TheSetFunc($id)
    {
        //to set tonolodon
        $this->id = $id;
    }
    public function collection()
    {
        $collection = new Collection();
        $akun = Akun::find($this->id);
        $collection->push((object)[
            'tanggal' => 'Saldo Awal',
            'tipe' => '',
            'kode' => '',
            'nama' => '',
            'debit' => '',
            'kredit' => '',
            'saldo' => $akun->saldo_awal,
        ]);
        foreach ($akun->jurnalumumdetails as $data) {
            $collection->push((object)[
                'tanggal' => $data->jurnalumum->tanggal,
                'tipe' => 'Jurnal Umum',
                'kode' => $data->jurnalumum->kode_jurnal,
                'nama' => $data->jurnalumum->kontak->nama,
                'debit' => $data->debit,
                'kredit' => $data->kredit,
                'saldo' => ''
            ]);
        }
        $collection->push((object)[
            'tanggal' => 'Saldo Akhir',
            'tipe' => '',
            'kode' => '',
            'nama' => '',
            'debit' => '',
            'kredit' => '',
            'saldo' => $akun->saldo_akhir,
        ]);
        return $collection;
    }
    private function SaldoAkhir()
    {
        $row = Akun::find($this->id);
        $desk = '';
        foreach ($row->bkk as $item) {
            if ($item->status == 'BKK') {
                foreach ($item->bkk_details as $black) {
                    if ($desk != $item->desk) {
                        echo $item->tanggal;
                        echo $item->desk;
                        $desk = $item->desk;
                    }
                    echo $black->rekening->name;
                    echo $black->jml_uang;

                    $asik = $black->uang;
                }

                echo $item->akun->name;
                echo $item->value;
            }
            if ($item->status == 'BKM') {
                foreach ($item->bkk_details as $black) {
                    if ($desk != $item->desk) {
                        echo $item->tanggal;
                        echo $item->desk;
                        $desk = $item->desk;
                    }

                    echo $black->rekening->name;
                    echo $black->jml_uang;
                    $asik = $black->uang;
                }

                echo $item->akun->name;
                echo $item->value;
            }
        }
        echo $row->saldo_akhir;
    }
    public function headings(): array
    {
        return [
            [
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
        $string = 'A1:G1';
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
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
