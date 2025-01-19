<?php

namespace App\Console\Commands;

use App\Imports\TppGuruImport;
use App\Jobs\ImportTppGuruJob;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportTppGuru extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-tpp-guru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = 3;
        $filePath = public_path('logo/tppguru.xlsx');

        if (!file_exists($filePath)) {
            $this->error("File $filePath tidak ditemukan.");
            return Command::FAILURE;
        }

        // Kirim job ke queue
        ImportTppGuruJob::dispatch($id, $filePath);

        $this->info('Job impor data telah dikirim ke queue!');
        return Command::SUCCESS;
    }
}
