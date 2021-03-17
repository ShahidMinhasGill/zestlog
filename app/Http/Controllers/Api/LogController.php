<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\BlockUser;
use App\Models\LogPrivacy;
use App\Models\UserBlock;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

use Monolog\Handler\SyslogUdp\UdpSocket;
use Validator;
use App\User;
use App\Traits\ZestLogTrait;
use App\Models\Log;
use App\Models\LogCategory;
use App\Models\UserFollower;
use Intervention\Image\Facades\Image;

class LogController extends Controller
{
    use ZestLogTrait;

    
     /**
     * add log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function addLog(Request $request)
    {
        ini_set('max_execution_time', '0');
        try {
            DB::beginTransaction();
            $this->setUserId($request);
            $userId = $this->userId;
            $arr = [];
            if (!empty($request->input('log_pic'))) {
                $destinationPath = public_path(MobileUserLogImagePath) . '/' . $userId;
                $arr['log_pic'] = $this->uploadFile($request, $destinationPath);
            }
            $objLog = new Log();
            $objLog->user_id = $userId;
            $objLog->log_pic = $arr['log_pic'];
            $objLog->save();
            $this->message = Lang::get('messages.logUpdateSuccess');
            $this->success = true;
            $this->data['log_id'] = $objLog->id;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    public function addLogDetails(Request $request){
        try {
            DB::beginTransaction();
            $this->setUserId($request);
            $logId = $request->input('log_id');
            $privacy = $request->input('privacy');
            $description = $request->input('description');
            $logCategoryId = $request->input('log_category_id');
            $logObj = Log::where('id', $logId)->first();
            if (empty($logObj)) {
                $logObj = new Log();
                $logObj->user_id = $this->userId;
            }
            $logObj->privacy = $privacy;
            $logObj->description = $description;
            $logObj->log_category_id = $logCategoryId;
            $logObj->save();
            User::where('id', $logObj->user_id)->update(['last_log_created_at' => currentDateTime()]);
            $this->message = Lang::get('messages.logUpdateSuccess');
            $this->success = true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json(['success' => $this->success,'message' => $this->message], $this->statusCode);
    }
     /**
     * edit log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function editLog(Request $request){
        $this->setUserId($request);
        $userId = $this->userId;
        $obj = User::find($userId);
        if ($obj) {
            $logObj = Log::where(['id' => $request->input('log_id')])->first();
            if ($logObj) {
                $this->saveLog($request, $logObj);
                $this->success = true;
                $this->statusCode = $this->successCode;
            }else {
                $this->message = Lang::get('messages.logInvalid');
            }
        }else {
            $this->message = Lang::get('messages.userInvalid');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * get log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getLog($id){
        $logObj = Log::select('logs.id','logs.user_id','logs.log_pic','logs.description','lp.name as privacy',
            'is_deleted','logs.meta_data','logs.meta_description','logs.created_at','logs.updated_at')
            ->where(['logs.id' => $id])
            ->join('log_privacies as lp','lp.id','=','logs.privacy')
            ->first();

        if (!empty($logObj)) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            if (!empty($logObj->log_pic)) {
                $logObj->log_pic = asset(MobileUserLogImagePath) . '/' . $logObj->user_id . '/' . $logObj->log_pic;
            } else {
                $logObj->log_pic = null;
            }
            
            $this->data['log'] = $logObj;
        }else {
            $this->message = Lang::get('messages.logInvalid');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * get user log
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getUserLog($uid){
        $join = 'join';
        if(isLightVersion()){
            $join = 'leftjoin';
        }
        $logUrl = asset(MobileUserLogImagePath);
        $userProfileUrl = asset(MobileUserImagePath);
        $logObj = Log::select('logs.id', 'logs.user_id','u.first_name','u.last_name','u.user_name','u.profile_pic_upload', 'logs.log_pic',
            'logs.description', 'logs.privacy as privacy_id', 'lp.name as privacy',
            'logs.log_category_id','lc.name as category','u.is_identity_verified',
            'logs.is_deleted', 'logs.meta_data', 'logs.meta_description', 'logs.created_at', 'logs.updated_at',
            DB::raw("CONCAT('$userProfileUrl','/',u.profile_pic_upload) as profile_pic_upload"),
            DB::raw("CONCAT('$logUrl','/',logs.user_id,'/',logs.log_pic) as log_pic")
            )
            ->join('log_privacies as lp', 'lp.id', '=', 'logs.privacy')
            ->join('users as u', 'u.id', '=', 'logs.user_id')
            ->$join('log_categories as lc', 'lc.id', '=', 'logs.log_category_id')
            ->where(['logs.user_id' => $uid])
            ->where(['logs.is_deleted' => 0])
            ->orderby('id', 'desc')
            ->get();
        if (!empty($logObj)) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->data['log'] = $logObj;
        }else {
            $this->message = Lang::get('messages.logInvalid');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
     /**
     * save log data
     * @param type $request
     * @return boolean
     */
    public function saveLog($request, $logObj){
        $input = $request->all();
        $this->statusCode = $this->errorCode;
        $userId = $request->input('user_id');
        $validations = [
            'user_id' => 'required|integer',
            'privacy' => 'required',
//            'log_category_id' => 'required|integer',
        ];
        $validator = \Validator::make($input, $validations);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            if (!empty($request->input('log_pic'))){
                if (!empty($logObj->log_pic)) {
                    $Path = MobileUserLogImagePath . '/' . $userId . '/' . $logObj->log_pic;
                    if (file_exists($Path)) {
                        unlink($Path);
                    }
                }
                $destinationPath = public_path(MobileUserLogImagePath) . '/' . $userId;
                $logObj->log_pic = $this->uploadFile($request, $destinationPath);
            }
            $logObj->user_id = $userId;
            $logObj->description = $request->input('description');
            $logObj->privacy = strtolower($request->input('privacy'));
            $logObj->log_category_id = $request->input('log_category_id');
            $logObj->is_deleted = 0;

            if(!empty($request->input('log_id'))){
                $logObj->id = $request->input('log_id');
                $this->message = Lang::get('messages.logUpdateSuccess');
            }else{
                $this->message = Lang::get('messages.logAddSuccess');
            }
            $this->success = true;
            $logObj->save();
        }
        return true;
    }
    /**
     * 
     * @param type $request
     * @param type $columName
     * @return string
     */
    public function uploadFile($request, $destinationPathNew)
    {
        $data = base64_decode(preg_replace('/^data:image\/\w+;base64,/i', '', $request->input('log_pic')));
        $fileName = createImageUniqueName('jpg');
        $destinationPath = public_path(MobileUserLogImagePathTemp);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $tempFile = $destinationPath . '/' . $fileName;
        file_put_contents($tempFile, $data);
        $imagePath = $tempFile;
        ini_set('memory_limit', '1024M');
        list($this->originalImageWidth, $this->originalImageHeight) = getimagesize($imagePath);
        $this->requiredImageHeight = ($this->originalImageHeight - ($this->originalImageHeight) * 0.375);
        $this->requiredImageWidth = ($this->originalImageWidth - ($this->originalImageWidth) * 0.375);
        $this->calculateImageDimension();
        $ImageUpload = Image::make($imagePath);
        if (!file_exists($destinationPathNew)) {
            mkdir($destinationPathNew, 0777, true);
        }
        $ImageUpload->resize($this->newImageHeight, $this->newImageWidth, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPathNew . '/' . $fileName);
        unlink($tempFile);

        return $fileName;
    }

    /**
     * get log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getLogCategories(){
        $logCategoryObj = LogCategory::select('id','name')->where(['is_deleted' => 0])->get()->toArray();
        $arr[] = ['id'=>'','name'=>'All'];
        $withoutAllCategories = $logCategoryObj;
        $logCategoryObj = array_merge($arr,$logCategoryObj);
        if (!empty($logCategoryObj)) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->data['log_categories_all'] = $logCategoryObj;
            $this->data['log_categories'] = $withoutAllCategories;
        }else {
            $this->message = Lang::get('messages.logCategoryInvalid');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
    
    /**
     * get all logs and filter by category api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getAllLogs(Request $request,$authuid = "", $categoryid = ""){
        if (!empty($authuid)) {
            $perPage = 10;
            if (!empty($request->input('per_page')))
                $perPage = $request->input('per_page');
            $followers = UserFollower::select('following')
                ->where('follower', $authuid)
                ->get()->toArray();

            $blockUsers = UserBlock::select('block_user_id')
                ->where('user_id', $authuid)
                ->get()->toArray();
            $blockUsers =  array_column($blockUsers, 'block_user_id');

            $blocked = UserBlock::select('user_id')
                ->where('block_user_id', $authuid)
                ->get()->toArray();
            $blocked = array_column($blocked, 'user_id');
            $blockUsers = array_merge($blockUsers, $blocked);

            $followers = array_column($followers, 'following');
            $followers[]= (int)$authuid;
            $logUrl = asset(MobileUserLogImagePath);
            $userProfileUrl = asset(MobileUserImagePath);
            if (empty($categoryid)) {
                $logObj = Log::select('users.first_name', 'users.last_name', 'logs.id as log_id', 'logs.user_id',
                    'logs.log_pic', 'logs.description', 'logs.privacy as privacy_id', 'lp.name as privacy', 'logs.log_category_id', 'users.is_identity_verified',
                    'logs.is_deleted', 'logs.created_at', 'logs.updated_at', 'is_username_public',
                    DB::raw("CONCAT('$userProfileUrl','/',users.profile_pic_upload) as user_profile_pic"),
                    DB::raw("CONCAT('$userProfileUrl','/',users.profile_pic_upload) as profile_pic_upload"),
                    DB::raw("CONCAT('$logUrl','/',logs.user_id,'/',logs.log_pic) as log_pic"),
                    DB::raw("DATE_FORMAT(logs.updated_at, '%d %b %Y at %H:%i') as logupdate_at"),
                    DB::raw('(CASE WHEN users.is_username_public = "0" THEN "" ELSE users.user_name END) AS user_name')
                )
                    ->join('users', 'users.id', '=', 'logs.user_id')
                    ->join('log_privacies as lp', 'lp.id', '=', 'logs.privacy')
                    ->where('users.status', 1)
                    ->where('privacy', '<>', 3)
                    ->where(['is_deleted' => 0])
                    ->whereIn('logs.user_id', $followers, 'AND')
                    ->whereNotIn('logs.user_id', $blockUsers)
                    ->orderby('logs.created_at', 'desc')
                    ->paginate($perPage)->setPageName('page');
            } else {
                $logObj = Log::select('users.first_name', 'users.last_name', 'users.user_name', 'logs.id as log_id', 'logs.user_id',
                    'logs.log_pic', 'logs.description', 'logs.privacy as privacy_id', 'lp.name as privacy', 'logs.log_category_id', 'users.is_identity_verified',
                    'logs.is_deleted', 'logs.created_at', 'logs.updated_at', 'is_username_public',
                    DB::raw("CONCAT('$userProfileUrl','/',users.profile_pic_upload) as user_profile_pic"),
                    DB::raw("CONCAT('$userProfileUrl','/',users.profile_pic_upload) as profile_pic_upload"),
                    DB::raw("CONCAT('$logUrl','/',logs.user_id,'/',logs.log_pic) as log_pic"),
                    DB::raw("DATE_FORMAT(logs.updated_at, '%d %b %Y at %H:%i') as logupdate_at"),
                    DB::raw('(CASE WHEN users.is_username_public = "0" THEN "" ELSE users.user_name END) AS user_name')
                )
                    ->join('users', 'users.id', '=', 'logs.user_id')
                    ->join('log_privacies as lp', 'lp.id', '=', 'logs.privacy')
                    ->where('users.status', 1)
                    ->where('privacy', '<>', 3)
                    ->where(['is_deleted' => 0])
                    ->where('log_category_id', '=', $categoryid)
                    ->whereIn('logs.user_id', $followers, 'AND')
                    ->whereNotIn('logs.user_id', $blockUsers)
                    ->orderby('logs.created_at', 'desc')
                    ->paginate($perPage)->setPageName('page');
            }

            if(!empty($logObj)){
                $logObj = $logObj->toArray();
            }

            $arr = [];
            $arr['log'] = $logObj['data'];
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->data = $arr;
        } else {
            $this->success = false;
            $this->message = 'User Id is required';
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * delete log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function deleteLog(Request $request){
        $this->setUserId($request);
        $userId = $this->userId;
        $logId = $request->input('log_id');
        $objLog = Log::select('log_pic')->where(['id' => $logId, 'user_id' => $userId])->first();
        if ($objLog) {
            if (!empty($objLog->log_pic)) {
                $Path = MobileUserLogImagePath . '/' . $userId . '/' . $objLog->log_pic;
                if (file_exists($Path)) {
                    unlink($Path);
                }
            }
            Log::where(['id' => $logId, 'user_id' => $userId])->delete();
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.deletelog');
        } else {
            $this->message = Lang::get('messages.logInvalid');
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * delete log api
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getFilterLog(Request $request)
    {
        $perPage = 10;
        if (!empty($request->input('per_page')))
            $perPage = $request->input('per_page');
        $this->setUserId($request);
        $userId = $this->userId;
        $categoryId = $request->input('log_category_id');
        $followers = UserFollower::select('following')
            ->where('follower', $userId)
            ->get()->toArray();
        $blockUser = UserBlock::select('block_user_id')
            ->where('user_id', $userId)
            ->get()->toArray();
        $blockUser = array_column($blockUser, 'block_user_id');

        $blocked = UserBlock::select('user_id')
            ->where('block_user_id', $userId)
            ->get()->toArray();
        $blocked = array_column($blocked, 'user_id');
        $blockUser = array_merge($blockUser, $blocked);

        $followers = array_column($followers, 'following');
        $followers = array_merge($blockUser,$followers);
        $logUrl = asset(MobileUserLogImagePath);
        $userProfileUrl = asset(MobileUserImagePath);
        if (empty($categoryId)) {
            $logObj = Log::select('logs.id as log_id', 'u.id', 'u.first_name', 'u.last_name', 'logs.user_id',
                 'logs.description', 'logs.privacy as privacy_id', 'lp.name as privacy', 'logs.log_category_id', 'u.is_identity_verified',
                'logs.is_deleted', 'logs.created_at','u.is_username_public',
                DB::raw("CONCAT('$userProfileUrl','/',u.profile_pic_upload) as profile_pic_upload"),
                DB::raw("CONCAT('$userProfileUrl','/',u.profile_pic_upload) as user_profile_pic"),
                DB::raw("CONCAT('$logUrl','/',logs.user_id,'/',logs.log_pic) as log_pic"),
                DB::raw("DATE_FORMAT(logs.updated_at, '%d %b %Y at %H:%i') as logupdate_at"),
                DB::raw('(CASE WHEN u.is_username_public = "0" THEN "" ELSE u.user_name END) AS user_name')

            )
                ->join('users as u', 'u.id', '=', 'logs.user_id')
                ->join('log_privacies as lp', 'lp.id', '=', 'logs.privacy')
                ->where('logs.user_id', '!=', $userId)
                ->where('u.status', 1)
                ->where('privacy', '=', 1)
                ->where(['is_deleted' => 0])
                ->whereNotIn('logs.user_id', $followers)
                ->whereNotIn('logs.user_id', $blockUser)
                ->orderby('logs.created_at', 'desc')
                ->paginate($perPage)->setPageName('page');
        } else {
//            bbbb
            $logObj = Log::select('logs.id as log_id', 'u.id', 'u.first_name', 'u.last_name', 'logs.user_id',
                'logs.description', 'logs.privacy as privacy_id', 'lp.name as privacy', 'logs.log_category_id', 'u.is_identity_verified',
                'logs.is_deleted', 'logs.created_at','u.is_username_public',
                DB::raw("CONCAT('$userProfileUrl','/',u.profile_pic_upload) as user_profile_pic"),
                DB::raw("CONCAT('$userProfileUrl','/',u.profile_pic_upload) as profile_pic_upload"),
                DB::raw("CONCAT('$logUrl','/',logs.user_id,'/',logs.log_pic) as log_pic"),
                DB::raw("DATE_FORMAT(logs.updated_at, '%d %b %Y at %H:%i') as logupdate_at"),
                DB::raw('(CASE WHEN u.is_username_public = "0" THEN "" ELSE u.user_name END) AS user_name')
                )
                ->join('users as u', 'u.id', '=', 'logs.user_id')
                ->join('log_privacies as lp', 'lp.id', '=', 'logs.privacy')
                ->where('logs.user_id', '!=', $userId)
                ->where('u.status', 1)
                ->where('privacy', '=', 1)
                ->where(['is_deleted' => 0])
                ->where('log_category_id', $categoryId)
                ->whereNotIn('logs.user_id', $followers)
                ->whereNotIn('logs.user_id', $blockUser)
                ->orderby('logs.created_at', 'desc')
                ->paginate($perPage)->setPageName('page');
        }
        if(!empty($logObj)){
            $logObj = $logObj->toArray();
        }
        $arr = [];
        $arr['log'] = $logObj['data'];
        $this->success = true;
        $this->statusCode = $this->successCode;
        $this->data = $arr;

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * Method to removed image
     */
    public function removeImage(Request $request){
        $log_id = $request->input('log_id');
        $logObj = Log::where('id', $log_id)->update(['log_pic'=>null]);
        if(!empty($logObj)){
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->message = Lang::get('messages.imageRemoved');
        }else{
            $this->message = Lang::get('messages.logInvalid');
        }
        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * get user log without only me
     * @param type $request
     * @return \Illuminate\Http\Response
     */
    public function getLogsWithoutMe(Request $request,$uid){
        $user1ID = 0;
        $join = 'join';
        if(isLightVersion()){
            $join = 'leftjoin';
        }
        if (!empty($request->input('user_id')))
            $user1ID = $request->input('user_id');
        $follow = false;
        $isFollower = UserFollower::where('follower',$user1ID)->where('following',$uid)->first();
        if(!empty($isFollower)){
            $follow = true;
        }
        $assetUrl = asset(MobileUserLogImagePath);
        $logObj = Log::select('logs.id', 'logs.user_id', 'logs.log_pic', 'logs.description',
            'logs.privacy as privacy_id','lp.name as privacy', 'logs.log_category_id','lc.name as category','u.is_identity_verified',
            'logs.is_deleted', 'logs.meta_data', 'logs.meta_description', 'logs.created_at', 'logs.updated_at',
            DB::raw("CONCAT('$assetUrl','/',logs.user_id,'/',logs.log_pic) as log_pic")
        )
            ->where(['user_id' => $uid])
            ->join('log_privacies as lp','lp.id','=','logs.privacy')
            ->$join('log_categories as lc', 'lc.id', '=', 'logs.log_category_id')
            ->join('users as u', 'u.id', '=', 'logs.user_id')
            ->where(['logs.is_deleted' => 0])
            ->where('privacy', '<>', 3)
            ->orderby('id', 'desc');
        if (empty($follow)) {
            $logObj->where('privacy', '<>', 2);
        }

        $logObj = $logObj->get();
        if (!empty($logObj)) {
            $this->success = true;
            $this->statusCode = $this->successCode;
            $this->data['log'] = $logObj;
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /**
     * this is used to get privacy list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrivacyList(Request $request)
    {
        $obj = LogPrivacy::select('id', 'name')->get()->toArray();
        $this->data['privacy'] = $obj;
        $this->success = true;

        return response()->json(['success' => $this->success, 'data' => $this->data], $this->statusCode);
    }
}
