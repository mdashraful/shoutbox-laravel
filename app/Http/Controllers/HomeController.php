<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Status;
use App\Models\User as ModelsUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function shoutHome(){
        $userId = Auth::id();
        $status = Auth::user()->friendsStatus()->orderBy('created_at', 'desc')->get();

        if(Friend::where('user_id', $userId)->where('friend_id', $userId)->count()==0){
            $friendship = new Friend();
            $friendship->user_id = $userId;
            $friendship->friend_id = $userId;
            $friendship->save();
        }
        //$status = Status::where('user_id',$userId)->orderBy('id', 'desc')->get();
        //$avatar = empty(Auth::user()->avatar) ? asset('images/avatar.jpg') : Auth::user()->avatar;
        
        return view('shouthome', [
            'status' => $status,
            //'avatar' => $avatar  
        ]);
    }

    public function saveShout(Request $request){
        if(Auth::check()){
            $userId = Auth::id();
            $status = $request->post('status');

            $statusModel = new Status();
            $statusModel->user_id = $userId;
            $statusModel->status = $status;
            $statusModel->save();

            return redirect()->route('shout');
        }
    }

    public function profile()
    {
        return view('profile');
    }

    public function saveProfile(Request $request){
        if(Auth::check()){
            $user = Auth::user();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->nickname = $request->nickname;
            $profileImage = "user".$user->id.".".$request->image->extension();
            $request->image->move(public_path('images'), $profileImage);
            
            $user->avatar = asset("images/{$profileImage}");

            $user->save();
            return redirect()->route('shout.profile');
        }
    }

    public function publicTimeline($nickname){
        $user = User::where('nickname', $nickname)->first();
        
        if($user){
            $status = Status::where('user_id', $user->id)->orderBy('id','desc')->get();
            $avatar = empty($user->avatar) ? asset('images/avatar.jpg') : $user->avatar;
            $name = $user->name;
            $displayAction = false;
            $friend = false;
            if(Auth::check()){
                if(Auth::user()->id != $user->id){
                    $displayAction = true;
                }
                if(Friend::where('user_id', Auth::id())->where('friend_id',$user->id)->count()>0){
                    $friend = true; 
                }
            }

            

            return view('shoutpublic', [
                'status' => $status,
                'avatar' => $avatar,
                'name' => $name,
                'displayAction' => $displayAction, 
                'friendId' => $user->id,
                'friend' => $friend
            ]);
        }else{
            return redirect('/');
        }
    }

    public function makeFriend($friendId)
    {
        $userId = Auth::id();
       
        if(Friend::where('user_id', $userId)->where('friend_id',$friendId)->count()==0){
            $friendship = new Friend();
            $friendship->user_id = $userId;
            $friendship->friend_id = $friendId;
            $friendship->save();

            $friendship = new Friend();
            $friendship->friend_id = $userId;
            $friendship->user_id = $friendId;
            $friendship->save();

            return redirect()->route('shout');
        }
        return redirect()->route('shout');
    }

    public function unFriend($friendId){
        $userId = Auth::id();

        Friend::where('user_id',$userId)->where('friend_id',$friendId)->delete();
        Friend::where('user_id',$friendId)->where('friend_id',$userId)->delete();
        
        return redirect()->route('shout');
    }
}
