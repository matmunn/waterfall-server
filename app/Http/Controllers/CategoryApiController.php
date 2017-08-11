<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Events\CategoryAdded;
use App\Events\CategoryEdited;
use App\Events\CategoryDeleted;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateOrUpdateCategory;

class CategoryApiController extends Controller
{
    public function getAllCategories()
    {
        $categories = Category::all();

        return response()->json($categories, 200, [], JSON_NUMERIC_CHECK);
    }

    public function createCategory(CreateOrUpdateCategory $request)
    {
        $category = new Category;
        $category->description = $request->description;
        $category->hex_color = $request->color;
        $category->display_in_list = $request->visible;
        $category->group_id = Auth::user()->group_id;
        $category->save();

        event(new CategoryAdded($category));

        return response()->json($category, 201, [], JSON_NUMERIC_CHECK);
    }

    public function updateCategory(Category $category, CreateOrUpdateCategory $request)
    {
        $category->description = $request->description;
        $category->hex_color = $request->color;
        $category->display_in_list = $request->visible;
        $category->save();

        event(new CategoryEdited($category));

        return response()->json($category, 200, [], JSON_NUMERIC_CHECK);
    }

    public function deleteCategory(Category $category)
    {
        $categoryId = $category->id;
        $category->users->each(function ($user) {
            $user->tasks->each(function ($task) {
                $task->delete();
            });
            $user->delete();
        });
        $category->delete();

        event(new CategoryDeleted($categoryId));

        return response()->json("OK", 200, [], JSON_NUMERIC_CHECK);
    }
}
