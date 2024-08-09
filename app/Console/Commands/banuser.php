<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class banuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:banuser {email} {--remove}';

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
        $ban = $this->option('remove') ? false : true;
        $user = User::where('email', $email . '@gmail.com')->first();
        if ($user) {
            $user->is_banned = $ban;
            $user->save();
            $this->info($email . ' is now ' . ($ban ? 'banned' : 'unbanned'));
            return;
        } 

        $this->warn('User not found');
    }
}
