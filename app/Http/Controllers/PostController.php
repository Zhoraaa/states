<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    //
    public function postSave(Request $postRaw)
    {
        // dd($postRaw);
        $postData = $postRaw->validate([
            "theme" => "required",
            "text" => "required",
            "category" => "required"
        ]);

        if (!$postRaw->post_id) {
            $post_id = Post::insertGetId([
                'theme' => $postRaw->theme,
                'text' => $postRaw->text,
                'category_id' => $postRaw->category,
                'author_id' => Auth::id(),
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
        // dd($postRaw->id);
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
        $data['post'] = Post::join('users', 'posts.author_id', '=', 'users.id')
            ->select('posts.*', 'users.login as author')
            ->where("posts.id", $id)
            ->first();

        $data['comments'] = Comment::where('post_id', $id)
            ->join('users', 'users.id', 'comments.author_id')
            ->select('comments.*', 'users.login as author')
            ->paginate(15);

        $data['likes'] = Like::where('post_id', $id)
            ->where('dislike', '0')
            ->count();
        // dd($data['like']);

        $data['dislikes'] = Like::where('post_id', $id)
            ->where('dislike', '1')
            ->count();

        return view("post.only", compact("data"));
    }
    public function postEditor(Request $request)
    {
        $data['post'] = Post::find($request->id);

        $data['categories'] = Category::get();

        return view("post.editor", compact('data'));
    }
    public function postDelete(Request $request)
    {
        $post = DB::table("posts")->where('id', $request->id)->delete();

        return redirect()->route("home");
    }
    public function block($id) {
        $post = Post::find($id);

        $post->update([
            'blocked' => !$post->blocked
        ]);

        return redirect()->back()->with('success','Статус изменён');
    }
}
