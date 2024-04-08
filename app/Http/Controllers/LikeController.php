<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //

    public function react($id, $react)
    {
        switch ($react) {
            default:
                $dislike = 0;
                break;
            case 'dislike':
                $dislike = 1;
                break;
        }

        $hasLike = Like::where('author_id', Auth::user()->id)
            ->where('post_id', $id)
            ->first();

        $allDone = (isset($hasLike) && $dislike === $hasLike->dislike) ? true : false;

        if ($hasLike) {
            $hasLike->delete();
        }

        if ($allDone) {
            return redirect()->back()->with('success', 'Реакт удалён!');
        } else {
            Like::create([
                'author_id' => Auth::user()->id,
                'post_id' => $id,
                'dislike' => $dislike
            ]);

            return redirect()->back()->with('success', 'Реакт проставлен!');
        }
        return redirect()->back()->with('error', 'Неизвестная ошибка');
    }
}
