<?php

namespace App\Http\Controllers\User;

use App\Mail\VerifyMail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $user;

    public function __construct(){
        $this->middleware('auth');
    }


    public function index()
    {
        $user = Auth::user();

        $projects = $user->projects;
        return view('user.index', array('user'=>$user, 'projects' => $projects));
    }


    public function edit(User $user)
    {
        return view('user.edit', array('user'=> $user));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->except('password'));

        return redirect()->route('user.profile');
    }

    public static function unchecked_ntfs(){
        $user  = Auth::user();
        $notifications = [];
        $unchecked = [];
        if(!is_null($user->follower)){
            $notifications = $user->follower->notifications()->orderBy('created_at')->get();
            $unchecked = $user->follower->notifications()->where('checked', false)->orderBy('created_at')->get();
        }
        

        return ['ntfs'=>$notifications, 'unchecked'=>$unchecked];
    }

    public function notifications(){
        $all = self::unchecked_ntfs();
        $notifications = $all['ntfs'];
        $unchecked = $all['unchecked'];


        foreach ($unchecked as $ntf){
            $ntf->update([
                'checked'=>true
            ]);
        }

        return view('user.notifications.index', compact('notifications'));


    }

    public function users_list(){
        $users = User::whereNotIn('id', [Auth::id()])->get();
        
        return view('user.list', compact('users'));
    }

    public function visit($id){
        $visited_user = User::find($id);
        $projects = $visited_user->projects();
        return view('user.index', array('user'=>$visited_user,'projects'=>$projects));
    }

}
