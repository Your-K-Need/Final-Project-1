<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Image;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the information of seller account that have
     * been registered
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        // return 'test';
        $request->validate(
            [
                'name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|unique:sellers,email,'.$seller->id,
                'description' => 'required',
                'province' => 'required',
                'username' => 'required',
            ], [],
            [
                'name' => 'Name',
                'phone_number' => 'Phone Number',
                'email' => 'Email',
                'description' => 'Description',
                'province' => 'Province',
                'username' => 'Username',
            ]);

        DB::beginTransaction();
        try{
            /**
             * function for the seller to choose the 
             * foto profile for their account
             */
            if ($request->hasFile('avatar')) {
                $path = public_path('upload/seller/avatar/');
                if(!File::isDirectory($path)){
                    File::makeDirectory($path, 0777, true, true);
                }

                if ($request->file('avatar')->isValid()) {
                    $request->validate(
                        [
                        'avatar' => 'mimes:jpeg,png|max:10240',
                        ], [],
                        [
                        'avatar' => 'Seller Avatar'
                        ]);
                    $image = $request->file('avatar');
                    $image_name = time().'.'.$image->extension();

                    $img = Image::make($image->path());
                    $img->resize(200, 200, function ($const) {
                        $const->aspectRatio();
                    })->save($path.''.$image_name);

                    if($seller->avatar != ''  && $seller->avatar != null){
                        $file_old = $path.$seller->avatar;
                        if(file_exists($file_old)){
                            unlink($file_old);
                        }
                    }

                    $seller->update(['avatar' => $image_name]);
                }
            }
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
                $seller->update($request->all());
            }else{
                $seller->update($request->except(['avatar', 'password']));
            }

            DB::commit();
            return redirect()->route('seller.profile')->with(['msg' => ['type' => 'success', 'msg' => 'Data ' . $seller->name . ' updated successfully']]);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->back()->with(['msg' => ['type' => 'error', 'msg' => $ex->getMessage()]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }

    public function profile() {
        $data = auth()->guard('seller')->user();
        return view('seller.profile', compact('data'));
    }
}
