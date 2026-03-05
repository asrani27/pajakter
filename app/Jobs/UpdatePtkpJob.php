<?php

namespace App\Jobs;

use App\Models\Pajak;
use App\Models\Ptkp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UpdatePtkpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bulanTahunId;
    protected $cacheKey;

    /**
     * Create a new job instance.
     */
    public function __construct($bulanTahunId)
    {
        $this->bulanTahunId = $bulanTahunId;
        $this->cacheKey = 'ptkp_update_progress_' . $bulanTahunId;
        
        // Initialize progress
        Cache::put($this->cacheKey, [
            'status' => 'processing',
            'total' => 0,
            'processed' => 0,
            'percentage' => 0,
            'message' => 'Memulai update PTKP...'
        ], now()->addHours(1));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Get total count first
            $total = Pajak::where('bulan_tahun_id', $this->bulanTahunId)->count();
            
            // Update initial progress
            Cache::put($this->cacheKey, [
                'status' => 'processing',
                'total' => $total,
                'processed' => 0,
                'percentage' => 0,
                'message' => "Ditemukan {$total} data untuk diupdate..."
            ], now()->addHours(1));

            if ($total === 0) {
                Cache::put($this->cacheKey, [
                    'status' => 'completed',
                    'total' => 0,
                    'processed' => 0,
                    'percentage' => 100,
                    'message' => 'Tidak ada data yang perlu diupdate'
                ], now()->addHours(1));
                return;
            }

            // Process in chunks to avoid memory issues
            $chunkSize = 100;
            $processed = 0;

            Pajak::where('bulan_tahun_id', $this->bulanTahunId)
                ->chunkById($chunkSize, function ($pajaks) use (&$processed, $total) {
                    foreach ($pajaks as $pajak) {
                        // Get PTKP data
                        $ptkp = Ptkp::where('nip', $pajak->nip)->first();
                        
                        // Update PTKP status
                        $pajak->status_ptkp = $ptkp ? $ptkp->ptkp : null;
                        $pajak->save();
                        
                        $processed++;
                        
                        // Update progress every 10 records
                        if ($processed % 10 === 0 || $processed === $total) {
                            $percentage = round(($processed / $total) * 100, 2);
                            Cache::put($this->cacheKey, [
                                'status' => 'processing',
                                'total' => $total,
                                'processed' => $processed,
                                'percentage' => $percentage,
                                'message' => "Memproses {$processed} dari {$total} data..."
                            ], now()->addHours(1));
                        }
                    }
                }, 'id');

            // Mark as completed
            Cache::put($this->cacheKey, [
                'status' => 'completed',
                'total' => $total,
                'processed' => $total,
                'percentage' => 100,
                'message' => "Berhasil mengupdate {$total} data PTKP!"
            ], now()->addHours(1));

        } catch (\Exception $e) {
            // Mark as failed
            Cache::put($this->cacheKey, [
                'status' => 'failed',
                'total' => Cache::get($this->cacheKey)['total'] ?? 0,
                'processed' => Cache::get($this->cacheKey)['processed'] ?? 0,
                'percentage' => Cache::get($this->cacheKey)['percentage'] ?? 0,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], now()->addHours(1));
            
            throw $e;
        }
    }
}