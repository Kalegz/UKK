<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-role-command';

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
        $userId = $this->ask('Masukkan ID pengguna');
        $user = User::find($userId);
    
        if ($user) {
            $user->assignRole('admin');
            $this->info('Role admin berhasil diberikan ke user dengan ID: ' . $userId);
        } else {
            $this->error('Pengguna tidak ditemukan');
        }
    }
}
