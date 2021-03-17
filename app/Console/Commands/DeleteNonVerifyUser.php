<?php

namespace App\Console\Commands;

use App\Models\ChannelActivation;
use App\Models\UserIdentity;
use App\Models\UserInvitation;
use Illuminate\Console\Command;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;

class DeleteNonVerifyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is used to delete non verify user after 5 minutes';

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
        try {
            DB::beginTransaction();
            $date = new DateTime;
            $date->modify('-5 minutes');
            $formattedDate = $date->format('Y-m-d H:i:s');
            $obj = User::where('otp_send_time', '<=', $formattedDate)
                ->where('is_verify', '=', 0)
                ->where('user_type', '!=', 1)
                ->first();
            if (!empty($obj)) {
                $objId = $obj->id;
                UserInvitation::where('user_id', $objId)->delete();
                UserIdentity::where('user_id', $objId)->delete();
                ChannelActivation::where('user_id', $objId)->delete();
                $obj->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
