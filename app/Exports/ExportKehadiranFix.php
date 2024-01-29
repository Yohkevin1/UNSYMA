<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportKehadiranFix implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $TA, $Pertemuan, $Games;

    public function __construct($ta, $pertemuan, $games)
    {
        $this->TA = $ta;
        $this->Pertemuan = $pertemuan;
        $this->Games = $games;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function styles(Worksheet $sheet)
    {
        // Style array for all cells
        $commonStyleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => '000000', // Black font color
                ],
            ],
        ];

        // Style array for header row
        $headerStyleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '000000',
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        // Style array for "Total Hadir" column
        $totalHadirStyleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '00FF00', // Green background color
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => '000000',
                ],
                'bold' => true,
            ],
        ];

        $totalAlphaStyleArray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FF0000', // Red background color
                ],
            ],
            'font' => [
                'color' => [
                    'rgb' => '000000',
                ],
                'bold' => true,
            ],
        ];

        // Apply common styles to all cells
        $sheet->getStyle('A1:F' . $sheet->getHighestRow())->applyFromArray($commonStyleArray);

        // Apply header styles to the header row
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyleArray);

        // Apply styles to "Total Hadir" column
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle('E2:' . $lastColumn . $sheet->getHighestRow())->applyFromArray($totalHadirStyleArray);
        $sheet->getStyle('F2:' . $lastColumn . $sheet->getHighestRow())->applyFromArray($totalAlphaStyleArray);
    }

    public function Collection()
    {
        $result = DB::table('anggota')
            ->select(
                'anggota.id_anggota',
                'anggota.nama',
                'anggota.npm',
                'games.nama_games',
                DB::raw('COUNT(CASE WHEN detail_pertemuan.status = "Hadir" THEN detail_pertemuan.id_anggota END) AS Total_Hadir'),
                DB::raw('COUNT(CASE WHEN detail_pertemuan.status = "Alpha" THEN detail_pertemuan.id_anggota END) AS Total_Alpha')
            )
            ->leftJoin('detail_pertemuan', 'detail_pertemuan.id_anggota', '=', 'anggota.id_anggota')
            ->leftJoin('pertemuan', 'detail_pertemuan.id_pertemuan', '=', 'pertemuan.id_pertemuan')
            ->leftJoin('tahun_akademik as ta', 'pertemuan.id_ta', '=', 'ta.id_ta')
            ->leftJoin('games', 'anggota.id_games', '=', 'games.id_games')
            ->whereNull('pertemuan.deleted_at')
            ->groupBy('anggota.id_anggota', 'anggota.nama', 'anggota.npm', 'games.nama_games');

        if ($this->TA) {
            $result = $result->where('ta.id_ta', $this->TA);
        }
        if ($this->Games != 0) {
            $result = $result->where('games.id_games', $this->Games);
        }
        if ($this->Pertemuan != 0) {
            $result = $result->where('pertemuan.id_pertemuan', $this->Pertemuan);
        }

        $result = $result->get();
        $no = 1;
        $output = [];
        foreach ($result as $row) {
            $output[] = [
                $no++,
                $row->nama,
                $row->npm ?: 'null',
                $row->nama_games,
                $row->Total_Hadir ?: '0',
                $row->Total_Alpha ?: '0',
            ];
        }

        return collect($output);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["No", 'Nama Lengkap', 'NPM', 'Games', 'Total Hadir', 'Total Alpha'];
    }
}
