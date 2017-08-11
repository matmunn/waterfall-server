<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function attemptLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $creds = [
            "email" => $request->get('email'),
            "password" => $request->get("password")
        ];

        if (Auth::attempt($creds)) {
            $user = User::where('email', $request->email)->first();
            $user->makeVisible('api_token');

            return response()->json($user, 200);
        }

        return response()->json("Error", 401);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:10'],
        ]);

        $group = new Group;
        $group->save();

        $category = $group->categories()->create([
            'description' => "Managers",
            'hex_color' => '07a8eb',
            'display_in_list' => true,
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->category_id = $category->id;
        $user->createToken();

        $group->users()->save($user);

        $group->created_by = $user->id;
        $group->save();

        $user->makeVisible('api_token');

        return response()->json($user, 201);
    }
}
