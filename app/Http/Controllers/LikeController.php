<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //

    public function like(Request $request)
    {
        $hasLike = Like::where('author_id', Auth::user()->id)
            ->where('state_id', $request->id)
            ->where('dislike', $request->dislike)
            ->get();

        if ($hasLike) {
            $hasLike->delete();
        } else {
            Like::create([
                'author_id', Auth::user()->id,
                'state_id', $request->author_id,
                'dislike', $request->dislike
            ]);
        }

        return redirect()->back();
    }
}
