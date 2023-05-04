<?php

namespace App\Http\Controllers\Front;

use App\Models\Member;
use App\Models\News;
use Illuminate\Http\Request;

class IndexController
{
    public function __invoke(Request $request)
    {
        $latests = News::latest()->take(4)->get();
        $members = Member::latest()->take(6)->get();

        return view('Front.index', compact('latests', 'members'));
    }
}
