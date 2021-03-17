<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public $statusCode = 401;
    private $successCode = 200;
    private $errorCode = 401;
    private $data = [];
    private $success = false;
    private $message = '';
}