<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Video;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('Video')->get();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id',$id)->with('Video')->first();
        return response()->json([ 'user'=>$user]);
        // $business = Business::where('id',$id)->with('Food')->get();
        // return response()->json([ 'business'=>$business]);}
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = $request->file('avatar');
        $path = Storage::disk('public')->put('user', $image);

        $image = $request->file('cover');
        $path = Storage::disk('public')->put('user', $image);
       

        $data=$request->all();
        $user=User::where('id',$id)->first();
        $user->firstName=$data['firstName'];
        $user->lastName=$data['lastName'];
        $user->userName=$data['userName'];
        $user->email=$data['email'];
        $user->password=$data['password'];
        $user->avatar= $path;
        $user->cover= $path;

        // $user->avatar=$data['avatar'];
        // $user->cover=$data['cover'];
        $user->channelDescription=$data['channelDescription'];


        $user->save();
        return response()->
        json([
            'status'=>200,
            'user'=>$user

        ]);  
     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }
}