<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

use Validator;
use App\Exercise;

class ExerciseController extends Controller
{
    public $statusCode = 401;
    private $successCode = 200;
    private $errorCode = 401;
    private $data = [];
    private $success = false;
    private $message = '';

    /** 
     * user exercise info 
     * 
     * @param    exercise id
     * @return exercise data 
     */
    public function exerciseData($id)
    {
        if ($id){
            $resultData=Exercise::find($id);
            if ($resultData) {
                $this->data['data'] = $resultData;
                $this->success = true;
                $this->statusCode = $this->successCode;
            } else {
                $this->statusCode = $this->errorCode;
                $this->message = Lang::get('messages.resultNotFound');
            }
        } else { 
            $this->message = Lang::get('messages.reqiredFiledError',['filedName' => 'ID']);
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }

    /** 
     * user personal info Update 
     * 
     * @param    user id
     * @return user data 
     */
    public function exerciseDataUpdate(Request $request)
    {
        $id = $request->id;
        if ($id){
            $userData=Exercise::find($id);
            if ($userData) {
                $dataArray = $request->all();
                $userData->update($dataArray);
                $this->data['userData'] = $userData;
                $this->success = true;
                $this->statusCode = $this->successCode;
                $this->message = Lang::get('messages.recordUpdatedSuccess');
            } else {
                $this->statusCode = $this->errorCode;
                $this->message = Lang::get('messages.resultNotFound');
            }
        } else { 
            $this->message = Lang::get('messages.reqiredFiledError',['filedName' => 'ID']);
        }

        return response()->json(['success' => $this->success, 'data' => $this->data, 'message' => $this->message], $this->statusCode);
    }
}