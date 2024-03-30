<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //

    public function react($post_id, $clarification)
    {
        $hasLike = Like::where('author_id', Auth::user()->id)
            ->where('state_id', $post_id)
            ->where('dislike', $clarification)
            ->first(); // Получаем только одну запись

        if ($hasLike) {
            $hasLike->delete();
        } else {
            Like::create([
                'author_id' => Auth::user()->id, // Исправлено: заменена запятая на =>
                'state_id' => $post_id, // Исправлено: заменена запятая на =>
                'dislike' => $clarification // Исправлено: заменена запятая на =>
            ]);
        }

        return response()->json(['message' => 'Запрос успешно обработан', 'data' => 'Пинг']);
    }
}
