<?php

namespace App\Exports;

use App\Models\Pajak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PppkExport implements FromCollection, WithMapping, WithCustomStartCell, ShouldAutoSize, WithColumnFormatting
{
    public function collection()
    {
        return Pajak::all();
    }
    // Memulai data dari sel tertentu (misalnya A2)
    public function startCell(): string
    {
        return 'A6';
    }
    public function columnFormats(): array
    {
        return [
            'C' => '#', // Format Rupiah dengan pemisah ribuan
        ];
    }
    public function map($user): array
    {
        return [
            $user->id,
            $user->nip,
        ];
    }
}
