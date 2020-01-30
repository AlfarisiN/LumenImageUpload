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
use Symfony\Component\VarDumper\Cloner\Data;

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
        $id_image = $request->input('id_image');
        $name = $request->input('name');
        $mail = $request->input('mail');
        $image = $request->file(['image']);
        $querycek = DataUser::where('id_image', $id_image)->first();
        if ($querycek){
            DataUser::where('id_image', $id_image)->delete();
            foreach ($image as $img){
                $avatar = Str::random(5);
                $file = $img->move(storage_path('avatar'), $avatar . '.'.$img->getClientOriginalExtension());
                $result = new DataUser;
                $result->image = $file;
                $result->imagename = ('avatar/').$avatar.'.'.$img->getClientOriginalExtension();
                $result->name = $name;
                $result->mail = $mail;
                $result->id_image = $id_image;
                $result->save();
            }

        }else {
            foreach ($image as $img) {
                $avatar = Str::random(5);
                $file = $img->move(storage_path('avatar'), $avatar . '.' . $img->getClientOriginalExtension());
                $result = new DataUser;
                $result->image = $file;
                $result->imagename = ('avatar/') . $avatar . '.' . $img->getClientOriginalExtension();
                $result->name = $name;
                $result->mail = $mail;
                $result->id_image = $id_image;
                $result->save();
            }
        }
        $res['success'] = true;
        $res['message'] = "Success update user profile.";
//        $res['data'] = $result;
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
