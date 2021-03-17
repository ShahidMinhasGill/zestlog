<?php

namespace App\Http\Controllers;

use App\Models\UserInvitation;
use App\User;
use DateTime;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;
use App\Traits\ZestLogTrait;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    use ZestLogTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**userInvitation
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $sid    = env( 'TWILIO_SID' );
//        $token  = env( 'TWILIO_AUTH_TOKEN' );
//        $client = new Client( $sid, $token );
//
//        $number = '+923347752039';
//        $client->messages->create(
//            $number,
//            [
//                'from' => env( 'TWILIO_NUMBER' ),
//                'body' => 888,
//            ]
//        );

        $user = User::find(loginId());
        $user = $user->toArray();
        $userId = loginId();
        $userInvitation = UserInvitation::select('invitation_code', 'u.created_at', 'u.is_3i_partner')
            ->where('user_id', $userId)
            ->join('users as u', 'u.id', '=', 'user_invitations.user_id')
            ->first();
        $userDetails = [];
        $days = '';
        $is3iPartner = '';
        if(!empty($userInvitation))
        {
            $is3iPartner = $userInvitation->is_3i_partner;
            $userSignupDate = new DateTime(date_format(new \DateTime($userInvitation->created_at), 'Y-m-d h:i:s'));
            $interval = $userSignupDate->diff(new DateTime());
            $days = $interval->format('%a');
            $days = 14 - $days;
            $userDetails = User::select('users.first_name', 'users.user_name', 'users.is_coach_channel', 'ca.is_verify', 'users.id')
                ->join('channel_activations as ca', 'ca.user_id', '=', 'users.id')
                ->join('user_invitations as ui', 'ui.user_id', '=', 'users.id')
                ->where('ca.specialization_number', 1)
                ->where('ui.invited_user_id', $userId)
                ->get()->toArray();
        }

        return view('home',compact('userInvitation','userDetails','days','is3iPartner','user'));
    }

    public function test()
    {
        ini_set('memory_limit', '1024M');
        $image = public_path('uploads/1.jpg');
        list($this->originalImageWidth, $this->originalImageHeight) = getimagesize($image);

        $this->calculateImageDimension();
        $ImageUpload = Image::make($image);
        $savePath = public_path('/uploads');

        $ImageUpload->resize($this->newImageHeight,$this->newImageWidth,function ($constraint) {
            $constraint->aspectRatio();
                $constraint->upsize();
        })->save($savePath . '/' . '2.jpg');

    }

    public function iPartner(Request $request){
        $view = view('3ipartner')->render();
        return response()->json(['success' => true, 'message' => $this->message, 'view' => $view]);

    }

}
