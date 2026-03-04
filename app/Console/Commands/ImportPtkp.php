<?php

namespace App\Console\Commands;

use App\Imports\PtkpImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportPtkp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-ptkp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data PTKP dari file Excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = public_path('excel/ptkp.xlsx');

        if (!file_exists($filePath)) {
            $this->error("File $filePath tidak ditemukan.");
            return Command::FAILURE;
        }

        try {
            $this->info('Mulai mengimpor data PTKP...');
            
            Excel::import(new PtkpImport, $filePath);

            $this->info('Data PTKP berhasil diimpor!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}