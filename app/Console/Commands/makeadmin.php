<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class makeadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:makeadmin {email}';

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
        $email = $this->argument('email');
        $user = User::where('email', $email . '@gmail.com')->first();
        if ($user) {
            $user->is_admin = true;
            $user->save();
            $this->info($email . ' is now an admin');
            return;
        } 

        $this->warn('User not found');
    }
}
