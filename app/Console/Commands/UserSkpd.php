<?php

namespace App\Console\Commands;

use App\Models\Skpd;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserSkpd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-skpd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat User Untuk SKPD';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $skpd = Skpd::get();
        foreach ($skpd as $s) {
            $check = User::where('username', $s->kode)->first();
            if ($check == null) {
                $save = new User();
                $save->name = $s->nama;
                $save->username = $s->kode;
                $save->password = Hash::make('adminskpd');
                $save->skpd_id = $s->id;
                $save->roles = 'admin';
                $save->save();
            } else {
            }
        }
    }
}
