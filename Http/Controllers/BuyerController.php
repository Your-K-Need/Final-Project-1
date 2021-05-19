<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Image;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer){
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function edit(Buyer $buyer){
        //
    }
    /**
     * Update the information about buyer include
     * name, phone number, e-mail, province, username
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer)
    {
        $request->validate(
            [
                'name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|unique:buyers,email,'.$buyer->id,
                'province' => 'required',
                'username' => 'required',
            ], [],
            [
                'name' => 'Name',
                'phone_number' => 'Phone Number',
                'email' => 'Email',
                'province' => 'Province',
                'username' => 'Username',
            ]);

        DB::beginTransaction();
        try{
            /**
             * the condition for buyer by change the foto profile
             * in their account and the new update data will saved in
             * database system
             */
            if ($request->hasFile('avatar')) {
                $path = public_path('upload/buyer/avatar/');
                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }
                if ($request->file('avatar')->isValid()) {
                    $request->validate(
                        [
                        'avatar' => 'mimes:jpeg,png|max:10240',
                        ], [],
                        [
                        'avatar' => 'Buyer Avatar'
                        ]);
                    $image = $request->file('avatar');
                    $image_name = time().'.'.$image->extension();

                    $img = Image::make($image->path());
                    $img->resize(200, 200, function ($const) {
                        $const->aspectRatio();
                    })->save($path.''.$image_name);

                    if($buyer->avatar != ''  && $buyer->avatar != null){
                        $file_old = $path.$buyer->avatar;
                        if(file_exists($file_old)){
                            unlink($file_old);
                        }
                    }

                    $buyer->update(['avatar' => $image_name]);
                }
            }

            /**
             * the condition if buyer want to reset the password
             * the updated data will saved in the database system
             */
            if($request->password && $request->password_confirmation){
                $request->validate(
                    [
                        'password' => 'required|confirmed',
                        'password_confirmation' => 'required',
                    ], [],
                    [
                        'password' => 'Password',
                        'password_confirmation' => 'Password Confirmation',
                    ]);
                $buyer->update($request->all());
            }else{
                $buyer->update($request->except(['avatar', 'password']));
            }

            DB::commit();
            return redirect()->route('buyer.profile')->with(['msg' => ['type' => 'success', 'msg' => 'Data ' . $buyer->name . ' updated successfully']]);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->back()->with(['msg' => ['type' => 'error', 'msg' => $ex->getMessage()]]);
        }
    }

    /**
     * Remove the data from the storage
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buyer $buyer)
    {
        //
    }
    /**
     * function for view the profile buyer
     */
    public function profile() {
        $data = auth()->guard('buyer')->user();
        return view('buyer.profile', compact('data'));
    }
}
