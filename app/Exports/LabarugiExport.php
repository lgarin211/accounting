<?php

namespace App\Exports;

use App\Models\Bkk;
use App\Models\Jurnalumumdetail;
use App\Models\Purchase\FakturBuy;
use App\Models\Sale\FakturSale;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LabarugiExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $pendapatan = FakturSale::sum('total');
        $beban = FakturBuy::sum('total');
        $laba_kotor = $pendapatan - $beban;

        $JU_AkunBO = Jurnalumumdetail::whereHas('akun', function ($query) {
            $query->where('level', 'BiayaOperasional');
        })->sum('debit');

        $BKK_AkunBO = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                                                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')    
                                                ->where('akuns.level','BiayaOperasional')
                                                ->where('bkks.status','BKK')
                                                ->select('jml_uang')
                                                ->sum('jml_uang');

        $BKM_PendapatLain = DB::table('bkk_details')->join('akuns', 'bkk_details.rekening_id', '=', 'akuns.id')
                                                ->join('bkks', 'bkk_details.bkk_id', '=', 'bkks.id')    
                                                ->where('akuns.level','PendapatanLain')
                                                ->where('bkks.status','BKM')
                                                ->select('jml_uang')
                                                ->sum('jml_uang');

        $BiayaOperasional = $JU_AkunBO + $BKK_AkunBO;
        $laba_bersih = $laba_kotor - $BiayaOperasional;
        $arra = [
            [
                strval($pendapatan),
                strval($BKM_PendapatLain),
                strval($BiayaOperasional),
                strval($laba_bersih)
            ]
        ];
        $data = collect($arra);
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                'Pendapatan',
                'Pendapatan Lain',
                // 'Beban atas pendapatan',
                // 'Laba Kotor',
                'Biaya Operasional',
                'Laba Bersih'
            ]
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $string = 'A1:E1';
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
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
