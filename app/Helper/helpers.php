<?php

use App\Models\COA;
use Carbon\Carbon;
use App\Models\Skpd;


function nextMonth($bulan, $tahun)
{
    Carbon::setLocale('id');
    $bulanMapping = [
        'Januari' => 'January',
        'Februari' => 'February',
        'Maret' => 'March',
        'April' => 'April',
        'Mei' => 'May',
        'Juni' => 'June',
        'Juli' => 'July',
        'Agustus' => 'August',
        'September' => 'September',
        'Oktober' => 'October',
        'November' => 'November',
        'Desember' => 'December',
    ];

    $bulanInggris = $bulanMapping[$bulan] ?? null;

    // Buat objek Carbon dari data bulan dan tahun
    $date = Carbon::createFromFormat('F Y', "$bulanInggris $tahun");

    // Tambahkan satu bulan
    $dateNextMonth = $date->addMonth();

    // Format hasil
    return strtoupper($dateNextMonth->translatedFormat('F Y')); // Output: Januari 2025
}
function bulan()
{
    Carbon::setLocale('id');
    // Array untuk menyimpan nama bulan
    $namaBulan = [];

    // Loop untuk mendapatkan nama semua bulan
    for ($i = 1; $i <= 12; $i++) {
        $namaBulan[] = Carbon::createFromDate(2024, $i, 1)->translatedFormat('F');
    }

    return $namaBulan;
}
function skpd()
{
    return Skpd::get();
}

function coa()
{
    return COA::get();
}
