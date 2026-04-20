<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class PajakGabunganExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Nama',
            'Pajak TPP',
            'Pajak THR',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            "'" . $row['nip'],
            $row['nama'],
            $row['pph_terutang'] ?? 0,
            $row['pph_thr'] ?? 0,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $rowCount = $this->data->count() + 2;
                $totalRow = $rowCount;

                // Apply number format to columns D and E
                $event->sheet->getDelegate()->getStyle('D2:D' . ($rowCount - 1))->getNumberFormat()->setFormatCode('#,##0');
                $event->sheet->getDelegate()->getStyle('E2:E' . ($rowCount - 1))->getNumberFormat()->setFormatCode('#,##0');

                // Add total row
                $event->sheet->setCellValue('A' . $totalRow, 'Total');
                $event->sheet->setCellValue('D' . $totalRow, '=SUM(D2:D' . ($rowCount - 1) . ')');
                $event->sheet->setCellValue('E' . $totalRow, '=SUM(E2:E' . ($rowCount - 1) . ')');

                $event->sheet->getDelegate()->getStyle('D' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');
                $event->sheet->getDelegate()->getStyle('E' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');
            },
        ];
    }
}
