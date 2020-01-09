<?php

namespace App\Http\Controllers;

use App\User;
use App\DataUser;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function ambildata(){
        $results = DataUser::select('id', 'name', 'image', 'mail')
        ->get();

        return response()->json($results);

    }

    public function upload(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $mail = $request->input('mail');
        
        $image = $request->file('image')->move(storage_path('avatar'));

        $result = DataUser::where('id', $id)->first();
        if($result) {
            $current_path_avatar = storage_path('avatar') . '/' . $image;
            if(file_exists($current_path_avatar)){
                unlink($current_path_avatar);
            }
            $result->image = $image;
            $result->name = $name;
            $result->mail = $mail;
            $result->save();
        }
        else{
            $result = new DataUser;
            $result->image = $image;
            $result->name = $name;
            $result->mail = $mail;
            $result->save();
        }
        $res['success'] = true;
        $res['message'] = "Success update user profile.";
        $res['data'] = $result;
        return $res;
    }
    public function get_avatar()
    {
        //$name = $request->input('name');
        $avatar_path = storage_path('avatar') . '/' . 'tmp5F6D.tmp';
        if (file_exists($avatar_path)) {
            $file = file_get_contents($avatar_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
        $res['success'] = false;
        $res['message'] = "Avatar not found";
        
        return $res;
    }
    public function readData(){
        echo 'hello_world';
    }
}