<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entry;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard()
    {
        $entries = Entry::orderBy('user_id')->get();

        $entries = $entries->sortBy(function ($item, $key) {
            return $item->user->category->id;
        });

        $dates = [
            'start' => (new Carbon)->startOfWeek(),
            'end' => (new Carbon)->endOfWeek()
        ];

        return view('dashboard', compact('entries', 'dates'));
    }
}
