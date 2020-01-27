<?php

namespace App\Http\Controllers;

use App\DataUser;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Hashids\Hashids;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;

class TestController extends Controller
{
    public function ambildata(Request $request){
        $id = $request->input('id');
        $results = DataUser::select('id', 'name', 'image', 'mail', 'imagename')
        ->where('id', $id)
        ->get();

        return response()->json($results);

    }

    public function upload(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $mail = $request->input('mail');
        $image = $request->file(['image']);
        foreach ($image as $img){
            $avatar = Str::random(5);
            $file = $img->move(storage_path('avatar'), $avatar . '.'.$img->getClientOriginalExtension());
            $result = DataUser::where('id', $id)->first();
            if($result) {
                $current_path_avatar = storage_path('avatar') . '/' . $img;
                if(file_exists($current_path_avatar)){
                    unlink($current_path_avatar);
                }
                $result->image = $file;
                $result->imagename = ('avatar/').$avatar.'.'.$img->getClientOriginalExtension();
                $result->name = $name;
                $result->mail = $mail;
                $result->save();
            }
            else{
                $result = new DataUser;
                $result->image = $file;
                $result->imagename = ('avatar/').$avatar.'.'.$img->getClientOriginalExtension();
                $result->name = $name;
                $result->mail = $mail;
                $result->save();
            }
        }

        $res['success'] = true;
        $res['message'] = "Success update user profile.";
        $res['data'] = $result;
        return $res;
    }

    public function upload2(Request $request){
        $this->validate($request, array(
            'name' => 'required',
            'mail' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ));
        $datauser = new DataUser;
        $datauser->name = $request->name;
        $datauser->mail = $request->mail;
        if($request->hasFile('image')){
            $image = $request->file('image')->move(storage_path('avatar'));
            //$filename = time() . '.' . $image->getClientOriginalExtension();
            //Image::make($image)->resize(300, 300)->save( storage_path('/uploads/' . $filename ) );
            $datauser->image = $image;
            $datauser->save();
        }
        $datauser->save();
        $res['success'] = true;
        $res['message'] = "Success update user profile.";
        $res['data'] = $datauser;
        return $res;

    }

    public function upload3(Request $request){
        $this->validate($request, array(
            'id' => 'required|integer',
            'name' => 'required|string',
            'mail' => 'required|string',
            'image' => 'required|image',
        ));
        $id = $request->input('id');
        $name = $request->input('name');
        $mail = $request->input('mail');
        $avatar = Str::random(5);
        //$request->file('image');
        $image = $request->file('image')->move(storage_path('avatar'), $avatar);

        $user_profile = DataUser::where('id', $id)->first();
        if ($user_profile) {
            /*$current_avatar_path = storage_path('avatar') . '/' . $user_profile->avatar;
            if (file_exists($current_avatar_path)) {
                unlink($current_avatar_path);
            }*/
            $user_profile->id = $request->id;
            $user_profile->image = $image;
            $user_profile->name = $request->name;
            $user_profile->mail = $request->mail;
            $user_profile->save();

            /*}else{
            $user_profile = new UserProfile;
            $user_profile->id = $request->id;
            $user_profile->avatar = $avatar;
            $user_profile->name = $request->name;
            $user_profile->mail = $request->mail;
            $user_profile->save();*/

        }
        $res['success'] = true;
        $res['message'] = "Success update user profile.";
        $res['data'] = $user_profile;
        return $res;

    }

    public function get_avatar($name)
    {
        $avatar_path = storage_path('avatar') . '/' . $name;
        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
        $res['success'] = false;
        $res['message'] = "Avatar not found";

        return $res;
      }
}
