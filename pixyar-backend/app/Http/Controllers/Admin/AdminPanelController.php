<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request,$idprofile)
    {
        $id = Auth::id();
       $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $posts = InstagramPost::where('profile_id', $idprofile)->get();
        return view ('admin.PanelAdmin',compact('profiles','posts'));
    }
      public function showpost(Request $request,$idprofile,$idpost)
    {
        $id = Auth::id();
       $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $post = InstagramPost::with(['profile.user','comments'])->where('profile_id', $idprofile)->where('id',$idpost)->first();

$likes = Http::get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
    'url' => 'https://instagram-social-api.p.rapidapi.com/v1/likes',
    'host' => 'instagram-social-api.p.rapidapi.com',
    'code_or_id_or_url' => $post->shortcode
]);

$likes = $likes->json();


        return view ('admin.PanelAdminShowPost',compact('profiles','post','likes'));
    }
    public function select(Request $request)
    {
        $id = Auth::id();
       $profiles = InstagramProfile::where('user_id', $id)->get();


        return view ('admin.select-profile',compact('profiles'));
    }

     public function starter(Request $request)
    {
        return view ('profile');
    }


}
