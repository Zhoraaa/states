<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //
    public function postSave(Request $postRaw)
    {

        $postData = $postRaw->validate([
            "theme" => "required",
            "text" => "required",
        ]);

        $postType = ($postRaw->reply_to) ? 2 : 1;
        $postType = ($postRaw->category) ? $postRaw->category : $postType;

        if (!$postRaw->post_id) {
            $post_id = Post::insertGetId([
                'theme' => $postRaw->theme,
                'text' => $postRaw->text,
                'category_id' => $postType,
                'author_id' => Auth::id(),
                'reply_to' => (!empty($postRaw->reply_to)) ? $postRaw->reply_to : null,
            ]);
        } else {
            $post = Post::find($postRaw->post_id)
                ->update([
                    'theme' => $postRaw->theme,
                    'text' => $postRaw->text,
                    'updated_at'
                ]);
            $post_id = $postRaw->post_id;
        }

        return redirect()->route('seePost', ['id' => $post_id]);
    }
    public function allPosts()
    {
        $data['posts'] = Post::join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.login as author')
            ->where('category_id', 1)
            ->paginate(5);

        return view("home", compact("data"));
    }
    public function seePost($id)
    {
        $post = Post::join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.login as author')
            ->where("posts.id", $id)
            ->first();

        $theme = ['firstPost' => $post];

        if ($post) {
            $replies = optional($post->replies)->toArray();
            $theme += ['replies' => $replies];
        }

        // dd($theme);

        return view("post.only", compact("theme"));
    }
    public function postEditor(Request $request)
    {
        $post = Post::find($request->id);

        $reply_to = $request->idToReply;

        if ($reply_to) {
            return view("post.editor", compact('reply_to'));
        }

        return view("post.editor", compact('post'));
    }
    public function postDelete(Request $request)
    {
        $post = DB::table("posts")->where('id', $request->id)->delete();

        return redirect()->route("forum");
    }
}
