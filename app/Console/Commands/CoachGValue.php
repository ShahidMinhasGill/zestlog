<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CoachGValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:value';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This comand is used to update partners G value after 14 days of sign up';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentdate = new \DateTime();
        $currentdate = $currentdate->modify('-14 day');
        User::where('user_type', 0)
            ->where('is_3i_partner', 0)
            ->where('created_at', '<', $currentdate)
            ->where('client_g_value', 1)
            ->update(['client_g_value' => 0.95]);
    }
}
