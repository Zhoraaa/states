<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function commNew(Request $commRaw, $id)
    {
        $commRaw->validate([
            'commText' => 'required'
        ], [
            'commText.required' => 'А текст будет?'
        ]);

        Comment::create([
            'post_id' => $id,
            'author_id' => Auth::user()->id,
            'text' => $commRaw->commText,
        ]);

        return redirect()->back()->with('success', 'Есть коммент!');
    }

    public function commDel($id) {
        Comment::find($id)->delete();
        
        return redirect()->back()->with('success', 'RIP коммент.');
    }
}
