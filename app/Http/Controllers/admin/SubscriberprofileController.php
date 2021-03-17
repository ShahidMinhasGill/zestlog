<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use App\User;
use App\Traits\ZestLogTrait;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Input;

class SubscriberprofileController extends Controller
{
    use ZestLogTrait;
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->editProfiles($id, subscriberImagePath);
        $user = $data[0];$countries = $data[1];$cities = $data[2];$rout = 'subscriber-profile.update';
        return view('admin.home', compact('user', 'countries', 'cities','rout'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->updateProfiles($request,$id,subscriberImagePath);
        return redirect()->route('freelance-specialists.index');
    }
}
