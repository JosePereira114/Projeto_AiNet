<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
      $allUsers = User::where('type','!=','C')->orderBy('name')->paginate(20);
      return view('users.index',compact('allUsers'));
    }

    public function show(User $user): View
    {
        return view('users.show',compact('user'));
    }

    public function create(): View
    {
        $newUser = new User();
        return view('users.create')->with('user',$newUser);
    }

    public function store(UserFormRequest $request): RerectResponse
    {
        $validatedData=$request->validated();
        $validatedData['password'] = bcrypt('123');
        $newUser = User::create($validatedData);
        $url = route('users.show', ['user' => $newUser]);
        $htmlMessage = "User <a href='$url'><u>{$newUser->name}</u></a> has been created successfully!";
        return redirect()->route('users.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }

    public function edit(User $user): View
    {
        return view('users.edit')->with('user',$user);
    }

    public function update(UserFormRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());
        $url = route('users.show', ['user' => $user]);
        $htmlMessage = "User <a href='$url'><u>{$user->name}</u></a> has been updated successfully!";
        return redirect()->route('users.index')
        ->with('alert-type', 'success')
        ->with('alert-msg', $htmlMessage);
    }

    public function destroy(User $user): RedirectResponse
    {
        try{
            $user->delete();
            return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', "User <u>$user->name</u> has been deleted successfully");
        }catch(\Exception $e){
            return redirect()->route('users.index')
            ->with('alert-type', 'danger')
            ->with('alert-msg', "User <u>$user->name</u> cannot be deleted because it has related data");
        }
    }

    public function destroyPhoto(User $user): RedirectResponse
    {
      if($user->photo_filename){
        if(Storage::fileExists('public/photos/'.$user->photo_filename)){
          Storage::delete('public/photos/'.$user->photo_filename);
        }
          $user->photo_filename=null;
          $user->save();
          return redirect()->back()
          ->with('alert-type','success')
          ->with('alert-message',"Photo of user {$user->name} has been deleted successfully");
      }
      return redirect()->back();
        
    }
    public function updateBlocked(User $user){
        $user->blocked=!$user->blocked;
        $msg = $user->blocked ? 'blocked' : 'unblocked';
        $htmlMessage = "User <u>$user->name</u> has been $msg";
        return redirect()->back()
        ->with('alert-type','success')
        ->with('alert-message',$htmlMessage);
    }



}
