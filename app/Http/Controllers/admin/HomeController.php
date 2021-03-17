<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use Intervention\Image\Facades\Image as Image;
use App\User;
use App\Traits\ZestLogTrait;
class HomeController extends Controller
{
    use ZestLogTrait;

    public function index()
    {
        return view('admin.dashboard.index');
    }
    public function edit($id)
    {
//        $data =  $this->editProfiles($id,adminImagePath);
        $user  =User::find($id);
        $countries = (!empty($user->country) ? $user->country : null);
        $cities = (!empty($user->city) ? $user->city : null);
        $rout = 'admin.update';
        return view('admin.home', compact('user', 'countries', 'cities','rout'));
    }

    public function update(Request $request, $id)
    {
        $this->updateProfiles($request,$id,adminImagePath);
        return redirect()->route('admin.edit', $id);
    }
}
