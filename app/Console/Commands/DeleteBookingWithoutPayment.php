<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\FinalPayment;
use App\Models\ClientPlan;
use App\Models\Client\ClientWeekPlan;
use DateTime;

class DeleteBookingWithoutPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to delete old booking data which payment is not done.It will delete records after 60 minute if payment is not done';

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
        $date = new DateTime;
        $date->modify('-60 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $sql = \DB::table('bookings as b')
            ->select('b.unique_id')
            ->where(function($query) {
                /** @var $query Illuminate\Database\Query\Builder  */
                return $query->where('b.is_payment', 0) // did not payment
                    ->orWhere('b.is_payment', 2); // payment refund
            })
            ->where('b.created_at', '<=', $formatted_date);
        $record =  $sql->get();
        try {
            \DB::beginTransaction();
            if (!empty($record)) {
                $record = array_column($record->toArray(), 'unique_id');
                // delete record from bookings table
                $clientPlans = ClientPlan::select('id')->whereIn('unique_id', $record)->get();
                Booking::whereIn('unique_id', $record)->delete();
                FinalPayment::whereIn('unique_id', $record)->delete();
                ClientPlan::whereIn('unique_id', $record)->delete();
                if (!empty($clientPlans)) {
                    ClientWeekPlan::whereIn('client_plan_id', array_column($record, 'id'))->delete();
                }
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }
}
