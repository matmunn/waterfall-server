<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Events\UserAdded;
use App\Events\UserEdited;
use App\Events\UserDeleted;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function getAllUsers()
    {
        $users = User::select('id', 'name', 'email', 'created_at', 'updated_at', 'category_id')
            ->get();

        return response()->json($users, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createUser(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $category = Category::find($request->category);
        $category->users()->save($user);

        $user->createToken()->save();

        event(new UserAdded($user));

        return response()->json($user, 201, [], JSON_NUMERIC_CHECK);
    }

    public function updateUser(User $user, Request $request)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->category_id = $request->category;

        if (strlen($request->password) > 0) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        event(new UserEdited($user));

        return response()->json($user, 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteUser(User $user)
    {
        $userId = $user->id;
        $user->tasks->each(function ($task) {
            $task->delete();
        });

        $user->delete();

        event(new UserDeleted($userId));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }
}
