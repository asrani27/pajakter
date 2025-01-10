<?php

use App\Models\COA;
use Carbon\Carbon;
use App\Models\Skpd;


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
