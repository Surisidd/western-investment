<?php

namespace App\Http\Controllers;

use App\Mail\EmailCredentials;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   
    public function index()
    {
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'admin');
                $q->orWhere('name','user');
            }
        )->get();
        // $users=User::all();
        return view('users.index',
        [
            'users'=>$users
        ]);
    }

    public function create()
    {
        if(Auth::user()->is_superadmin){
            $roles=Role::all();

        } elseif(Auth::user()->is_admin){
            $roles=Role::all()->except(3);
        } else {
            abort(404);
        }
        return view('users.create',[
            'roles'=>$roles
        ]);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'=>'required',
            'email' => 'required|unique:users|max:255|email:rfc,dns',
            'role' => 'required',
        ]);

        $password=Str::random(10);

        $user=new User;
        $user->name= $request->name;
        $user->email=$request->email;
        $user->password=Hash::make($password);
        $user->save();


    
        $user->roles()->attach($request->role);

        // Send Email To Clients With Credentials
        Mail::to($user->email)->send(new EmailCredentials($user,$password ));

        return redirect('/user')->with('success','User Added Successully');
    }

   
    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {

        if(Auth::user()->is_superadmin){
            $roles=Role::all();

        } elseif(Auth::user()->is_admin){
            $roles=Role::where('name','admin')->orWhere('name','user')->get();
        }

        return view('users.edit',[
            'user'=>$user,
            'roles' =>$roles,
            'selectedRole'=>$user->roles->first()->id,
           
            
        ]);
    }

   
    public function update(Request $request,User $user)
    {
        $user->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        $user->roles()->sync($request->role);

        return back()->with('success','User Updated!');
    }

    public function destroy(User $user)
    {
            $user->delete();
            return redirect('/user')->with('success','User Deleted!');    
    }
}
