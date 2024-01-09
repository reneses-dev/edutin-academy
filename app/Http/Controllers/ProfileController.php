<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Article;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function show(Profile $profile)
    {
        $articles = Article::where([
            ['user_id', $profile->user_id], 
            ['status', '1']])->simplePaginate(8);

        return view('subscriber.profiles.show', compact('profile', 'articles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        $this->authorize('view', $profile);
        return view('subscriber.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        $user = User::find(Auth::id());

        if($request->hasFile('photo')){
            File::delete(public_path('storage/'.$profile->photo));
            $photo = $request['photo']->store('profiles');
        }else{
            $photo = $user->profile->photo;
        }

        $user->profile->photo = $photo;

        //Asignar nombre y correo 
        $user->name = $request->name; 
        $user->email = $request->email;

        //Asignar campos adicionales 
        $user->profile->profession = $request->profession;
        $user->profile->about = $request->about;
        $user->profile->photo = $photo;
        $user->profile->twitter = $request->twitter;
        $user->profile->linkedin = $request->linkedin;
        $user->profile->facebook = $request->facebook; 

        $user->save();
        $user->profile->save();

        return redirect()->route('profiles.edit', $user->profile->id);
    }

}