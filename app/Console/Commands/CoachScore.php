<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Traits\ZestLogTrait;

class CoachScore extends Command
{
    use ZestLogTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coach:score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to update client score for ranking';

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
        $currentdate =  $currentdate->modify('-30 minutes');
        $userObj = User::select('id', 'is_3i_partner', 'is_education_verified', 'is_identity_verified', 'total_bookings', 'total_rejected_bookings',
            \DB::raw("TIMESTAMPDIFF(Day, DATE(users.created_at), current_date) AS total_days"),
            \DB::raw("TIMESTAMPDIFF(Day, DATE(users.last_log_created_at), current_date) AS latest_log_days")
        )
            ->where('user_type', 0)
            ->where('updated_at','>=', $currentdate)
            ->get()->toArray();
        $arr = [];
        foreach ($userObj as $key => $row) {
            $is3iPartnerFactor = 0;
            $isEducationVerifiedFactor = 0;
            $isIdentityVerifiedFactor = 0;
            $activeDaysFactor = 0;
            $rejectBookingsFactor = 0;
            if ($row['is_3i_partner'] == 1) {
                $is3iPartnerFactor = 1;
            }
            if ($row['is_education_verified'] == 1) {
                $isEducationVerifiedFactor = 1;
            }
            if ($row['is_identity_verified'] == 1) {
                $isIdentityVerifiedFactor = 1;
            }
            if ($row['latest_log_days'] === 0) {
                $row['latest_log_days'] = 1;
            }
            if ($row['total_days'] === 0) {
                $row['total_days'] = 1;
            }

            if (!empty($row['latest_log_days'])) {
                $activeDaysFactor = round(($row['latest_log_days'] / $row['total_days']), 3);
            }
            if (!empty($row['total_bookings']) && !empty($row['total_rejected_bookings'])) {
                $rejectBookingsFactor = ($row['total_rejected_bookings'] / $row['total_bookings']);
            }
            $totalAcceptedBookings = $row['total_bookings'] - $row['total_rejected_bookings'];

            $totalBookingsFactor = $this->bookingsFactorConditions($totalAcceptedBookings);
            if(isLightVersion()){
                $is3iPartnerFactor = ($is3iPartnerFactor * 0);
                $isEducationVerifiedFactor = ($isEducationVerifiedFactor * 0.30);
                $isIdentityVerifiedFactor = ($isIdentityVerifiedFactor * 0.10);
                $activeDaysFactor = ($activeDaysFactor * 0);
                $totalBookingsFactor = ($totalBookingsFactor * 0.60);

                $rejectBookingsFactor = ($rejectBookingsFactor * 0); // to decrease upto 50 %, will change later
            }else{
                $is3iPartnerFactor = ($is3iPartnerFactor * 0.40);
                $isEducationVerifiedFactor = ($isEducationVerifiedFactor * 0.15);
                $isIdentityVerifiedFactor = ($isIdentityVerifiedFactor * 0.1);
                $activeDaysFactor = ($activeDaysFactor * 0);
                $totalBookingsFactor = ($totalBookingsFactor * 0.35);

                $rejectBookingsFactor = ($rejectBookingsFactor * 0.5); // to decrease upto 50 %, will change later
            }

            $totalScore = ($is3iPartnerFactor + $isEducationVerifiedFactor + $isIdentityVerifiedFactor + $activeDaysFactor + $totalBookingsFactor);
            $totalScore = ($totalScore - $rejectBookingsFactor);
            $arr[$key]['id'] = $row['id'];
            $arr[$key]['coach_score'] = $totalScore;
        }

        $userInstance = new User;
        \Batch::update($userInstance, $arr, 'id');
    }
}
